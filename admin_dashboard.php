<?php
session_start();
require_once 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
// Fetch all health tips
$health_tips_result = $conn->query("
    SELECT h.*, a.full_name 
    FROM health_tips h
    JOIN admins a ON h.admin_id = a.admin_id
    ORDER BY h.created_at DESC
");

// ---------------------
// Fetch all user messages
// ---------------------
$messages_result = $conn->query("
    SELECT r.message_id, r.message, r.replay, r.created_at, u.first_name, u.last_name, u.email 
    FROM replay r
    JOIN users u ON r.user_id = u.user_id
    ORDER BY r.created_at DESC
");


// Fetch admin info
$admin_id = $_SESSION['admin_id'];
$stmt = $conn->prepare("SELECT * FROM admins WHERE admin_id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();
$stmt->close();

// ---------------------
// Dashboard Stats
// ---------------------

// Total users
$result = $conn->query("SELECT COUNT(*) as total FROM users");
$total_users = $result ? $result->fetch_assoc()['total'] : 0;

// Active users today
$result = $conn->query("SELECT COUNT(DISTINCT user_id) as total FROM user_activity WHERE DATE(activity_date) = CURDATE()");
$active_users_today = $result ? $result->fetch_assoc()['total'] : 0;

// Most popular fitness goal
$result = $conn->query("SELECT fitness_goal, COUNT(*) as count FROM users GROUP BY fitness_goal ORDER BY count DESC LIMIT 1");
$popular_plan = $result ? $result->fetch_assoc() : ['fitness_goal' => 'N/A', 'count' => 0];

// Average engagement last 30 days
$result = $conn->query("SELECT AVG(completion_rate) as avg FROM workout_sessions WHERE session_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
$avg_engagement = $result ? round($result->fetch_assoc()['avg'], 2) : 0;

// ---------------------
// Fetch all users
// ---------------------
$users_result = $conn->query("SELECT * FROM users ORDER BY user_id DESC");

// ---------------------
// Fetch all admins
// ---------------------
$admins_result = $conn->query("SELECT * FROM admins ORDER BY admin_id DESC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FitBuddyAI</title>
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
            padding: 20px;
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

        /* Dashboard Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            display: flex;
            align-items: center;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-right: 15px;
        }

        .stat-icon.users { background: rgba(67, 97, 238, 0.15); color: var(--primary); }
        .stat-icon.active { background: rgba(76, 201, 240, 0.15); color: var(--success); }
        .stat-icon.goal { background: rgba(249, 199, 79, 0.15); color: var(--warning); }
        .stat-icon.engagement { background: rgba(62, 207, 142, 0.15); color: var(--info); }

        .stat-info h3 {
            font-size: 1.5rem;
            margin-bottom: 5px;
            color: var(--dark);
        }

        .stat-info p {
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Section Styles */
        .section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: var(--card-shadow);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--light-gray);
        }

        .section-title {
            font-size: 1.4rem;
            color: var(--dark);
            font-weight: 600;
        }

        .add-btn {
            background: var(--info);
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: var(--transition);
        }

        .add-btn:hover {
            background: #2ebc7d;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid var(--light-gray);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
        }

        th {
            background-color: var(--light);
            font-weight: 600;
            color: var(--dark);
            position: sticky;
            top: 0;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: var(--transition);
        }

        .btn-edit {
            background: var(--success);
            color: white;
        }

        .btn-edit:hover {
            background: #3bb5d8;
        }

        .btn-delete {
            background: var(--danger);
            color: white;
        }

        .btn-delete:hover {
            background: #e51274;
        }

        .btn-reply {
            background: var(--warning);
            color: white;
        }

        .btn-reply:hover {
            background: #e6b301;
        }

        .thumb {
            height: 60px;
            width: auto;
            border-radius: 4px;
            object-fit: cover;
        }

        .status-waiting {
            color: #e67e22;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-replied {
            color: #27ae60;
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
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
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
                    <a href="#dashboard" class="nav-link active">
                        <i class="fas fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#users" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>User Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#admins" class="nav-link">
                        <i class="fas fa-user-shield"></i>
                        <span>Admin Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#messages" class="nav-link">
                        <i class="fas fa-envelope"></i>
                        <span>Messages</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#health-tips" class="nav-link">
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
                    <h1>Admin Dashboard</h1>
                    <p>Welcome back, <?php echo htmlspecialchars($admin['full_name']); ?></p>
                </div>
                <a href="admin_logout.php" class="logout-btn">
                    <i class="admin_logout.php"></i> Logout
                </a>
            </div>

            <!-- Dashboard Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon users">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $total_users; ?></h3>
                        <p>Total Users</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon active">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $active_users_today; ?></h3>
                        <p>Active Today</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon goal">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $popular_plan['count']; ?></h3>
                        <p><?php echo htmlspecialchars($popular_plan['fitness_goal']); ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon engagement">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $avg_engagement; ?>%</h3>
                        <p>Avg Engagement (30 days)</p>
                    </div>
                </div>
            </div>

            <!-- User Management Section -->
            <section id="users" class="section">
                <div class="section-header">
                    <h2 class="section-title">User Management</h2>
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Weight</th>
                                <th>Height</th>
                                <th>Goal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($users_result && $users_result->num_rows > 0): ?>
                                <?php $i = 1; while($user = $users_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['phone_number']); ?></td>
                                        <td><?php echo htmlspecialchars($user['gender']); ?></td>
                                        <td><?php echo htmlspecialchars($user['age']); ?></td>
                                        <td><?php echo htmlspecialchars($user['weight_kg']); ?> kg</td>
                                        <td><?php echo htmlspecialchars($user['height_cm']); ?> cm</td>
                                        <td><?php echo htmlspecialchars($user['fitness_goal']); ?></td>
                                        <td><?php echo htmlspecialchars($user['status']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="10" style="text-align:center;">No users found</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Admin Management Section -->
            <section id="admins" class="section">
                <div class="section-header">
                    <h2 class="section-title">Admin Management</h2>
                    <a href="create_admin.php" class="add-btn">
                        <i class="fas fa-plus"></i> Add New Admin
                    </a>
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($admins_result && $admins_result->num_rows > 0): ?>
                                <?php $i = 1; while($a = $admins_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($a['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($a['email']); ?></td>
                                        <td><?php echo htmlspecialchars($a['phone_number']); ?></td>
                                        <td><?php echo htmlspecialchars($a['role']); ?></td>
                                        <td><?php echo htmlspecialchars($a['status']); ?></td>
                                        <td class="action-buttons">
                                            <a href="edit_admin.php?admin_id=<?php echo $a['admin_id']; ?>" class="btn btn-edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="delete_admin.php?admin_id=<?php echo $a['admin_id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?');">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="7" style="text-align:center;">No admins found</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Messages Section -->
            <section id="messages" class="section">
                <div class="section-header">
                    <h2 class="section-title">User Messages</h2>
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Reply</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($messages_result && $messages_result->num_rows > 0): ?>
                                <?php $i = 1; while($msg = $messages_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($msg['first_name'] . ' ' . $msg['last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($msg['email']); ?></td>
                                        <td><?php echo htmlspecialchars($msg['message']); ?></td>
                                        <td>
                                            <?php if ($msg['replay'] === 'waiting for reply'): ?>
                                                <span class="status-waiting"><i class="fas fa-clock"></i> Waiting for reply</span>
                                            <?php else: ?>
                                                <span class="status-replied"><?php echo htmlspecialchars($msg['replay']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="action-buttons">
                                            <a href="reply_message.php?message_id=<?php echo $msg['message_id']; ?>" class="btn btn-reply">
                                                <i class="fas fa-reply"></i> Reply
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="6" style="text-align:center;">No messages found</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Health Tips Section -->
            <section id="health-tips" class="section">
                <div class="section-header">
                    <h2 class="section-title">Health Tips Management</h2>
                    <a href="add_health_tip.php" class="add-btn">
                        <i class="fas fa-plus"></i> Add New Tip
                    </a>
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($health_tips_result && $health_tips_result->num_rows > 0): ?>
                                <?php $i = 1; while($tip = $health_tips_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td>
                                            <?php if ($tip['image_url']): ?>
                                                <img src="<?php echo htmlspecialchars($tip['image_url']); ?>" class="thumb" alt="Tip Image">
                                            <?php else: ?>
                                                <span>No Image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($tip['title']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($tip['description'],0,50)); ?>...</td>
                                        <td><?php echo htmlspecialchars($tip['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($tip['created_at']); ?></td>
                                        <td class="action-buttons">
                                            <a href="edit_health_tip.php?tip_id=<?php echo $tip['tip_id']; ?>" class="btn btn-edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="delete_health_tip.php?tip_id=<?php echo $tip['tip_id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?');">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="7" style="text-align:center;">No health tips found</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Simple navigation highlighting
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            const sections = document.querySelectorAll('.section');
            
            // Highlight active section in sidebar
            function highlightNav() {
                let currentSection = '';
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (scrollY >= sectionTop - 100) {
                        currentSection = section.getAttribute('id');
                    }
                });
                
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href').substring(1) === currentSection) {
                        link.classList.add('active');
                    }
                });
            }
            
            // Initial highlight
            highlightNav();
            
            // Highlight on scroll
            window.addEventListener('scroll', highlightNav);
            
            // Smooth scroll for navigation
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href').startsWith('#')) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href');
                        const targetSection = document.querySelector(targetId);
                        
                        window.scrollTo({
                            top: targetSection.offsetTop - 20,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>