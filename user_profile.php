<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current user details
$query = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// -----------------------------
// Label Functions
// -----------------------------
function get_sugar_label($value) {
    if ($value < 70) return 'Very Low';
    elseif ($value < 80) return 'Low';
    elseif ($value < 90) return 'Little Low';
    elseif ($value <= 120) return 'Normal';
    elseif ($value <= 140) return 'Little High';
    elseif ($value <= 180) return 'High';
    else return 'Very High';
}

function get_cholostrol_label($value) {
    if ($value < 120) return 'Very Low';
    elseif ($value < 160) return 'Low';
    elseif ($value < 180) return 'Little Low';
    elseif ($value <= 200) return 'Normal';
    elseif ($value <= 240) return 'Little High';
    elseif ($value <= 280) return 'High';
    else return 'Very High';
}

function get_pressure_label($systolic, $diastolic) {
    if ($systolic < 90 || $diastolic < 60) return 'Very Low';
    elseif ($systolic < 100 || $diastolic < 65) return 'Low';
    elseif ($systolic < 110 || $diastolic < 70) return 'Little Low';
    elseif ($systolic <= 120 && $diastolic <= 80) return 'Normal';
    elseif ($systolic <= 130 || $diastolic <= 85) return 'Little High';
    elseif ($systolic <= 140 || $diastolic <= 90) return 'High';
    else return 'Very High';
}

