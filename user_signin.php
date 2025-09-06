<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare statement for security
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Verify hashed password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['first_name'] . " " . $row['last_name'];
            header("Location: user_dashboard.php");
            exit();
        } else {
            $error = "❌ Invalid Password";
        }
    } else {
        $error = "❌ Email not registered";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Sign In - FitBuddy</title>
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
      --success: #4ade80;
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

    .login-container {
      width: 100%;
      max-width: 440px;
    }

    .login-card {
      background: #fff;
      padding: 40px;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    .login-card::before {
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

    .btn-login {
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
    }

    .btn-login:hover {
      background: linear-gradient(to right, var(--primary-dark), #5e18a5);
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .additional-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 20px;
      font-size: 14px;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 8px;
      color: #6c757d;
    }

    .forgot-password {
      color: var(--primary);
      text-decoration: none;
      transition: var(--transition);
    }

    .forgot-password:hover {
      color: var(--secondary);
      text-decoration: underline;
    }

    .signup-link {
      text-align: center;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 1px solid #e2e8f0;
      color: #6c757d;
    }

    .signup-link a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      transition: var(--transition);
    }

    .signup-link a:hover {
      color: var(--secondary);
      text-decoration: underline;
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

    /* Responsive adjustments */
    @media (max-width: 480px) {
      .login-card {
        padding: 30px 20px;
      }
      
      .brand h1 {
        font-size: 24px;
      }
      
      .additional-options {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-card" id="loginCard">
      <div class="brand">
        <div class="brand-icon">
          <i class="fas fa-dumbbell"></i>
        </div>
        <h1>FitBuddy</h1>
        <p>Sign in to continue your fitness journey</p>
      </div>
      
      <?php if (!empty($error)) : ?>
        <div class="alert alert-danger" id="errorMessage">
          <i class="fas fa-exclamation-circle"></i>
          <span><?= $error ?></span>
        </div>
      <?php endif; ?>
      
      <form method="POST" id="loginForm">
        <div class="form-group">
          <label for="email">Email Address</label>
          <div class="input-with-icon">
            <i class="fas fa-envelope"></i>
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
          </div>
        </div>
        
        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-with-icon">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
          </div>
        </div>
        
        <button type="submit" class="btn-login">
          <i class="fas fa-sign-in-alt"></i> Sign In
        </button>
        
        <div class="additional-options">
          <label class="remember-me">
            <input type="checkbox"> Remember me
          </label>
          <a href="#" class="forgot-password">Forgot password?</a>
        </div>
      </form>
      
      <div class="signup-link">
        Don't have an account? <a href="signup_user.php">Sign Up</a>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const loginForm = document.getElementById('loginForm');
      const errorMessage = document.getElementById('errorMessage');
      const loginCard = document.getElementById('loginCard');
      
      // Add shake animation if there's an error
      if (errorMessage) {
        loginCard.classList.add('shake');
        setTimeout(() => {
          loginCard.classList.remove('shake');
        }, 600);
      }
      
      // Form validation
      loginForm.addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        if (!email || !password) {
          e.preventDefault();
          if (!errorMessage) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger';
            errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i><span>Please fill in all fields</span>';
            loginForm.parentNode.insertBefore(errorDiv, loginForm);
            loginCard.classList.add('shake');
            setTimeout(() => {
              loginCard.classList.remove('shake');
            }, 600);
          }
        }
      });
    });
  </script>
</body>
</html>