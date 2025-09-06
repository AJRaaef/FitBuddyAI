<?php
session_start();
require 'db.php'; // your database connection

if (isset($_SESSION['admin_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ? AND status = 'active'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_name'] = $admin['full_name'];
        $_SESSION['admin_role'] = $admin['role'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Secure Access</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3f37c9;
            --secondary: #7209b7;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --success: #4cc9f0;
            --error: #e63946;
            --border-radius: 12px;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 440px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: var(--dark);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-header p {
            color: var(--gray);
            font-size: 16px;
        }

        .logo {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
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
            color: var(--gray);
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

        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: #fff;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
        }

        .btn:hover {
            background: linear-gradient(to right, var(--primary-dark), #5e18a5);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
        }

        .btn:active {
            transform: translateY(0);
        }

        .error-message {
            background-color: rgba(230, 57, 70, 0.1);
            color: var(--error);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
            border-left: 4px solid var(--error);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .error-message.hidden {
            display: none;
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
            color: var(--gray);
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

        .footer {
            text-align: center;
            margin-top: 30px;
            color: var(--gray);
            font-size: 13px;
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
            .login-container {
                padding: 30px 20px;
            }
            
            .login-header h1 {
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
    <div class="login-container" id="loginContainer">
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-lock"></i>
            </div>
            <h1>Admin Portal</h1>
            <p>Sign in to access the dashboard</p>
        </div>

        <?php if($error): ?>
        <div class="error-message" id="errorMessage">
            <i class="fas fa-exclamation-circle"></i>
            <span><?php echo $error; ?></span>
        </div>
        <?php endif; ?>

        <form method="POST" id="loginForm">
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-with-icon">
                    <i class="fas fa-key"></i>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
            </div>

            <button type="submit" class="btn">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>

            <div class="additional-options">
                <label class="remember-me">
                    <input type="checkbox"> Remember me
                </label>
                <a href="#" class="forgot-password">Forgot password?</a>
            </div>
        </form>

        <div class="footer">
            <p>&copy; 2023 Admin System. All rights reserved.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const errorMessage = document.getElementById('errorMessage');
            const loginContainer = document.getElementById('loginContainer');
            
            // Add shake animation if there's an error
            if (errorMessage) {
                loginContainer.classList.add('shake');
                setTimeout(() => {
                    loginContainer.classList.remove('shake');
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
                        errorDiv.className = 'error-message';
                        errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i><span>Please fill in all fields</span>';
                        loginForm.parentNode.insertBefore(errorDiv, loginForm);
                        loginContainer.classList.add('shake');
                        setTimeout(() => {
                            loginContainer.classList.remove('shake');
                        }, 600);
                    }
                }
            });
            
            // Add focus styles dynamically
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
        });
    </script>
</body>
</html>