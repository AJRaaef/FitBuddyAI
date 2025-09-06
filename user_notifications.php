<?php
session_start();
// Database connection
$host = 'localhost';
$dbname = 'fitbuddyai';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Get user ID from session
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    die("User not logged in");
}

// Function to add notification to the notifications table
function addNotification($pdo, $user_id, $title, $message, $type) {
    $sql = "INSERT INTO notifications (user_id, title, message, type, created_at) 
            VALUES (?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $title, $message, $type]);
    return $stmt->rowCount();
}

// Check for new nutrition suggestions and add notifications
$nutrition_sql = "SELECT * FROM user_suggested_nutrition 
                 WHERE user_id = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 DAY)
                 AND id NOT IN (SELECT source_id FROM notifications WHERE user_id = ? AND type = 'nutrition')";
$nutrition_stmt = $pdo->prepare($nutrition_sql);
$nutrition_stmt->execute([$user_id, $user_id]);
$new_nutrition = $nutrition_stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($new_nutrition as $nutrition) {
    $title = "New Meal Plan";
    $message = "We've suggested " . $nutrition['food_name'] . " for your " . $nutrition['meal_type'] . " with " . $nutrition['calories'] . " calories";
    addNotification($pdo, $user_id, $title, $message, 'nutrition');
}

// Check for new workout suggestions and add notifications
$workout_sql = "SELECT * FROM user_suggested_workouts 
               WHERE user_id = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 DAY)
               AND id NOT IN (SELECT source_id FROM notifications WHERE user_id = ? AND type = 'workout')";
$workout_stmt = $pdo->prepare($workout_sql);
$workout_stmt->execute([$user_id, $user_id]);
$new_workouts = $workout_stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($new_workouts as $workout) {
    $title = "New Workout Plan";
    $message = "We've suggested " . $workout['exercise_name'] . " for " . $workout['duration_min'] . " minutes with " . $workout['intensity'] . " intensity";
    addNotification($pdo, $user_id, $title, $message, 'workout');
}

// Get all notifications for the user
$notifications_sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$notifications_stmt = $pdo->prepare($notifications_sql);
$notifications_stmt->execute([$user_id]);
$notifications = $notifications_stmt->fetchAll(PDO::FETCH_ASSOC);

