<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data from database
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process form data and update database
    $first_name = $_POST['first_name'] ?? $user['first_name'];
    $last_name = $_POST['last_name'] ?? $user['last_name'];
    $email = $_POST['email'] ?? $user['email'];
    $phone_number = $_POST['phone_number'] ?? $user['phone_number'];
    $gender = $_POST['gender'] ?? $user['gender'];
    $date_of_birth = $_POST['date_of_birth'] ?? $user['date_of_birth'];
    $age = $_POST['age'] ?? $user['age'];
    $weight_kg = $_POST['weight_kg'] ?? $user['weight_kg'];
    $height_cm = $_POST['height_cm'] ?? $user['height_cm'];
    $activity_level = $_POST['activity_level'] ?? $user['activity_level'];
    $dietary_pref = $_POST['dietary_pref'] ?? $user['dietary_pref'];
    $fitness_goal = $_POST['fitness_goal'] ?? $user['fitness_goal'];
    $disease = $_POST['disease'] ?? $user['disease'];
    $allergy = $_POST['allergy'] ?? $user['allergy'];
    $location = $_POST['location'] ?? $user['location'];
    
    // Handle profile picture upload
    $profile_picture = $user['profile_picture'];
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "uploads/";
        $file_name = time() . '_' . basename($_FILES["profile_picture"]["name"]);
        $target_file = $target_dir . $file_name;
        
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = $target_file;
            // Delete old profile picture if it exists and is not the default
            if (!empty($user['profile_picture']) && $user['profile_picture'] != 'uploads/default.png') {
                @unlink($user['profile_picture']);
            }
        }
    }
    
    // Update user in database
    $update_query = "UPDATE users SET 
        first_name = ?, last_name = ?, email = ?, phone_number = ?, 
        gender = ?, date_of_birth = ?, age = ?, weight_kg = ?, 
        height_cm = ?, activity_level = ?, dietary_pref = ?, 
        fitness_goal = ?, disease = ?, allergy = ?, location = ?, 
        profile_picture = ?, updated_at = NOW() 
        WHERE user_id = ?";
    
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssssiisssssssi", 
        $first_name, $last_name, $email, $phone_number, 
        $gender, $date_of_birth, $age, $weight_kg, 
        $height_cm, $activity_level, $dietary_pref, 
        $fitness_goal, $disease, $allergy, $location, 
        $profile_picture, $user_id
    );
    
    if ($stmt->execute()) {
        $success_message = "Profile updated successfully!";
        // Refresh user data
        $result = $conn->query("SELECT * FROM users WHERE user_id = $user_id");
        $user = $result->fetch_assoc();
    } else {
        $error_message = "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - FitBuddy</title>
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
            --light-gray: #e9ecef;
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
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            height: 90vh;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 30px 0;
            display: flex;
            flex-direction: column;
        }

        .profile-summary {
            text-align: center;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 20px;
        }

        .profile-pic {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .profile-summary h3 {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 18px;
        }

        .profile-summary p {
            font-size: 14px;
            opacity: 0.9;
            background: rgba(255, 255, 255, 0.1);
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
        }

        .nav-links {
            list-style: none;
            flex-grow: 1;
        }

        .nav-links li {
            margin-bottom: 5px;
        }

        .nav-links a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: white;
            text-decoration: none;
            transition: var(--transition);
        }

        .nav-links a:hover, .nav-links a.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--accent);
        }

        .nav-links i {
            margin-right: 12px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 15px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 12px;
            opacity: 0.7;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: var(--light);
            border-radius: 50px;
            padding: 10px 20px;
            width: 250px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            padding: 5px;
            width: 100%;
            font-size: 14px;
        }

        .settings-section {
            margin-bottom: 40px;
            background: var(--card-bg);
            padding: 25px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-gray);
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--light-gray);
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: var(--transition);
            background-color: #fafbfc;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            outline: none;
            background-color: #fff;
        }

        .row {
            display: flex;
            gap: 20px;
        }

        .col {
            flex: 1;
        }

        .btn {
            padding: 14px 28px;
            border: none;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #5e18a5 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--gray);
            color: var(--gray);
        }

        .btn-outline:hover {
            background-color: var(--light-gray);
        }

        .toggle-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid var(--light-gray);
        }

        .toggle-info h4 {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--dark);
        }

        .toggle-info p {
            font-size: 14px;
            color: var(--gray);
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: var(--transition);
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: var(--transition);
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary);
        }

        input:checked + .slider:before {
            transform: translateX(24px);
        }

        .danger-zone {
            border: 1px solid #ffcccc;
            border-radius: var(--border-radius);
            padding: 25px;
            background-color: #fff5f5;
        }

        .danger-zone .section-title {
            color: var(--danger);
            border-bottom: 2px solid #ffcccc;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger) 0%, #c1121f 100%);
            color: white;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #d1144a 0%, #a1121f 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(231, 76, 60, 0.4);
        }

        .alert {
            padding: 15px 20px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .profile-picture-upload {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .profile-picture-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .upload-btn {
            display: inline-block;
            padding: 12px 20px;
            background: var(--light);
            border: 2px dashed var(--gray);
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }

        .upload-btn:hover {
            border-color: var(--primary);
            background-color: #f0f4ff;
        }

        /* Responsive design */
        @media (max-width: 900px) {
            .container {
                flex-direction: column;
                height: auto;
            }
            
            .sidebar {
                width: 100%;
                order: 2;
            }
            
            .row {
                flex-direction: column;
                gap: 0;
            }
            
            .main-content {
                order: 1;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .search-box {
                width: 100%;
            }
        }

        /* Animation for form elements */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .settings-section {
            animation: fadeIn 0.5s ease forwards;
        }

        .settings-section:nth-child(2) {
            animation-delay: 0.1s;
        }

        .settings-section:nth-child(3) {
            animation-delay: 0.2s;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar Navigation -->
        <div class="sidebar">
            <div class="profile-summary">
                <img src="<?php echo !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'uploads/default.png'; ?>" alt="Profile" class="profile-pic">
                <h3><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h3>
                <p><?php echo htmlspecialchars($user['fitness_goal']); ?> Goal</p>
            </div>
            
            <ul class="nav-links">
                <li><a href="#" class="active"><i class="fas fa-user-cog"></i> Account Settings</a></li>
                <li><a href="#"><i class="fas fa-bell"></i> Notifications</a></li>
                <li><a href="#"><i class="fas fa-lock"></i> Privacy & Security</a></li>
                <li><a href="#"><i class="fas fa-chart-line"></i> Progress Tracking</a></li>
                <li><a href="#"><i class="fas fa-dumbbell"></i> Workout Preferences</a></li>
                <li><a href="#"><i class="fas fa-utensils"></i> Dietary Preferences</a></li>
                <li><a href="#"><i class="fas fa-heartbeat"></i> Health Metrics</a></li>
                <li><a href="#"><i class="fas fa-question-circle"></i> Help & Support</a></li>
            </ul>
            
            <div class="sidebar-footer">
                FitBuddy &copy; <?php echo date('Y'); ?>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1><i class="fas fa-user-cog"></i> Account Settings</h1>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search settings...">
                </div>
            </div>
            
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <!-- Profile Settings -->
                <div class="settings-section">
                    <h2 class="section-title"><i class="fas fa-user"></i> Profile Information</h2>
                    
                    <div class="profile-picture-upload">
                        <img src="<?php echo !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'uploads/default.png'; ?>" alt="Profile Preview" class="profile-picture-preview" id="profilePreview">
                        <label class="upload-btn">
                            <i class="fas fa-camera"></i> Change Photo
                            <input type="file" name="profile_picture" id="profilePicture" accept="image/*" style="display: none;">
                        </label>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" name="first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" name="last_name" class="form-control" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone_number" class="form-control" value="<?php echo htmlspecialchars($user['phone_number']); ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select id="gender" name="gender" class="form-control" required>
                                    <option value="Male" <?php echo $user['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo $user['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                                    <option value="Other" <?php echo $user['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" value="<?php echo htmlspecialchars($user['date_of_birth']); ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" id="age" name="age" class="form-control" value="<?php echo htmlspecialchars($user['age']); ?>" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" id="location" name="location" class="form-control" value="<?php echo htmlspecialchars($user['location']); ?>">
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                </div>
                
                <!-- Fitness Information -->
                <div class="settings-section">
                    <h2 class="section-title"><i class="fas fa-dumbbell"></i> Fitness Information</h2>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="weight_kg">Weight (kg)</label>
                                <input type="number" step="0.1" id="weight_kg" name="weight_kg" class="form-control" value="<?php echo htmlspecialchars($user['weight_kg']); ?>" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="height_cm">Height (cm)</label>
                                <input type="number" step="0.1" id="height_cm" name="height_cm" class="form-control" value="<?php echo htmlspecialchars($user['height_cm']); ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="activity_level">Activity Level</label>
                                <select id="activity_level" name="activity_level" class="form-control" required>
                                    <option value="Sedentary" <?php echo $user['activity_level'] == 'Sedentary' ? 'selected' : ''; ?>>Sedentary (little or no exercise)</option>
                                    <option value="Lightly Active" <?php echo $user['activity_level'] == 'Lightly Active' ? 'selected' : ''; ?>>Lightly Active (light exercise 1-3 days/week)</option>
                                    <option value="Moderately Active" <?php echo $user['activity_level'] == 'Moderately Active' ? 'selected' : ''; ?>>Moderately Active (moderate exercise 3-5 days/week)</option>
                                    <option value="Very Active" <?php echo $user['activity_level'] == 'Very Active' ? 'selected' : ''; ?>>Very Active (hard exercise 6-7 days/week)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="dietary_pref">Dietary Preference</label>
                                <select id="dietary_pref" name="dietary_pref" class="form-control" required>
                                    <option value="Omnivore" <?php echo $user['dietary_pref'] == 'Omnivore' ? 'selected' : ''; ?>>Omnivore</option>
                                    <option value="Vegetarian" <?php echo $user['dietary_pref'] == 'Vegetarian' ? 'selected' : ''; ?>>Vegetarian</option>
                                    <option value="Vegan" <?php echo $user['dietary_pref'] == 'Vegan' ? 'selected' : ''; ?>>Vegan</option>
                                    <option value="Pescatarian" <?php echo $user['dietary_pref'] == 'Pescatarian' ? 'selected' : ''; ?>>Pescatarian</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="fitness_goal">Fitness Goal</label>
                        <select id="fitness_goal" name="fitness_goal" class="form-control" required>
                            <option value="Weight Loss" <?php echo $user['fitness_goal'] == 'Weight Loss' ? 'selected' : ''; ?>>Weight Loss</option>
                            <option value="Muscle Building" <?php echo $user['fitness_goal'] == 'Muscle Building' ? 'selected' : ''; ?>>Muscle Building</option>
                            <option value="Maintain Fitness" <?php echo $user['fitness_goal'] == 'Maintain Fitness' ? 'selected' : ''; ?>>Maintain Fitness</option>
                            <option value="Weight Gain" <?php echo $user['fitness_goal'] == 'Weight Gain' ? 'selected' : ''; ?>>Weight Gain</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="disease">Health Conditions</label>
                                <input type="text" id="disease" name="disease" class="form-control" value="<?php echo htmlspecialchars($user['disease']); ?>" placeholder="None">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="allergy">Allergies</label>
                                <input type="text" id="allergy" name="allergy" class="form-control" value="<?php echo htmlspecialchars($user['allergy']); ?>" placeholder="None">
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                </div>
            </form>
            
            <!-- Danger Zone -->
            <div class="settings-section">
                <div class="danger-zone">
                    <h2 class="section-title"><i class="fas fa-exclamation-triangle"></i> Danger Zone</h2>
                    
                    <div class="form-group">
                        <p>Once you delete your account, there is no going back. Please be certain.</p>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-outline"><i class="fas fa-pause-circle"></i> Deactivate Account</button>
                        </div>
                        <div class="col">
                            <button class="btn btn-danger" id="deleteAccountBtn"><i class="fas fa-trash-alt"></i> Delete Account</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Profile picture preview
        document.getElementById('profilePicture').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Delete account confirmation
        document.getElementById('deleteAccountBtn').addEventListener('click', function() {
            const confirmDelete = confirm('Are you absolutely sure you want to delete your account? This action cannot be undone.');
            if (confirmDelete) {
                alert('Account deletion process initiated. This would typically redirect to a deletion confirmation page.');
                // In a real application, you would redirect to account deletion page
                // window.location.href = 'delete_account.php';
            }
        });

        // Calculate age from date of birth
        document.getElementById('date_of_birth').addEventListener('change', function() {
            const dob = new Date(this.value);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const monthDiff = today.getMonth() - dob.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            
            document.getElementById('age').value = age;
        });
    </script>
</body>
</html>