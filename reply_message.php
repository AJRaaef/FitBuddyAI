<?php
session_start();
require 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Fetch message
if (!isset($_GET['message_id'])) {
    die("Message ID missing.");
}
$message_id = intval($_GET['message_id']);

$stmt = $conn->prepare("
    SELECT r.*, u.first_name, u.last_name, u.email 
    FROM replay r 
    JOIN users u ON r.user_id = u.user_id 
    WHERE r.message_id = ?
");
$stmt->bind_param("i", $message_id);
$stmt->execute();
$message = $stmt->get_result()->fetch_assoc();

if (!$message) {
    die("Message not found.");
}

// Handle reply submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reply = trim($_POST['reply']);
    if ($reply !== "") {
        $update = $conn->prepare("UPDATE replay SET replay = ?, admin_id = ? WHERE message_id = ?");
        $update->bind_param("sii", $reply, $admin_id, $message_id);
        $update->execute();
        header("Location: admin_dashboard.php");
        exit();
    }
}

// Fetch admin info for the header
$stmt = $conn->prepare("SELECT * FROM admins WHERE admin_id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply Message - FitBuddyAI Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --accent: #f72585;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f9c74f;
            --info: #3ecf8e;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            color: #333;
            line-height: 1.6;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: var(--primary);
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: var(--transition);
            z-index: 1000;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-header h2 i {
            color: var(--accent);
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .admin-info h4 {
            font-size: 0.9rem;
            margin-bottom: 3px;
        }

        .admin-info p {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .nav-menu {
            list-style: none;
            padding: 0 10px;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 8px;
            transition: var(--transition);
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 25px;
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            margin-bottom: 25px;
        }

        .page-title h1 {
            font-size: 1.8rem;
            color: var(--dark);
            font-weight: 600;
        }

        .page-title p {
            color: var(--gray);
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .logout-btn {
            background: var(--accent);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            text-decoration: none;
        }

        .logout-btn:hover {
            background: #e51274;
            transform: translateY(-2px);
        }

        /* Reply Section */
        .reply-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            max-width: 800px;
            margin: 0 auto;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--light-gray);
        }

        .section-title {
            font-size: 1.4rem;
            color: var(--dark);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .back-btn {
            background: var(--light-gray);
            color: var(--dark);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: var(--transition);
        }

        .back-btn:hover {
            background: #dce1e7;
        }

        .message-card {
            background: var(--light);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .user-details h3 {
            font-size: 1.1rem;
            margin-bottom: 3px;
        }

        .user-details p {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .message-date {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .message-content {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid var(--primary);
        }

        .message-content p {
            margin-bottom: 0;
            line-height: 1.6;
        }

        .reply-form {
            margin-top: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: #3251d4;
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: visible;
            }
            
            .sidebar .sidebar-header h2 span,
            .sidebar .admin-info,
            .sidebar .nav-link span {
                display: none;
            }
            
            .sidebar .nav-link {
                justify-content: center;
                padding: 15px;
            }
            
            .sidebar .nav-link i {
                margin-right: 0;
            }
            
            .main-content {
                margin-left: 70px;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .message-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .message-date {
                align-self: flex-end;
            }
            
            .section-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-dumbbell"></i> <span>FitBuddyAI</span></h2>
                <div class="admin-profile">
                    <div class="admin-avatar">
                        <?php echo strtoupper(substr($admin['full_name'], 0, 1)); ?>
                    </div>
                    <div class="admin-info">
                        <h4><?php echo htmlspecialchars($admin['full_name']); ?></h4>
                        <p>Administrator</p>
                    </div>
                </div>
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="admin_dashboard.php" class="nav-link">
                        <i class="fas fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin_dashboard.php#users" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>User Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin_dashboard.php#admins" class="nav-link">
                        <i class="fas fa-user-shield"></i>
                        <span>Admin Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin_dashboard.php#messages" class="nav-link active">
                        <i class="fas fa-envelope"></i>
                        <span>Messages</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin_dashboard.php#health-tips" class="nav-link">
                        <i class="fas fa-heartbeat"></i>
                        <span>Health Tips</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin_logout.php" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <div class="page-title">
                    <h1>Reply to Message</h1>
                    <p>Respond to user inquiries</p>
                </div>
                <a href="admin_logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>

            <div class="reply-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-reply"></i> Compose Reply</h2>
                    <a href="admin_dashboard.php#messages" class="back-btn">
                        <i class="fas fa-arrow-left"></i> Back to Messages
                    </a>
                </div>

                <div class="message-card">
                    <div class="message-header">
                        <div class="user-info">
                            <div class="user-avatar">
                                <?php echo strtoupper(substr($message['first_name'], 0, 1)); ?>
                            </div>
                            <div class="user-details">
                                <h3><?php echo htmlspecialchars($message['first_name'] . ' ' . $message['last_name']); ?></h3>
                                <p><?php echo htmlspecialchars($message['email']); ?></p>
                            </div>
                        </div>
                        <div class="message-date">
                            <?php echo date('M j, Y \a\t g:i A', strtotime($message['created_at'])); ?>
                        </div>
                    </div>
                    
                    <div class="message-content">
                        <p><?php echo htmlspecialchars($message['message']); ?></p>
                    </div>
                </div>

                <form method="POST" class="reply-form">
                    <div class="form-group">
                        <label for="reply">Your Response</label>
                        <textarea 
                            name="reply" 
                            id="reply" 
                            class="form-control" 
                            rows="6" 
                            placeholder="Type your response here..." 
                            required
                        ><?php echo ($message['replay'] !== 'waiting for reply') ? htmlspecialchars($message['replay']) : ''; ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Send Reply
                    </button>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Auto-resize textarea as user types
        const textarea = document.getElementById('reply');
        
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Initialize height
        textarea.dispatchEvent(new Event('input'));
    </script>
</body>
</html>