// Mark notifications as read when page loads
if (!empty($notifications)) {
    $update_sql = "UPDATE notifications SET is_read = 1 WHERE user_id = ? AND is_read = 0";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->execute([$user_id]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Notifications | FitBuddyAI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6a11cb;
            --primary-gradient: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            --secondary: #2575fc;
            --text-primary: #2c3e50;
            --text-secondary: #7f8c8d;
            --bg-light: #f8f9fa;
            --bg-white: #ffffff;
            --border-light: #eaeaea;
            --success: #2ecc71;
            --info: #3498db;
            --warning: #f1c40f;
            --danger: #e74c3c;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --radius: 12px;
            --transition: all 0.3s ease;
        }

        .dark-mode {
            --primary: #8b5cf6;
            --primary-gradient: linear-gradient(135deg, #8b5cf6 0%, #3b82f6 100%);
            --text-primary: #f8f9fa;
            --text-secondary: #adb5bd;
            --bg-light: #1a1d21;
            --bg-white: #23272e;
            --border-light: #343a40;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        
        body {
            background-color: var(--bg-light);
            color: var(--text-primary);
            line-height: 1.6;
            padding: 0;
            transition: var(--transition);
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border-light);
        }
        
        .app-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .app-logo {
            width: 40px;
            height: 40px;
            background: var(--primary-gradient);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }
        
        h1 {
            font-size: 28px;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .theme-toggle {
            background: none;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background-color: var(--bg-white);
            color: var(--text-primary);
            box-shadow: var(--shadow);
            transition: var(--transition);
        }
        
        .theme-toggle:hover {
            transform: rotate(30deg);
        }
        
        .notification-card {
            background: var(--bg-white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 30px;
            transition: var(--transition);
        }
        
        .notification-header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-light);
        }
        
        .notification-title {
            font-weight: 600;
            font-size: 18px;
        }
        
        .notification-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 20px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            color: white;
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid var(--border-light);
            color: var(--text-secondary);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .filter-bar {
            display: flex;
            padding: 15px 20px;
            background-color: var(--bg-light);
            border-bottom: 1px solid var(--border-light);
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .filter-button {
            background: var(--bg-white);
            border: 1px solid var(--border-light);
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .filter-button.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .filter-button:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .notification-list {
            max-height: 600px;
            overflow-y: auto;
        }
        
        .notification-item {
            display: flex;
            padding: 20px;
            border-bottom: 1px solid var(--border-light);
            position: relative;
            transition: var(--transition);
            animation: fadeIn 0.5s ease;
        }
        
        .notification-item:last-child {
            border-bottom: none;
        }
        
        .notification-item:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
        
        .notification-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            flex-shrink: 0;
            font-size: 20px;
        }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-item-title {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 5px;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .notification-item-message {
            color: var(--text-secondary);
            margin-bottom: 10px;
            line-height: 1.5;
        }
        
        .notification-time {
            font-size: 12px;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .notification-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--danger);
            color: white;
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 20px;
            animation: pulse 2s infinite;
        }
        
        .workout .notification-icon {
            background-color: rgba(52, 152, 219, 0.15);
            color: var(--info);
        }
        
        .nutrition .notification-icon {
            background-color: rgba(46, 204, 113, 0.15);
            color: var(--success);
        }
        
        .goal .notification-icon {
            background-color: rgba(155, 89, 182, 0.15);
            color: #9b59b6;
        }
        
        .health .notification-icon {
            background-color: rgba(241, 196, 15, 0.15);
            color: var(--warning);
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }
        
        .empty-state i {
            font-size: 60px;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .empty-state h3 {
            font-size: 20px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .empty-state p {
            font-size: 16px;
            max-width: 400px;
            margin: 0 auto;
        }
        
        .notification-stats {
            display: flex;
            padding: 15px 20px;
            background-color: var(--bg-light);
            border-top: 1px solid var(--border-light);
            justify-content: space-between;
            font-size: 14px;
            color: var(--text-secondary);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(231, 76, 60, 0); }
            100% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0); }
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            
            .header-actions {
                justify-content: center;
            }
            
            .notification-item {
                flex-direction: column;
            }
            
            .notification-icon {
                margin-bottom: 15px;
                margin-right: 0;
            }
            
            .notification-badge {
                position: static;
                margin-top: 10px;
                display: inline-block;
                align-self: flex-start;
            }
            
            .filter-bar {
                overflow-x: auto;
                padding-bottom: 10px;
            }
            
            .filter-bar::-webkit-scrollbar {
                height: 5px;
            }
            
            .filter-bar::-webkit-scrollbar-thumb {
                background: var(--text-secondary);
                border-radius: 10px;
            }
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--bg-light);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--text-secondary);
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="app-brand">
                <div class="app-logo">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <h1>FitBuddyAI Notifications</h1>
            </div>
            <div class="header-actions">
                <button class="theme-toggle" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>
                <button class="btn btn-outline">
                    <i class="fas fa-cog"></i> Settings
                </button>
            </div>
        </header>
        
        <div class="notification-card">
            <div class="notification-header">
                <div class="notification-title">
                    <i class="fas fa-bell"></i> Your Activity
                </div>
                <div class="notification-actions">
                    <button class="btn btn-outline" id="markAllRead">
                        <i class="fas fa-check-double"></i> Mark all as read
                    </button>
                    <button class="btn btn-primary" id="refreshNotifications">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>
            
            <div class="filter-bar">
                <button class="filter-button active" data-filter="all">
                    <i class="fas fa-layer-group"></i> All
                </button>
                <button class="filter-button" data-filter="unread">
                    <i class="fas fa-envelope"></i> Unread
                </button>
                <button class="filter-button" data-filter="workout">
                    <i class="fas fa-running"></i> Workout
                </button>
                <button class="filter-button" data-filter="nutrition">
                    <i class="fas fa-utensils"></i> Nutrition
                </button>
                <button class="filter-button" data-filter="goal">
                    <i class="fas fa-bullseye"></i> Goals
                </button>
            </div>
            
            <div class="notification-list">
                <?php if (count($notifications) > 0): ?>
                    <?php foreach ($notifications as $notification): ?>
                        <div class="notification-item <?php echo $notification['type']; ?>" data-type="<?php echo $notification['type']; ?>" data-read="<?php echo $notification['is_read'] ?? 0; ?>">
                            <div class="notification-icon">
                                <?php 
                                switch($notification['type']) {
                                    case 'workout': echo '<i class="fas fa-running"></i>'; break;
                                    case 'nutrition': echo '<i class="fas fa-utensils"></i>'; break;
                                    case 'goal': echo '<i class="fas fa-bullseye"></i>'; break;
                                    default: echo '<i class="fas fa-heart"></i>';
                                }
                                ?>
                            </div>
                            <div class="notification-content">
                                <h3 class="notification-item-title">
                                    <?php echo htmlspecialchars($notification['title']); ?>
                                    <?php if (($notification['is_read'] ?? 0) == 0): ?>
                                        <span style="color: var(--danger); font-size: 12px;">(Unread)</span>
                                    <?php endif; ?>
                                </h3>
                                <p class="notification-item-message"><?php echo htmlspecialchars($notification['message']); ?></p>
                                <span class="notification-time">
                                    <i class="far fa-clock"></i>
                                    <?php 
                                    $created = new DateTime($notification['created_at']);
                                    $now = new DateTime();
                                    $interval = $now->diff($created);
                                    
                                    if ($interval->y > 0) echo $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
                                    else if ($interval->m > 0) echo $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
                                    else if ($interval->d > 0) echo $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
                                    else if ($interval->h > 0) echo $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
                                    else if ($interval->i > 0) echo $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
                                    else echo 'Just now';
                                    ?>
                                </span>
                            </div>
                            <?php if (strtotime($notification['created_at']) > time() - 86400 && ($notification['is_read'] ?? 0) == 0): // New in last 24 hours ?>
                                <span class="notification-badge">New</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="far fa-bell-slash"></i>
                        <h3>No notifications yet</h3>
                        <p>We'll notify you when there's new activity or suggestions for your fitness journey</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (count($notifications) > 0): ?>
            <div class="notification-stats">
                <span><?php echo count($notifications); ?> total notifications</span>
                <span>
                    <?php 
                    $unread_count = 0;
                    foreach ($notifications as $n) {
                        if (($n['is_read'] ?? 0) == 0) $unread_count++;
                    }
                    echo $unread_count . ' unread';
                    ?>
                </span>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Theme toggle functionality
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = themeToggle.querySelector('i');
        
        // Check for saved theme preference or respect OS preference
        const savedTheme = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        if (savedTheme === 'dark') {
            document.body.classList.add('dark-mode');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        }
        
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                localStorage.setItem('theme', 'light');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        });
        
        // Filter functionality
        document.querySelectorAll('.filter-button').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.filter-button').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Add active class to clicked button
                this.classList.add('active');
                
                const filterType = this.getAttribute('data-filter');
                const notifications = document.querySelectorAll('.notification-item');
                
                notifications.forEach(notification => {
                    if (filterType === 'all') {
                        notification.style.display = 'flex';
                    } else if (filterType === 'unread') {
                        if (notification.getAttribute('data-read') === '0') {
                            notification.style.display = 'flex';
                        } else {
                            notification.style.display = 'none';
                        }
                    } else {
                        if (notification.getAttribute('data-type') === filterType) {
                            notification.style.display = 'flex';
                        } else {
                            notification.style.display = 'none';
                        }
                    }
                });
                
                // Check if any notifications are visible after filtering
                const visibleNotifications = Array.from(notifications).some(n => n.style.display !== 'none');
                
                // Show empty state if no notifications match the filter
                const emptyState = document.querySelector('.empty-state');
                if (!visibleNotifications && !emptyState) {
                    const notificationList = document.querySelector('.notification-list');
                    notificationList.innerHTML = `
                        <div class="empty-state">
                            <i class="far fa-filter"></i>
                            <h3>No notifications found</h3>
                            <p>Try changing your filters to see more notifications</p>
                        </div>
                    `;
                } else if (visibleNotifications && emptyState) {
                    // Reload the page to show all notifications again
                    window.location.reload();
                }
            });
        });
        
        // Mark all as read functionality
        document.getElementById('markAllRead').addEventListener('click', function() {
            // Make an AJAX request to mark all as read
            fetch('mark_read.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ markAllRead: true })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI
                    document.querySelectorAll('.notification-item').forEach(item => {
                        item.setAttribute('data-read', '1');
                        const badge = item.querySelector('.notification-badge');
                        if (badge) badge.remove();
                        
                        const title = item.querySelector('.notification-item-title');
                        const unreadSpan = title.querySelector('span');
                        if (unreadSpan) unreadSpan.remove();
                    });
                    
                    // Update notification stats
                    const stats = document.querySelector('.notification-stats');
                    if (stats) {
                        const parts = stats.lastElementChild.textContent.split(' ');
                        parts[0] = '0';
                        stats.lastElementChild.textContent = parts.join(' ');
                    }
                    
                    // Show confirmation
                    showToast('All notifications marked as read');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error marking notifications as read', 'error');
            });
        });
        
        // Refresh notifications
        document.getElementById('refreshNotifications').addEventListener('click', function() {
            this.classList.add('fa-spin');
            setTimeout(() => {
                window.location.reload();
            }, 800);
        });
        
        // Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.textContent = message;
            toast.style.position = 'fixed';
            toast.style.bottom = '20px';
            toast.style.right = '20px';
            toast.style.padding = '12px 20px';
            toast.style.background = type === 'success' ? 'var(--success)' : 'var(--danger)';
            toast.style.color = 'white';
            toast.style.borderRadius = 'var(--radius)';
            toast.style.boxShadow = 'var(--shadow)';
            toast.style.zIndex = '1000';
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s';
            
            document.body.appendChild(toast);
            
            // Fade in
            setTimeout(() => {
                toast.style.opacity = '1';
            }, 10);
            
            // Fade out and remove after 3 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }
        
        // Add subtle animation to notifications on page load
        document.addEventListener('DOMContentLoaded', () => {
            const notifications = document.querySelectorAll('.notification-item');
            notifications.forEach((notification, index) => {
                notification.style.animationDelay = `${index * 0.05}s`;
            });
        });
    </script>
</body>
</html>