// -----------------------------
// Handle update
// -----------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $success = '';

    // Validate and sanitize inputs
    $first_name = mysqli_real_escape_string($conn, trim($_POST['first_name']));
    $last_name = mysqli_real_escape_string($conn, trim($_POST['last_name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone_number = mysqli_real_escape_string($conn, trim($_POST['phone_number']));
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
    $weight_kg = floatval($_POST['weight_kg']);
    $height_cm = floatval($_POST['height_cm']);
    $activity_level = mysqli_real_escape_string($conn, $_POST['activity_level']);
    $dietary_pref = mysqli_real_escape_string($conn, $_POST['dietary_pref']);
    $fitness_goal = mysqli_real_escape_string($conn, $_POST['fitness_goal']);
    $disease = mysqli_real_escape_string($conn, trim($_POST['disease']));
    $allergy = mysqli_real_escape_string($conn, trim($_POST['allergy']));

    // New health inputs
    $sugar_value = floatval($_POST['sugar_value']);
    $cholostrol_value = floatval($_POST['cholostrol_value']);
    $systolic_pressure = intval($_POST['systolic_pressure']);
    $diastolic_pressure = intval($_POST['diastolic_pressure']);

    // Validation rules
    if (empty($first_name)) $errors[] = "First name is required";
    if (empty($last_name)) $errors[] = "Last name is required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if ($weight_kg <= 0) $errors[] = "Weight must be a positive number";
    if ($height_cm <= 0) $errors[] = "Height must be a positive number";
    if ($sugar_value <= 0) $errors[] = "Sugar value must be a positive number";
    if ($cholostrol_value <= 0) $errors[] = "Cholesterol value must be a positive number";
    if ($systolic_pressure <= 0) $errors[] = "Systolic pressure must be a positive number";
    if ($diastolic_pressure <= 0) $errors[] = "Diastolic pressure must be a positive number";
    
    // Validate date of birth and calculate age
    $dob = new DateTime($date_of_birth);
    $today = new DateTime();
    $age = $dob->diff($today)->y;
    
    if ($age < 13) $errors[] = "You must be at least 13 years old";
    if ($age > 120) $errors[] = "Please enter a valid date of birth";

    // If no validation errors, proceed with update
    if (empty($errors)) {
        // Calculate labels
        $sugar_label = get_sugar_label($sugar_value);
        $cholostrol_label = get_cholostrol_label($cholostrol_value);
        $pressure_label = get_pressure_label($systolic_pressure, $diastolic_pressure);

        // Handle profile picture
        $profile_picture_sql = "";
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['name'] != '') {
            $file_name = time().'_'.basename($_FILES['profile_picture']['name']);
            $target_path = 'uploads/'.$file_name;
            
            // Validate file type
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $file_type = $_FILES['profile_picture']['type'];
            
            if (!in_array($file_type, $allowed_types)) {
                $errors[] = "Only JPG, PNG, and GIF files are allowed";
            } else {
                // Validate file size (max 2MB)
                if ($_FILES['profile_picture']['size'] > 2097152) {
                    $errors[] = "File size must be less than 2MB";
                } else {
                    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_path)) {
                        $profile_picture_sql = ", profile_picture='$target_path'";
                    } else {
                        $errors[] = "Error uploading profile picture";
                    }
                }
            }
        }

        // If still no errors after file validation, proceed with database update
        if (empty($errors)) {
            // Recalculate BMI, BMR, and calories per kg
            $bmi = ($height_cm > 0) ? round($weight_kg / (($height_cm/100)**2), 2) : 0;
            if ($gender == 'Male') {
                $bmr = round(10*$weight_kg + 6.25*$height_cm - 5*$age + 5);
            } else {
                $bmr = round(10*$weight_kg + 6.25*$height_cm - 5*$age - 161);
            }
            $calories_per_kg = ($weight_kg > 0) ? round($bmr / $weight_kg, 2) : 0;

            // Check tracked fields for changes
            $fields_to_track = [
                'weight_kg','height_cm','bmi','bmr','calories_per_kg','activity_level',
                'dietary_pref','fitness_goal','disease','allergy',
                'sugar_value','cholostrol_value','systolic_pressure','diastolic_pressure',
                'sugar_label','cholostrol_label','pressure_label','age'
            ];
            $has_changed = false;
            foreach ($fields_to_track as $field) {
                $new_val = $$field ?? '';
                $old_val = $user[$field] ?? '';
                if (is_numeric($new_val)) {
                    if (floatval($old_val) !== floatval($new_val)) { $has_changed = true; break; }
                } else {
                    if (trim($old_val) !== trim($new_val)) { $has_changed = true; break; }
                }
            }

            // Update users table
            $update_query = "UPDATE users SET
                first_name='$first_name',
                last_name='$last_name',
                email='$email',
                phone_number='$phone_number',
                gender='$gender',
                date_of_birth='$date_of_birth',
                age='$age',
                weight_kg='$weight_kg',
                height_cm='$height_cm',
                bmi='$bmi',
                bmr='$bmr',
                calories_per_kg='$calories_per_kg',
                activity_level='$activity_level',
                dietary_pref='$dietary_pref',
                fitness_goal='$fitness_goal',
                disease='$disease',
                allergy='$allergy',
                sugar_value='$sugar_value',
                cholostrol_value='$cholostrol_value',
                systolic_pressure='$systolic_pressure',
                diastolic_pressure='$diastolic_pressure',
                sugar_label='$sugar_label',
                cholostrol_label='$cholostrol_label',
                pressure_label='$pressure_label'
                $profile_picture_sql
                WHERE user_id='$user_id'";
                
            if (mysqli_query($conn, $update_query)) {
                // Insert into user_tracking if changes detected
                if ($has_changed) {
                    $insert_query = "INSERT INTO user_tracking 
                        (user_id, weight_kg, height_cm, bmi, bmr, calories_per_kg, activity_level, dietary_pref, fitness_goal, 
                        disease, sugar_value, cholostrol_value, systolic_pressure, diastolic_pressure, sugar_label, cholostrol_label, 
                        pressure_label, allergy, age, status, created_at) 
                        VALUES
                        ('$user_id', '$weight_kg', '$height_cm', '$bmi', '$bmr', '$calories_per_kg', '$activity_level', 
                        '$dietary_pref', '$fitness_goal', '$disease', '$sugar_value', '$cholostrol_value', '$systolic_pressure', 
                        '$diastolic_pressure', '$sugar_label', '$cholostrol_label', '$pressure_label', '$allergy', '$age', 'active', NOW())";
                    mysqli_query($conn, $insert_query);
                }

                // -------------------------------
                // Run model_determine.py
                // -------------------------------
                $command_determine = "python model_determine.py " . $user_id;
                $output_determine = [];
                $return_determine = 0;
                exec($command_determine . " 2>&1", $output_determine, $return_determine);

                if (!is_dir("logs")) mkdir("logs", 0755, true);
                file_put_contents(
                    "logs/python_determine.log",
                    date('Y-m-d H:i:s') . " | user_id: $user_id\n" . implode("\n", $output_determine) . "\n\n",
                    FILE_APPEND
                );

                // -------------------------------
                // Run predict_fitness_goal.py
                // -------------------------------
                $command_predict = "python predict_fitness_goal.py " .
                    $user_id . " " .
                    $age . " " .
                    escapeshellarg($gender) . " " .
                    $weight_kg . " " .
                    $height_cm . " " .
                    escapeshellarg($activity_level) . " " .
                    escapeshellarg($dietary_pref) . " " .
                    escapeshellarg($disease) . " " .
                    $calories_per_kg;

                $output_predict = [];
                $return_predict = 0;
                exec($command_predict . " 2>&1", $output_predict, $return_predict);

                file_put_contents(
                    "logs/python_predict.log",
                    date('Y-m-d H:i:s') . " | user_id: $user_id\n" . implode("\n", $output_predict) . "\n\n",
                    FILE_APPEND
                );

                // -------------------------------
                // Check prediction result
                // -------------------------------
                if ($return_predict === 0) {
                    $prediction_success = false;
                    foreach ($output_predict as $line) {
                        if (strpos($line, '✅ Fitness goal updated in database!') !== false) {
                            $prediction_success = true;
                            break;
                        }
                    }

                    if ($prediction_success) {
                        $success = "🎯 Profile updated successfully! Fitness goal updated!";
                    } else {
                        $success = "✅ Profile updated successfully!";
                    }
                } else {
                    $success = "✅ Profile updated successfully! (Python script error)";
                }
                
                // Refresh user data
                $query = "SELECT * FROM users WHERE user_id='$user_id'";
                $result = mysqli_query($conn, $query);
                $user = mysqli_fetch_assoc($result);
                
            } else {
                $errors[] = "Database error: " . mysqli_error($conn);
            }
        }
    }
}

