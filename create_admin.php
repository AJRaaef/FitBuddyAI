<?php
session_start();
require_once 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone_number = trim($_POST['phone_number']);
    $role = trim($_POST['role']);
    $status = trim($_POST['status'] ?? 'active');
    
    // Basic validation
    if (empty($full_name) || empty($email) || empty($password) || empty($role)) {
        $message = "Please fill all required fields.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT admin_id FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $message = "Email already exists.";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert admin
            $stmt = $conn->prepare("INSERT INTO admins (full_name, email, password, phone_number, role, status, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssssss", $full_name, $email, $hashed_password, $phone_number, $role, $status);
            if ($stmt->execute()) {
                $stmt->close();
                header("Location: admin_dashboard.php?message=Admin+created+successfully");
                exit();
            } else {
                $message = "Error creating admin.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin - FitBuddyAI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #f8f9fa;
            --dark: #212529;
            --light: #f8f9fa;
            --gray: #6c757d;
            --success: #28a745;
            --danger: #dc3545;
            --border: #dee2e6;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --radius: 12px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .header {
            background: var(--primary);
            color: white;
            padding: 24px 30px;
            text-align: center;
        }

        .header h2 {
            font-weight: 600;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .header h2 i {
            font-size: 26px;
        }

        .form-container {
            padding: 30px;
        }

        .message {
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            background-color: #ffebee;
            color: var(--danger);
            font-size: 14px;
            display: <?php echo $message ? 'flex' : 'none'; ?>;
            align-items: center;
            gap: 10px;
        }

        .message i {
            font-size: 18px;
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

        .form-group label::after {
            content: '*';
            color: var(--danger);
            margin-left: 4px;
            display: inline;
        }

        .form-group .optional {
            font-size: 12px;
            color: var(--gray);
            font-weight: 400;
            margin-left: 5px;
        }

        .form-group .optional::after {
            content: '';
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
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 15px;
            transition: var(--transition);
            background-color: var(--secondary);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236c757d' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            padding-right: 45px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }

        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn i {
            margin-right: 8px;
        }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
            color: var(--gray);
            text-decoration: none;
            font-size: 14px;
            transition: var(--transition);
            gap: 6px;
        }

        .back-link:hover {
            color: var(--primary);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--gray);
        }

        @media (max-width: 640px) {
            body {
                padding: 15px;
            }
            
            .container {
                border-radius: 10px;
            }
            
            .header {
                padding: 20px;
            }
            
            .form-container {
                padding: 20px;
            }
        }

        .success-message {
            display: none;
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            background-color: #e8f5e9;
            color: var(--success);
            font-size: 14px;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2><i class="fas fa-user-plus"></i> Create New Admin</h2>
        </div>

        <div class="form-container">
            <?php if($message): ?>
                <div class="message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo htmlspecialchars($message); ?></span>
                </div>
            <?php endif; ?>

            <form method="post" action="" id="adminForm">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Enter full name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Create a password" required>
                        <span class="password-toggle" id="passwordToggle">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number <span class="optional">(optional)</span></label>
                    <div class="input-with-icon">
                        <i class="fas fa-phone"></i>
                        <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="Enter phone number">
                    </div>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user-tag"></i>
                        <select id="role" name="role" class="form-control" required>
                            <option value="">Select Role</option>
                            <option value="super_admin">Admin</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <div class="input-with-icon">
                        <i class="fas fa-check-circle"></i>
                        <select id="status" name="status" class="form-control">
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn">
                    <i class="fas fa-user-plus"></i> Create Admin
                </button>
            </form>

            <a href="admin_dashboard.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <script>
        // Password visibility toggle
        const passwordToggle = document.getElementById('passwordToggle');
        const passwordInput = document.getElementById('password');
        
        passwordToggle.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle eye icon
            const eyeIcon = this.querySelector('i');
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });

        // Form validation
        const form = document.getElementById('adminForm');
        form.addEventListener('submit', function(event) {
            let valid = true;
            const inputs = form.querySelectorAll('input[required], select[required]');
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    valid = false;
                    input.style.borderColor = 'var(--danger)';
                } else {
                    input.style.borderColor = 'var(--border)';
                }
            });
            
            if (!valid) {
                event.preventDefault();
                alert('Please fill all required fields.');
            }
        });
    </script>
</body>
</html>