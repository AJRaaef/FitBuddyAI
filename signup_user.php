<?php
session_start();
include 'db.php';

// Initialize variables
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // -------------------------------
    // Validation and Sanitization
    // -------------------------------
    $required_fields = [
        'first_name', 'last_name', 'email', 'password', 
        'gender', 'date_of_birth', 'weight', 'height',
        'activity_level', 'sugar_value', 'cholostrol_value',
        'systolic_pressure', 'diastolic_pressure'
    ];
    
    $missing_fields = [];
    foreach ($required_fields as $field) {
        if (empty(trim($_POST[$field]))) {
            $missing_fields[] = ucfirst(str_replace('_', ' ', $field));
        }
    }
    
    if (!empty($missing_fields)) {
        $error = "❌ Please fill in all required fields: " . implode(', ', $missing_fields);
    } elseif (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
        $error = "❌ Please enter a valid email address";
    } elseif (strlen(trim($_POST['password'])) < 8) {
        $error = "❌ Password must be at least 8 characters long";
    } else {
        // -------------------------------
        // User inputs (with validation)
        // -------------------------------
        $first_name = htmlspecialchars(trim($_POST['first_name']));
        $last_name = htmlspecialchars(trim($_POST['last_name']));
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $phone_number = !empty($_POST['phone_number']) ? htmlspecialchars(trim($_POST['phone_number'])) : null;
        $gender = htmlspecialchars($_POST['gender']);
        $date_of_birth = $_POST['date_of_birth'];
        $weight = floatval($_POST['weight']);
        $height = floatval($_POST['height']);
        $activity_level = htmlspecialchars($_POST['activity_level']);
        $dietary_pref = !empty($_POST['dietary_pref']) ? htmlspecialchars($_POST['dietary_pref']) : 'Not specified';
        $fitness_goal = "Pending";
        $disease = !empty($_POST['disease']) ? htmlspecialchars(trim($_POST['disease'])) : 'None';
        $allergies = !empty($_POST['allergies']) ? htmlspecialchars(trim($_POST['allergies'])) : 'None';
        $location = !empty($_POST['location']) ? htmlspecialchars(trim($_POST['location'])) : 'Not specified';

        // -------------------------------
        // Numeric health inputs
        // -------------------------------
        $sugar_value = floatval($_POST['sugar_value']);
        $cholostrol_value = floatval($_POST['cholostrol_value']);
        $systolic_pressure = intval($_POST['systolic_pressure']);
        $diastolic_pressure = intval($_POST['diastolic_pressure']);

        // Validate health values
        if ($sugar_value <= 0 || $cholostrol_value <= 0 || $systolic_pressure <= 0 || $diastolic_pressure <= 0) {
            $error = "❌ Health values must be positive numbers";
        } else {
            // -------------------------------
            // Derived values
            // -------------------------------
            $dob = new DateTime($date_of_birth);
            $today = new DateTime();
            $age = $dob->diff($today)->y;

            // Validate age
            if ($age < 13) {
                $error = "❌ You must be at least 13 years old to register";
            } elseif ($age > 120) {
                $error = "❌ Please enter a valid date of birth";
            } else {
                $height_m = $height / 100;
                $bmi = $weight / ($height_m * $height_m);

                if ($gender == "Male") {
                    $bmr = 10 * $weight + 6.25 * $height - 5 * $age + 5;
                } elseif ($gender == "Female") {
                    $bmr = 10 * $weight + 6.25 * $height - 5 * $age - 161;
                } else {
                    $bmr = 10 * $weight + 6.25 * $height - 5 * $age;
                }

                $calories_per_kg = $bmr / $weight;

                // -------------------------------
                // Generate health labels
                // -------------------------------
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

                $sugar_label = get_sugar_label($sugar_value);
                $cholostrol_label = get_cholostrol_label($cholostrol_value);
                $pressure_label = get_pressure_label($systolic_pressure, $diastolic_pressure);

                // -------------------------------
                // Profile picture upload
                // -------------------------------
                $profile_picture = null;
                if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
                    // Validate uploaded file
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    $max_size = 2 * 1024 * 1024; // 2MB
                    
                    $file_info = finfo_open(FILEINFO_MIME_TYPE);
                    $mime_type = finfo_file($file_info, $_FILES['profile_picture']['tmp_name']);
                    finfo_close($file_info);
                    
                    if (!in_array($mime_type, $allowed_types)) {
                        $error = "❌ Invalid file type. Please upload JPG, PNG or GIF images only.";
                    } elseif ($_FILES['profile_picture']['size'] > $max_size) {
                        $error = "❌ File size too large. Maximum size is 2MB.";
                    } else {
                        $target_dir = "uploads/";
                        if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);
                        $filename = time() . "_" . basename($_FILES["profile_picture"]["name"]);
                        $target_file = $target_dir . $filename;
                        
                        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                            $profile_picture = $target_file;
                        } else {
                            $error = "❌ Error uploading profile picture. Please try again.";
                        }
                    }
                }
                
                // If no errors so far, proceed with registration
                if (empty($error)) {
                    // -------------------------------
                    // Check email duplication
                    // -------------------------------
                    $check = $conn->prepare("SELECT * FROM users WHERE email=?");
                    $check->bind_param("s", $email);
                    $check->execute();
                    $result = $check->get_result();

                    if ($result->num_rows > 0) {
                        $error = "❌ Email already registered!";
                    } else {
                        // -------------------------------
                        // Insert user into database
                        // -------------------------------
                        $stmt = $conn->prepare("INSERT INTO users 
                        (first_name,last_name,email,password,phone_number,gender,date_of_birth,age,weight_kg,height_cm,activity_level,dietary_pref,fitness_goal,disease,allergy,location,bmi,bmr,calories_per_kg,profile_picture,sugar_value,sugar_label,cholostrol_value,cholostrol_label,systolic_pressure,diastolic_pressure,pressure_label)
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                        $stmt->bind_param(
                            "sssssssiidssssssssdsdsdsdss", 
                            $first_name,
                            $last_name,
                            $email,
                            $password,
                            $phone_number,
                            $gender,
                            $date_of_birth,
                            $age,
                            $weight,
                            $height,
                            $activity_level,
                            $dietary_pref,
                            $fitness_goal,
                            $disease,
                            $allergies,
                            $location,
                            $bmi,
                            $bmr,
                            $calories_per_kg,
                            $profile_picture,
                            $sugar_value,
                            $sugar_label,
                            $cholostrol_value,
                            $cholostrol_label,
                            $systolic_pressure,
                            $diastolic_pressure,
                            $pressure_label
                        );

                        if ($stmt->execute()) {
                            $user_id = $conn->insert_id;
                            $_SESSION['user_id'] = $user_id;
                            $_SESSION['user_name'] = $first_name . " " . $last_name;

                            // -------------------------------
                            // Run Python scripts
                            // -------------------------------
                            $command_determine = "python model_determine.py " . $user_id;
                            exec($command_determine . " 2>&1", $output_determine, $return_determine);
                            if (!is_dir("logs")) mkdir("logs", 0755, true);
                            file_put_contents("logs/python_determine.log", date('Y-m-d H:i:s') . " | user_id: $user_id\n" . implode("\n", $output_determine) . "\n\n", FILE_APPEND);

                            $command_predict = "python predict_fitness_goal.py " .
                                $user_id . " " .
                                $age . " " .
                                escapeshellarg($gender) . " " .
                                $weight . " " .
                                $height . " " .
                                escapeshellarg($activity_level) . " " .
                                escapeshellarg($dietary_pref) . " " .
                                escapeshellarg($disease) . " " .
                                $calories_per_kg;

                            exec($command_predict . " 2>&1", $output_predict, $return_predict);
                            file_put_contents("logs/python_predict.log", date('Y-m-d H:i:s') . " | user_id: $user_id\n" . implode("\n", $output_predict) . "\n\n", FILE_APPEND);

                            $prediction_success = false;
                            if ($return_predict === 0) {
                                foreach ($output_predict as $line) {
                                    if (strpos($line, '✅ Fitness goal updated in database!') !== false) {
                                        $prediction_success = true;
                                        break;
                                    }
                                }
                            }

                            if ($prediction_success) {
                                // Set success message and redirect
                                $_SESSION['success_message'] = "✅ Account created successfully! You can now log in.";
                                header("Location: user_signin.php");
                                exit();
                            } else {
                                // Set success message and redirect
                                $_SESSION['success_message'] = "✅ Account created successfully! You can now log in.";
                                header("Location: user_signin.php");
                                exit();
                            }

                        } else {
                            $error = "❌ Registration failed: " . $stmt->error;
                        }
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - FitBuddy AI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --primary-dark: #3a0ca3;
      --secondary: #7209b7;
      --accent: #4cc9f0;
      --light: #f8f9fa;
      --dark: #212529;
      --success: #16a34a;
      --warning: #f59e0b;
      --error: #e63946;
      --gradient-bg: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
      --gradient-primary: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
      --border-radius: 12px;
      --shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      --transition: all 0.3s ease;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: var(--gradient-bg);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .signup-container {
      width: 100%;
      max-width: 900px;
    }

    .signup-card {
      background: #fff;
      padding: 40px;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    .signup-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 6px;
      background: var(--gradient-primary);
    }

    .brand {
      text-align: center;
      margin-bottom: 30px;
    }

    .brand-icon {
      width: 70px;
      height: 70px;
      background: var(--gradient-primary);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 15px;
      color: white;
      font-size: 28px;
      box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
    }

    .brand h1 {
      font-size: 28px;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 8px;
    }

    .brand p {
      color: #6c757d;
      font-size: 16px;
    }

    .alert {
      border-radius: var(--border-radius);
      padding: 12px 16px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .alert-danger {
      background-color: rgba(230, 57, 70, 0.1);
      color: var(--error);
      border-left: 4px solid var(--error);
    }

    .form-section {
      margin-bottom: 30px;
      padding-bottom: 20px;
      border-bottom: 1px solid #e2e8f0;
    }

    .section-title {
      font-size: 18px;
      font-weight: 600;
      color: var(--primary);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .form-group {
      margin-bottom: 20px;
      position: relative;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: var(--dark);
      font-size: 14px;
    }

    .input-with-icon {
      position: relative;
    }

    .input-with-icon i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #6c757d;
      font-size: 18px;
    }

    .form-control {
      width: 100%;
      padding: 14px 15px 14px 45px;
      border: 2px solid #e2e8f0;
      border-radius: var(--border-radius);
      font-size: 16px;
      transition: var(--transition);
      background-color: #f8fafc;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
      background-color: #fff;
    }

    .input-info {
      font-size: 12px;
      color: #6c757d;
      margin-top: 5px;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .health-value-display {
      background: #f8fafc;
      border-radius: var(--border-radius);
      padding: 15px;
      margin-top: 10px;
      border-left: 4px solid var(--primary);
    }

    .health-value-title {
      font-weight: 600;
      color: var(--dark);
      margin-bottom: 5px;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .health-value-desc {
      font-size: 13px;
      color: #6c757d;
    }

    .btn-signup {
      width: 100%;
      padding: 15px;
      background: var(--gradient-primary);
      color: #fff;
      border: none;
      border-radius: var(--border-radius);
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
      transition: var(--transition);
      box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
      margin-top: 20px;
    }

    .btn-signup:hover {
      background: linear-gradient(to right, var(--primary-dark), #5e18a5);
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
    }

    .btn-signup:active {
      transform: translateY(0);
    }

    .login-link {
      text-align: center;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 1px solid #e2e8f0;
      color: #6c757d;
    }

    .login-link a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      transition: var(--transition);
    }

    .login-link a:hover {
      color: var(--secondary);
      text-decoration: underline;
    }

    /* Tooltip styling */
    .tooltip-icon {
      color: var(--primary);
      cursor: help;
      margin-left: 5px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .signup-card {
        padding: 30px 20px;
      }
      
      .brand h1 {
        font-size: 24px;
      }
    }

    /* Animation for error message */
    @keyframes shake {
      0%, 100% {transform: translateX(0);}
      15%, 45%, 75% {transform: translateX(-10px);}
      30%, 60%, 90% {transform: translateX(10px);}
    }

    .shake {
      animation: shake 0.6s ease;
    }
    
    .required-field::after {
      content: " *";
      color: var(--error);
    }
  </style>
</head>
<body>
  <div class="signup-container">
    <div class="signup-card" id="signupCard">
      <div class="brand">
        <div class="brand-icon">
          <i class="fas fa-dumbbell"></i>
        </div>
        <h1>Join FitBuddy AI</h1>
        <p>Create your account to start your fitness journey</p>
      </div>
      
      <?php if (!empty($error)) : ?>
        <div class="alert alert-danger" id="errorMessage">
          <i class="fas fa-exclamation-circle"></i>
          <span><?= $error ?></span>
        </div>
      <?php endif; ?>
      
      <form method="POST" enctype="multipart/form-data" id="signupForm">
        <!-- Personal Information Section -->
        <div class="form-section">
          <div class="section-title">
            <i class="fas fa-user"></i>
            <span>Personal Information</span>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="first_name" class="required-field">First Name</label>
                <div class="input-with-icon">
                  <i class="fas fa-signature"></i>
                  <input type="text" id="first_name" name="first_name" class="form-control" required value="<?= isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : '' ?>">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="last_name" class="required-field">Last Name</label>
                <div class="input-with-icon">
                  <i class="fas fa-signature"></i>
                  <input type="text" id="last_name" name="last_name" class="form-control" required value="<?= isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : '' ?>">
                </div>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="email" class="required-field">Email Address</label>
            <div class="input-with-icon">
              <i class="fas fa-envelope"></i>
              <input type="email" id="email" name="email" class="form-control" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            </div>
            <div class="input-info">
              <i class="fas fa-info-circle"></i>
              We'll never share your email with anyone else.
            </div>
          </div>
          
          <div class="form-group">
            <label for="password" class="required-field">Password</label>
            <div class="input-with-icon">
              <i class="fas fa-lock"></i>
              <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="input-info">
              <i class="fas fa-info-circle"></i>
              Use at least 8 characters with a mix of letters, numbers & symbols.
            </div>
          </div>
          
          <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <div class="input-with-icon">
              <i class="fas fa-phone"></i>
              <input type="text" id="phone_number" name="phone_number" class="form-control" value="<?= isset($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : '' ?>">
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="gender" class="required-field">Gender</label>
                <div class="input-with-icon">
                  <i class="fas fa-venus-mars"></i>
                  <select id="gender" name="gender" class="form-control" required>
                    <option value="">Choose...</option>
                    <option value="Male" <?= (isset($_POST['gender']) && $_POST['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= (isset($_POST['gender']) && $_POST['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= (isset($_POST['gender']) && $_POST['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="date_of_birth" class="required-field">Date of Birth</label>
                <div class="input-with-icon">
                  <i class="fas fa-birthday-cake"></i>
                  <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" required value="<?= isset($_POST['date_of_birth']) ? htmlspecialchars($_POST['date_of_birth']) : '' ?>">
                </div>
                <div class="input-info" id="ageDisplay">Age: -</div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Physical Information Section -->
        <div class="form-section">
          <div class="section-title">
            <i class="fas fa-weight"></i>
            <span>Physical Information</span>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="weight" class="required-field">Weight (kg)</label>
                <div class="input-with-icon">
                  <i class="fas fa-weight-scale"></i>
                  <input type="number" id="weight" name="weight" class="form-control" step="0.1" required value="<?= isset($_POST['weight']) ? htmlspecialchars($_POST['weight']) : '' ?>">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="height" class="required-field">Height (cm)</label>
                <div class="input-with-icon">
                  <i class="fas fa-ruler-vertical"></i>
                  <input type="number" id="height" name="height" class="form-control" step="0.1" required value="<?= isset($_POST['height']) ? htmlspecialchars($_POST['height']) : '' ?>">
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="activity_level" class="required-field">Activity Level</label>
                <div class="input-with-icon">
                  <i class="fas fa-person-running"></i>
                  <select id="activity_level" name="activity_level" class="form-control" required>
                    <option value="">Select...</option>
                    <option value="Sedentary" <?= (isset($_POST['activity_level']) && $_POST['activity_level'] == 'Sedentary') ? 'selected' : '' ?>>Sedentary (little or no exercise)</option>
                    <option value="Lightly Active" <?= (isset($_POST['activity_level']) && $_POST['activity_level'] == 'Lightly Active') ? 'selected' : '' ?>>Lightly Active (light exercise 1-3 days/week)</option>
                    <option value="Moderately Active" <?= (isset($_POST['activity_level']) && $_POST['activity_level'] == 'Moderately Active') ? 'selected' : '' ?>>Moderately Active (moderate exercise 3-5 days/week)</option>
                    <option value="Very Active" <?= (isset($_POST['activity_level']) && $_POST['activity_level'] == 'Very Active') ? 'selected' : '' ?>>Very Active (hard exercise 6-7 days/week)</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="dietary_pref">Dietary Preference</label>
                <div class="input-with-icon">
                  <i class="fas fa-utensils"></i>
                  <select id="dietary_pref" name="dietary_pref" class="form-control">
                    <option value="">Select...</option>
                    <option value="Omnivore" <?= (isset($_POST['dietary_pref']) && $_POST['dietary_pref'] == 'Omnivore') ? 'selected' : '' ?>>Omnivore</option>
                    <option value="Vegetarian" <?= (isset($_POST['dietary_pref']) && $_POST['dietary_pref'] == 'Vegetarian') ? 'selected' : '' ?>>Vegetarian</option>
                    <option value="Vegan" <?= (isset($_POST['dietary_pref']) && $_POST['dietary_pref'] == 'Vegan') ? 'selected' : '' ?>>Vegan</option>
                    <option value="Non-Vegetarian" <?= (isset($_POST['dietary_pref']) && $_POST['dietary_pref'] == 'Non-Vegetarian') ? 'selected' : '' ?>>Non-Vegetarian</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          
          <div class="health-value-display" id="bmiDisplay">
            <div class="health-value-title">BMI: <span id="bmiValue">-</span></div>
            <div class="health-value-desc" id="bmiCategory">Body Mass Index will be calculated based on your weight and height.</div>
          </div>
          
          <div class="health-value-display" id="bmrDisplay">
            <div class="health-value-title">BMR: <span id="bmrValue">-</span> calories/day</div>
            <div class="health-value-desc">Basal Metabolic Rate - calories your body needs at rest.</div>
          </div>
        </div>
        
        <!-- Health Information Section -->
        <div class="form-section">
          <div class="section-title">
            <i class="fas fa-heart-pulse"></i>
            <span>Health Information</span>
          </div>
          
          <div class="form-group">
            <label for="disease">Existing Medical Conditions</label>
            <div class="input-with-icon">
              <i class="fas fa-file-medical"></i>
              <input type="text" id="disease" name="disease" class="form-control" placeholder="E.g. Hypertension, Diabetes" value="<?= isset($_POST['disease']) ? htmlspecialchars($_POST['disease']) : '' ?>">
            </div>
          </div>
          
          <div class="form-group">
            <label for="allergies">Allergies</label>
            <div class="input-with-icon">
              <i class="fas fa-allergies"></i>
              <input type="text" id="allergies" name="allergies" class="form-control" placeholder="E.g. Peanuts, Lactose, Penicillin" value="<?= isset($_POST['allergies']) ? htmlspecialchars($_POST['allergies']) : '' ?>">
            </div>
          </div>
          
          <div class="form-group">
            <label for="sugar_value" class="required-field">Blood Sugar Level (mg/dL)</label>
            <div class="input-with-icon">
              <i class="fas fa-tint"></i>
              <input type="number" id="sugar_value" name="sugar_value" class="form-control" step="0.1" required value="<?= isset($_POST['sugar_value']) ? htmlspecialchars($_POST['sugar_value']) : '' ?>">
            </div>
            <div class="health-value-display" id="sugarDisplay">
              <div class="health-value-title">Status: <span id="sugarCategory">-</span></div>
              <div class="health-value-desc" id="sugarDescription">Normal range: 70-120 mg/dL</div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="cholostrol_value" class="required-field">Cholesterol Level (mg/dL)</label>
            <div class="input-with-icon">
              <i class="fas fa-tint"></i>
              <input type="number" id="cholostrol_value" name="cholostrol_value" class="form-control" step="0.1" required value="<?= isset($_POST['cholostrol_value']) ? htmlspecialchars($_POST['cholostrol_value']) : '' ?>">
            </div>
            <div class="health-value-display" id="cholesterolDisplay">
              <div class="health-value-title">Status: <span id="cholesterolCategory">-</span></div>
              <div class="health-value-desc" id="cholesterolDescription">Desirable: Less than 200 mg/dL</div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="systolic_pressure" class="required-field">Systolic Pressure (mmHg)</label>
                <div class="input-with-icon">
                  <i class="fas fa-heart"></i>
                  <input type="number" id="systolic_pressure" name="systolic_pressure" class="form-control" required value="<?= isset($_POST['systolic_pressure']) ? htmlspecialchars($_POST['systolic_pressure']) : '' ?>">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="diastolic_pressure" class="required-field">Diastolic Pressure (mmHg)</label>
                <div class="input-with-icon">
                  <i class="fas fa-heart"></i>
                  <input type="number" id="diastolic_pressure" name="diastolic_pressure" class="form-control" required value="<?= isset($_POST['diastolic_pressure']) ? htmlspecialchars($_POST['diastolic_pressure']) : '' ?>">
                </div>
              </div>
            </div>
          </div>
          
          <div class="health-value-display" id="pressureDisplay">
            <div class="health-value-title">Blood Pressure: <span id="pressureValue">-</span></div>
            <div class="health-value-desc" id="pressureCategory">Status: -</div>
          </div>
          
          <div class="form-group">
            <label for="location">Location</label>
            <div class="input-with-icon">
              <i class="fas fa-location-dot"></i>
              <input type="text" id="location" name="location" class="form-control" placeholder="Enter your city or area" value="<?= isset($_POST['location']) ? htmlspecialchars($_POST['location']) : '' ?>">
            </div>
          </div>
        </div>
        
        <!-- Profile Picture Section -->
        <div class="form-section">
          <div class="section-title">
            <i class="fas fa-camera"></i>
            <span>Profile Picture</span>
          </div>
          
          <div class="form-group">
            <label for="profile_picture">Upload Profile Photo</label>
            <input type="file" id="profile_picture" name="profile_picture" class="form-control">
            <div class="input-info">
              <i class="fas fa-info-circle"></i>
              Optional. JPG, PNG or GIF files accepted. Max size: 2MB.
            </div>
          </div>
        </div>
        
        <button type="submit" class="btn-signup">
          <i class="fas fa-user-plus"></i> Create Account
        </button>
      </form>
      
      <div class="login-link">
        Already have an account? <a href="user_signin.php">Sign In</a>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const signupForm = document.getElementById('signupForm');
      const errorMessage = document.getElementById('errorMessage');
      const signupCard = document.getElementById('signupCard');
      
      // Add shake animation if there's an error
      if (errorMessage) {
        signupCard.classList.add('shake');
        setTimeout(() => {
          signupCard.classList.remove('shake');
        }, 600);
      }
      
      // Real-time calculations and validations
      const weightInput = document.getElementById('weight');
      const heightInput = document.getElementById('height');
      const dobInput = document.getElementById('date_of_birth');
      const sugarInput = document.getElementById('sugar_value');
      const cholesterolInput = document.getElementById('cholostrol_value');
      const systolicInput = document.getElementById('systolic_pressure');
      const diastolicInput = document.getElementById('diastolic_pressure');
      const genderInput = document.getElementById('gender');
      
      // Calculate age from date of birth
      dobInput.addEventListener('change', calculateAge);
      
      function calculateAge() {
        const dob = new Date(dobInput.value);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
          age--;
        }
        
        document.getElementById('ageDisplay').textContent = `Age: ${age}`;
        calculateBMR();
      }
      
      // Calculate BMI
      function calculateBMI() {
        const weight = parseFloat(weightInput.value);
        const height = parseFloat(heightInput.value);
        
        if (weight && height) {
          const heightM = height / 100;
          const bmi = weight / (heightM * heightM);
          document.getElementById('bmiValue').textContent = bmi.toFixed(1);
          
          let category = '';
          if (bmi < 18.5) category = 'Underweight';
          else if (bmi < 25) category = 'Normal weight';
          else if (bmi < 30) category = 'Overweight';
          else category = 'Obese';
          
          document.getElementById('bmiCategory').textContent = `Category: ${category}`;
        }
      }
      
      // Calculate BMR
      function calculateBMR() {
        const weight = parseFloat(weightInput.value);
        const height = parseFloat(heightInput.value);
        const age = document.getElementById('ageDisplay').textContent.replace('Age: ', '');
        const gender = genderInput.value;
        
        if (weight && height && age && gender) {
          let bmr = 0;
          if (gender === "Male") {
            bmr = 10 * weight + 6.25 * height - 5 * age + 5;
          } else if (gender === "Female") {
            bmr = 10 * weight + 6.25 * height - 5 * age - 161;
          } else {
            bmr = 10 * weight + 6.25 * height - 5 * age;
          }
          
          document.getElementById('bmrValue').textContent = Math.round(bmr);
        }
      }
      
      // Evaluate sugar level
      function evaluateSugar() {
        const value = parseFloat(sugarInput.value);
        if (!value) return;
        
        let category = '';
        let description = '';
        
        if (value < 70) {
          category = 'Very Low';
          description = 'Hypoglycemia risk. Consult a doctor.';
        } else if (value < 80) {
          category = 'Low';
          description = 'Slightly low blood sugar.';
        } else if (value < 90) {
          category = 'Little Low';
          description = 'Within acceptable range.';
        } else if (value <= 120) {
          category = 'Normal';
          description = 'Healthy blood sugar level.';
        } else if (value <= 140) {
          category = 'Little High';
          description = 'Slightly elevated blood sugar.';
        } else if (value <= 180) {
          category = 'High';
          description = 'Hyperglycemia. Monitor carefully.';
        } else {
          category = 'Very High';
          description = 'Dangerously high. Seek medical attention.';
        }
        
        document.getElementById('sugarCategory').textContent = category;
        document.getElementById('sugarDescription').textContent = description;
      }
      
      // Evaluate cholesterol level
      function evaluateCholesterol() {
        const value = parseFloat(cholesterolInput.value);
        if (!value) return;
        
        let category = '';
        let description = '';
        
        if (value < 120) {
          category = 'Very Low';
          description = 'Unusually low cholesterol level.';
        } else if (value < 160) {
          category = 'Low';
          description = 'Low cholesterol level.';
        } else if (value < 180) {
          category = 'Little Low';
          description = 'Below optimal level.';
        } else if (value <= 200) {
          category = 'Normal';
          description = 'Desirable cholesterol level.';
        } else if (value <= 240) {
          category = 'Little High';
          description = 'Borderline high cholesterol.';
        } else if (value <= 280) {
          category = 'High';
          description = 'High cholesterol. Lifestyle changes recommended.';
        } else {
          category = 'Very High';
          description = 'Dangerously high cholesterol. Consult a doctor.';
        }
        
        document.getElementById('cholesterolCategory').textContent = category;
        document.getElementById('cholesterolDescription').textContent = description;
      }
      
      // Evaluate blood pressure
      function evaluateBloodPressure() {
        const systolic = parseFloat(systolicInput.value);
        const diastolic = parseFloat(diastolicInput.value);
        
        if (!systolic || !diastolic) return;
        
        document.getElementById('pressureValue').textContent = `${systolic}/${diastolic} mmHg`;
        
        let category = '';
        
        if (systolic < 90 || diastolic < 60) {
          category = 'Very Low (Hypotension)';
        } else if (systolic < 100 || diastolic < 65) {
          category = 'Low';
        } else if (systolic < 110 || diastolic < 70) {
          category = 'Little Low';
        } else if (systolic <= 120 && diastolic <= 80) {
          category = 'Normal (Healthy)';
        } else if (systolic <= 130 || diastolic <= 85) {
          category = 'Little High (Elevated)';
        } else if (systolic <= 140 || diastolic <= 90) {
          category = 'High (Hypertension Stage 1)';
        } else {
          category = 'Very High (Hypertension Stage 2)';
        }
        
        document.getElementById('pressureCategory').textContent = `Status: ${category}`;
      }
      
      // Add event listeners for real-time calculations
      weightInput.addEventListener('input', function() {
        calculateBMI();
        calculateBMR();
      });
      
      heightInput.addEventListener('input', function() {
        calculateBMI();
        calculateBMR();
      });
      
      genderInput.addEventListener('change', calculateBMR);
      sugarInput.addEventListener('input', evaluateSugar);
      cholesterolInput.addEventListener('input', evaluateCholesterol);
      systolicInput.addEventListener('input', evaluateBloodPressure);
      diastolicInput.addEventListener('input', evaluateBloodPressure);
      
      // Initialize calculations if values are pre-filled
      if (dobInput.value) calculateAge();
      if (weightInput.value && heightInput.value) calculateBMI();
      if (weightInput.value && heightInput.value && dobInput.value && genderInput.value) calculateBMR();
      if (sugarInput.value) evaluateSugar();
      if (cholesterolInput.value) evaluateCholesterol();
      if (systolicInput.value && diastolicInput.value) evaluateBloodPressure();
    });
  </script>
</body>
</html>