// -------------------------------
// Determine profile picture path
// -------------------------------
$profile_picture_path = (!empty($user['profile_picture']) && file_exists($user['profile_picture']))
    ? $user['profile_picture']
    : 'uploads/default.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | FitBuddy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --secondary: #7209b7;
            --accent: #4cc9f0;
            --success: #2ecc71;
            --warning: #f39c12;
            --danger: #e74c3c;
            --info: #1abc9c;
            --dark: #2b2d42;
            --light: #f8f9fa;
            --gray: #8d99ae;
            --card-bg: #ffffff;
            --border-radius: 16px;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            font-family: 'Poppins', sans-serif;
        }

        body { 
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%); 
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
        }

        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            display: grid; 
            grid-template-columns: 1fr; 
            gap: 24px; 
        }

        /* Alert Styles */
        .alert {
            padding: 15px 20px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow);
        }

        .alert-success {
            background-color: rgba(46, 204, 113, 0.15);
            color: #27ae60;
            border-left: 4px solid var(--success);
        }

        .alert-error {
            background-color: rgba(231, 76, 60, 0.15);
            color: #c0392b;
            border-left: 4px solid var(--danger);
        }

        .alert i {
            font-size: 20px;
        }

        /* Header Styles */
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 20px; 
            background: var(--card-bg);
            padding: 20px 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .header h1 { 
            color: var(--dark); 
            font-size: 28px; 
            font-weight: 700; 
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Button Styles */
        .btn { 
            padding: 12px 24px; 
            border-radius: var(--border-radius); 
            border: none; 
            cursor: pointer; 
            font-weight: 600; 
            transition: var(--transition); 
            display: inline-flex; 
            align-items: center; 
            gap: 8px; 
        }

        .btn-primary { 
            background: linear-gradient(to right, var(--primary), var(--secondary)); 
            color: white; 
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3); 
        }

        .btn-primary:hover { 
            background: linear-gradient(to right, var(--primary-dark), #5e18a5); 
            transform: translateY(-2px); 
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4); 
        }

        .btn-primary:active { 
            transform: translateY(0); 
        }

        /* Card Styles */
        .card { 
            background: var(--card-bg); 
            border-radius: var(--border-radius); 
            box-shadow: var(--shadow); 
            padding: 25px; 
            transition: var(--transition);
            border-top: 4px solid var(--primary);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        /* Profile Card */
        .profile-card { 
            display: grid; 
            grid-template-columns: 220px 1fr; 
            gap: 30px; 
            align-items: start; 
        }

        .profile-left { 
            text-align: center; 
        }

        .profile-picture { 
            position: relative; 
            width: 180px; 
            height: 180px; 
            margin: 0 auto 20px; 
            border-radius: 50%; 
            overflow: hidden; 
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); 
            border: 4px solid white; 
        }

        .profile-picture img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
        }

        .profile-picture-edit { 
            position: absolute; 
            bottom: 0; 
            right: 0; 
            background: var(--primary); 
            color: white; 
            width: 40px; 
            height: 40px; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            cursor: pointer; 
            transition: var(--transition); 
        }

        .profile-picture-edit:hover { 
            background: var(--primary-dark); 
            transform: scale(1.1);
        }

        #profilePic { 
            display: none; 
        }

        .fitness-goal { 
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); 
            color: white; 
            padding: 15px; 
            border-radius: var(--border-radius); 
            margin-top: 15px; 
            text-align: center;
        }

        .fitness-goal label { 
            display: block; 
            font-size: 14px; 
            margin-bottom: 6px; 
            font-weight: 500; 
            opacity: 0.9;
        }

        .fitness-goal .display-only,
        .fitness-goal input { 
            font-size: 16px; 
            font-weight: 600; 
        }

        .profile-right { 
            display: grid; 
            grid-template-columns: repeat(2, 1fr); 
            gap: 20px; 
        }

        /* Info Item Styles */
        .info-item { 
            margin-bottom: 16px; 
        }

        .info-item label { 
            display: block; 
            font-size: 14px; 
            color: var(--gray); 
            margin-bottom: 6px; 
            font-weight: 500; 
        }

        .info-item .display-only { 
            font-size: 16px; 
            font-weight: 600; 
            color: var(--dark); 
            min-height: 24px; 
            padding: 8px 0;
        }

        .info-item input, 
        .info-item select { 
            width: 100%; 
            padding: 12px 16px; 
            border: 2px solid #e2e8f0; 
            border-radius: var(--border-radius); 
            font-size: 16px; 
            transition: var(--transition); 
            background-color: #f8fafc; 
        }

        .info-item input:focus, 
        .info-item select:focus { 
            outline: none; 
            border-color: var(--primary); 
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2); 
            background-color: #fff; 
        }

        /* Section Title */
        .section-title { 
            font-size: 20px; 
            font-weight: 700; 
            color: var(--dark); 
            margin-bottom: 20px; 
            padding-bottom: 10px; 
            border-bottom: 2px solid #e2e8f0; 
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary);
        }

        /* Info Grid */
        .info-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 20px; 
        }

        .edit-only { 
            display: none; 
        }

        /* Health Stats */
        .health-stats { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); 
            gap: 15px; 
            margin-top: 20px; 
        }

        .stat-item { 
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); 
            padding: 20px; 
            border-radius: var(--border-radius); 
            text-align: center; 
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .stat-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-value { 
            font-size: 28px; 
            font-weight: 700; 
            color: var(--primary); 
            margin-bottom: 5px;
        }

        .stat-label { 
            font-size: 14px; 
            color: var(--gray); 
            font-weight: 500;
        }

        /* Footer */
        .footer { 
            text-align: center; 
            margin-top: 30px; 
            color: var(--gray); 
            font-size: 14px; 
            padding: 20px;
        }

        /* Responsive Design */
        @media (max-width: 900px) { 
            .profile-card { 
                grid-template-columns: 1fr; 
            } 
            
            .profile-right { 
                grid-template-columns: 1fr; 
            } 
            
            .info-grid { 
                grid-template-columns: 1fr; 
            } 
        }

        @media (max-width: 768px) { 
            .header { 
                flex-direction: column; 
                gap: 15px; 
                align-items: flex-start; 
            } 
            
            .health-stats { 
                grid-template-columns: repeat(2, 1fr); 
            } 
        }

        @media (max-width: 480px) { 
            .health-stats { 
                grid-template-columns: 1fr; 
            }
            
            .profile-picture {
                width: 150px;
                height: 150px;
            }
        }

        /* Custom form elements for health data */
        .health-input-group {
            display: flex;
            gap: 10px;
        }

        .health-input-group input {
            flex: 1;
        }

        /* Status indicators */
        .status-indicator {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
        }

        .status-normal {
            background-color: rgba(46, 204, 113, 0.2);
            color: #27ae60;
        }

        .status-high {
            background-color: rgba(231, 76, 60, 0.2);
            color: #c0392b;
        }

        .status-low {
            background-color: rgba(241, 196, 15, 0.2);
            color: #d35400;
        }

        /* Animation for form elements */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card {
            animation: fadeIn 0.5s ease forwards;
        }

        .card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .card:nth-child(3) {
            animation-delay: 0.2s;
        }
        
        /* Validation error styles */
        .error-message {
            color: var(--danger);
            font-size: 14px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .error-field {
            border-color: var(--danger) !important;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.2) !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-user-circle"></i> User Profile</h1>
            <button class="btn btn-primary" id="editBtn">
                <i class="fas fa-edit"></i> Edit Profile
            </button>
        </div>

        <!-- Display Success/Error Messages -->
        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span><?php echo $success; ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin: 10px 0 0 20px;">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" id="profileForm">
            <!-- Profile Box -->
            <div class="card profile-card">
                <div class="profile-left">
                    <div class="profile-picture">
                        <img src="<?= !empty($user['profile_picture']) ? str_replace('\\','/',$user['profile_picture']) : 'uploads/default.png' ?>" id="profilePicPreview">
                        <div class="profile-picture-edit" onclick="document.getElementById('profilePic').click()">
                            <i class="fas fa-camera"></i>
                        </div>
                        <input type="file" name="profile_picture" id="profilePic" accept="image/*">
                    </div>
                    
                    <div class="fitness-goal">
                        <label>Workout Goal</label>
                        <span class="display-only"><?= !empty($user['fitness_goal']) ? $user['fitness_goal'] : '-' ?></span>
                        <select name="fitness_goal" class="edit-only">
                            <option value="Weight Loss" <?= $user['fitness_goal']=='Weight Loss'?'selected':'' ?>>Weight Loss</option>
                            <option value="Muscle Building" <?= $user['fitness_goal']=='Muscle Building'?'selected':'' ?>>Muscle Building</option>
                            <option value="Maintain Fitness" <?= $user['fitness_goal']=='Maintain Fitness'?'selected':'' ?>>Maintain Fitness</option>
                            <option value="Weight Gain" <?= $user['fitness_goal']=='Weight Gain'?'selected':'' ?>>Weight Gain</option>
                        </select>
                    </div>
                </div>
                
                <div class="profile-right">
                    <div class="info-item">
                        <label><i class="fas fa-envelope"></i> Email</label>
                        <span class="display-only"><?= !empty($user['email']) ? $user['email'] : '-' ?></span>
                        <input type="email" name="email" class="edit-only" value="<?= !empty($user['email']) ? $user['email'] : '' ?>" required>
                    </div>
                    
                    <div class="info-item">
                        <label><i class="fas fa-phone"></i> Phone</label>
                        <span class="display-only"><?= !empty($user['phone_number']) ? $user['phone_number'] : '-' ?></span>
                        <input type="text" name="phone_number" class="edit-only" value="<?= !empty($user['phone_number']) ? $user['phone_number'] : '' ?>">
                    </div>
                    
                    <div class="info-item">
                        <label><i class="fas fa-calendar-alt"></i> Joined Date</label>
                        <span><?= date('F j, Y', strtotime($user['created_at'])) ?></span>
                    </div>
                    
                    <div class="info-item">
                        <label><i class="fas fa-user-tag"></i> User ID</label>
                        <span>#<?= $user['user_id'] ?></span>
                    </div>
                </div>
            </div>

            <!-- Personal Information Box -->
            <div class="card">
                <h2 class="section-title"><i class="fas fa-user"></i> Personal Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <label>First Name</label>
                        <span class="display-only"><?= $user['first_name'] ?></span>
                        <input type="text" name="first_name" class="edit-only" value="<?= $user['first_name'] ?>" required>
                    </div>
                    
                    <div class="info-item">
                        <label>Last Name</label>
                        <span class="display-only"><?= $user['last_name'] ?></span>
                        <input type="text" name="last_name" class="edit-only" value="<?= $user['last_name'] ?>" required>
                    </div>
                    
                    <div class="info-item">
                        <label>Gender</label>
                        <span class="display-only"><?= $user['gender'] ?></span>
                        <select name="gender" class="edit-only" required>
                            <option value="Male" <?= $user['gender']=='Male'?'selected':'' ?>>Male</option>
                            <option value="Female" <?= $user['gender']=='Female'?'selected':'' ?>>Female</option>
                            <option value="Other" <?= $user['gender']=='Other'?'selected':'' ?>>Other</option>
                        </select>
                    </div>
                    
                    <div class="info-item">
                        <label>Date of Birth</label>
                        <span class="display-only"><?= $user['date_of_birth'] ?></span>
                        <input type="date" name="date_of_birth" class="edit-only" value="<?= $user['date_of_birth'] ?>" id="dob" required>
                    </div>
                    
                    <div class="info-item">
                        <label>Age</label>
                        <span class="display-only" id="ageDisplay"><?= $user['age'] ?></span>
                        <input type="number" name="age" class="edit-only" id="ageInput" value="<?= $user['age'] ?>" readonly>
                    </div>
                    
                    <div class="info-item">
                        <label>Activity Level</label>
                        <span class="display-only"><?= $user['activity_level'] ?></span>
                        <select name="activity_level" class="edit-only" required>
                            <option value="Sedentary" <?= $user['activity_level']=='Sedentary'?'selected':'' ?>>Sedentary (little or no exercise)</option>
                            <option value="Lightly Active" <?= $user['activity_level']=='Lightly Active'?'selected':'' ?>>Lightly Active (light exercise 1-3 days/week)</option>
                            <option value="Moderately Active" <?= $user['activity_level']=='Moderately Active'?'selected':'' ?>>Moderately Active (moderate exercise 3-5 days/week)</option>
                            <option value="Very Active" <?= $user['activity_level']=='Very Active'?'selected':'' ?>>Very Active (hard exercise 6-7 days/week)</option>
                        </select>
                    </div>
                    
                    <div class="info-item">
                        <label>Dietary Preference</label>
                        <span class="display-only"><?= $user['dietary_pref'] ?></span>
                        <select name="dietary_pref" class="edit-only" required>
                            <option value="Omnivore" <?= $user['dietary_pref']=='Omnivore'?'selected':'' ?>>Omnivore</option>
                            <option value="Vegetarian" <?= $user['dietary_pref']=='Vegetarian'?'selected':'' ?>>Vegetarian</option>
                            <option value="Vegan" <?= $user['dietary_pref']=='Vegan'?'selected':'' ?>>Vegan</option>
                            <option value="Non-Vegetarian" <?= $user['dietary_pref']=='Non-Vegetarian'?'selected':'' ?>>Non-Vegetarian</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Health & Fitness Box -->
            <div class="card">
                <h2 class="section-title"><i class="fas fa-heartbeat"></i> Health & Fitness Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Weight (kg)</label>
                        <span class="display-only"><?= $user['weight_kg'] ?></span>
                        <input type="number" step="0.1" name="weight_kg" class="edit-only" value="<?= $user['weight_kg'] ?>" required min="1">
                    </div>

                    <div class="info-item">
                        <label>Height (cm)</label>
                        <span class="display-only"><?= $user['height_cm'] ?></span>
                        <input type="number" step="0.1" name="height_cm" class="edit-only" value="<?= $user['height_cm'] ?>" required min="1">
                    </div>

                    <div class="info-item">
                        <label>Sugar Value</label>
                        <span class="display-only">
                            <?= $user['sugar_value'] ?> 
                            <span class="status-indicator status-<?= 
                                ($user['sugar_label'] == 'Normal') ? 'normal' : 
                                (in_array($user['sugar_label'], ['High', 'Very High']) ? 'high' : 'low') 
                            ?>">
                                (<?= $user['sugar_label'] ?>)
                            </span>
                        </span>
                        <input type="number" name="sugar_value" class="edit-only" value="<?= $user['sugar_value'] ?>" required min="1" step="0.1">
                    </div>

                    <div class="info-item">
                        <label>Cholesterol Value</label>
                        <span class="display-only">
                            <?= $user['cholostrol_value'] ?> 
                            <span class="status-indicator status-<?= 
                                ($user['cholostrol_label'] == 'Normal') ? 'normal' : 
                                (in_array($user['cholostrol_label'], ['High', 'Very High']) ? 'high' : 'low') 
                            ?>">
                                (<?= $user['cholostrol_label'] ?>)
                            </span>
                        </span>
                        <input type="number" name="cholostrol_value" class="edit-only" value="<?= $user['cholostrol_value'] ?>" required min="1" step="0.1">
                    </div>

                    <div class="info-item">
                        <label>Blood Pressure</label>
                        <span class="display-only">
                            <?= $user['systolic_pressure'] ?>/<?= $user['diastolic_pressure'] ?> 
                            <span class="status-indicator status-<?= 
                                ($user['pressure_label'] == 'Normal') ? 'normal' : 
                                (in_array($user['pressure_label'], ['High', 'Very High']) ? 'high' : 'low') 
                            ?>">
                                (<?= $user['pressure_label'] ?>)
                            </span>
                        </span>
                        <div class="edit-only health-input-group">
                            <input type="number" name="systolic_pressure" placeholder="Systolic" value="<?= $user['systolic_pressure'] ?>" required min="1">
                            <span style="line-height: 48px;">/</span>
                            <input type="number" name="diastolic_pressure" placeholder="Diastolic" value="<?= $user['diastolic_pressure'] ?>" required min="1">
                        </div>
                    </div>

                    <div class="info-item">
                        <label>Disease</label>
                        <span class="display-only"><?= $user['disease'] ? $user['disease'] : 'None' ?></span>
                        <input type="text" name="disease" class="edit-only" value="<?= $user['disease'] ?>" placeholder="None">
                    </div>

                    <div class="info-item">
                        <label>Allergy</label>
                        <span class="display-only"><?= $user['allergy'] ? $user['allergy'] : 'None' ?></span>
                        <input type="text" name="allergy" class="edit-only" value="<?= $user['allergy'] ?>" placeholder="None">
                    </div>
                </div>
                
                <div class="health-stats">
                    <div class="stat-item">
                        <div class="stat-value"><?= !empty($user['bmi']) ? $user['bmi'] : '0' ?></div>
                        <div class="stat-label">BMI</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value"><?= !empty($user['bmr']) ? $user['bmr'] : '0' ?></div>
                        <div class="stat-label">BMR</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value"><?= !empty($user['calories_per_kg']) ? $user['calories_per_kg'] : '0' ?></div>
                        <div class="stat-label">Cal/kg</div>
                    </div>
                </div>
            </div>
        </form>
        
        <div class="footer">
            <p>&copy; 2023 FitBuddy. All rights reserved.</p>
        </div>
    </div>

    <script>
        const dobInput = document.getElementById('dob');
        const ageInput = document.getElementById('ageInput');
        const ageDisplay = document.getElementById('ageDisplay');

        // Function to calculate age from DOB
        function calculateAge(dob) {
            const birthDate = new Date(dob);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        }

        // Set initial age
        if(dobInput.value) {
            const age = calculateAge(dobInput.value);
            ageInput.value = age;
            ageDisplay.textContent = age;
        }

        // Update age when DOB changes
        dobInput.addEventListener('change', () => {
            const age = calculateAge(dobInput.value);
            ageInput.value = age;
            ageDisplay.textContent = age;
        });

        const editBtn = document.getElementById('editBtn');
        const displayEls = document.querySelectorAll('.display-only');
        const editEls = document.querySelectorAll('.edit-only');
        const profilePicInput = document.getElementById('profilePic');
        const profilePicPreview = document.getElementById('profilePicPreview');

        editBtn.addEventListener('click', ()=>{
            if(editBtn.innerHTML.includes('Edit')) {
                displayEls.forEach(el => el.style.display = 'none');
                editEls.forEach(el => el.style.display = 'block');
                editBtn.innerHTML = '<i class="fas fa-save"></i> Save Changes';
                editBtn.style.background = 'linear-gradient(to right, var(--success), var(--accent))';
            } else {
                // Validate form before submission
                let isValid = true;
                const requiredFields = document.querySelectorAll('input[required], select[required]');
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('error-field');
                        
                        // Create error message if it doesn't exist
                        if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('error-message')) {
                            const errorMsg = document.createElement('div');
                            errorMsg.className = 'error-message';
                            errorMsg.innerHTML = '<i class="fas fa-exclamation-circle"></i> This field is required';
                            field.parentNode.appendChild(errorMsg);
                        }
                    } else {
                        field.classList.remove('error-field');
                        // Remove error message if it exists
                        if (field.nextElementSibling && field.nextElementSibling.classList.contains('error-message')) {
                            field.nextElementSibling.remove();
                        }
                    }
                });
                
                // Validate numeric fields
                const numericFields = document.querySelectorAll('input[type="number"]');
                numericFields.forEach(field => {
                    if (field.value && parseFloat(field.value) <= 0) {
                        isValid = false;
                        field.classList.add('error-field');
                        
                        if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('error-message')) {
                            const errorMsg = document.createElement('div');
                            errorMsg.className = 'error-message';
                            errorMsg.innerHTML = '<i class="fas fa-exclamation-circle"></i> Must be a positive number';
                            field.parentNode.appendChild(errorMsg);
                        }
                    }
                });
                
                if (isValid) {
                    document.getElementById('profileForm').submit();
                } else {
                    // Scroll to first error
                    const firstError = document.querySelector('.error-field');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            }
        });

        profilePicInput.addEventListener('change', (e)=>{
            const file = e.target.files[0];
            if(file){
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Only JPG, PNG, and GIF files are allowed');
                    e.target.value = '';
                    return;
                }
                
                // Validate file size (max 2MB)
                if (file.size > 2097152) {
                    alert('File size must be less than 2MB');
                    e.target.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = () => { 
                    profilePicPreview.src = reader.result; 
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>