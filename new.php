<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitBuddy Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        :root {
            --primary: #3498db;
            --secondary: #8e44ad;
            --accent: #2ecc71;
            --dark: #2c3e50;
            --light: #ecf0f1;
            --gray: #95a5a6;
            --danger: #e74c3c;
            --warning: #f39c12;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            background: var(--dark);
            color: white;
            padding: 20px;
            position: fixed;
            width: 250px;
            height: 100%;
            overflow-y: auto;
        }
        
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logo i {
            font-size: 24px;
            margin-right: 10px;
            color: var(--accent);
        }
        
        .logo h1 {
            font-size: 22px;
            font-weight: 700;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .nav-item:hover, .nav-item.active {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .nav-item i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        /* Main Content */
        .main-content {
            grid-column: 2;
            padding: 30px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .welcome h1 {
            font-size: 28px;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .date {
            color: var(--gray);
            font-size: 16px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid var(--primary);
        }
        
        /* Cards */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        /* User Profile */
        .user-profile {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .profile-item {
            display: flex;
            flex-direction: column;
        }
        
        .profile-label {
            font-size: 14px;
            color: var(--gray);
            margin-bottom: 5px;
        }
        
        .profile-value {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
        }
        
        /* Health Data */
        .symptoms-list {
            list-style-type: none;
            margin-bottom: 20px;
        }
        
        .symptoms-list li {
            padding: 8px 0;
            padding-left: 25px;
            position: relative;
        }
        
        .symptoms-list li:before {
            content: "•";
            color: var(--warning);
            font-size: 20px;
            position: absolute;
            left: 0;
            top: 5px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: #2980b9;
        }
        
        /* Goals */
        .goals-list {
            list-style-type: none;
        }
        
        .goals-list li {
            padding: 10px 0;
            padding-left: 30px;
            position: relative;
            border-bottom: 1px solid #eee;
        }
        
        .goals-list li:last-child {
            border-bottom: none;
        }
        
        .goals-list li:before {
            content: "✓";
            color: var(--accent);
            position: absolute;
            left: 0;
            top: 10px;
            font-size: 16px;
        }
        
        /* Last Updated */
        .last-updated {
            text-align: center;
            color: var(--gray);
            font-size: 14px;
            margin: 20px 0;
        }
        
        /* Recommendations */
        .recommendations {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .recommendation-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
            border-left: 4px solid var(--accent);
        }
        
        .recommendation-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: var(--dark);
        }
        
        .recommendation-card p {
            color: #555;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        
        .learn-more {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }
        
        .learn-more i {
            margin-left: 5px;
            font-size: 14px;
        }
        
        .learn-more:hover {
            text-decoration: underline;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }
            
            .main-content {
                grid-column: 1;
            }
            
            .user-profile {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        @media (max-width: 576px) {
            .user-profile {
                grid-template-columns: 1fr;
            }
            
            .recommendations {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .user-info {
                margin-top: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <i class="fas fa-dumbbell"></i>
                <h1>FitBuddy</h1>
            </div>
            
            <div class="nav-item active">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-heartbeat"></i>
                <span>Health Data</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-running"></i>
                <span>Workouts</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-utensils"></i>
                <span>Nutrition</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-chart-line"></i>
                <span>Progress</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="welcome">
                    <h1>Welcome back, John!</h1>
                    <div class="date" id="current-date">Tuesday, September 2, 2025</div>
                </div>
                <div class="user-info">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" alt="John Doe" class="user-img">
                    <div>John Doe</div>
                </div>
            </div>
            
            <!-- User Profile -->
            <div class="card">
                <h2 class="card-title">John Doe <span style="font-size: 16px; color: var(--gray); font-weight: normal;">32 years old</span></h2>
                <div class="user-profile">
                    <div class="profile-item">
                        <span class="profile-label">Weight</span>
                        <span class="profile-value">78 kg</span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Height</span>
                        <span class="profile-value">180 cm</span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Activity</span>
                        <span class="profile-value">Moderate</span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Diet</span>
                        <span class="profile-value">Balanced</span>
                    </div>
                </div>
            </div>
            
            <!-- Health Data -->
            <div class="card">
                <h2 class="card-title">Health Data</h2>
                <h3 style="margin-bottom: 10px; font-size: 16px;">Recent Symptoms</h3>
                <ul class="symptoms-list">
                    <li>Occasional lower back pain</li>
                    <li>Mild fatigue after workouts</li>
                </ul>
                <button class="btn btn-primary">Update Health Data</button>
            </div>
            
            <!-- Fitness Goals -->
            <div class="card">
                <h2 class="card-title">Fitness Goals</h2>
                <ul class="goals-list">
                    <li>Lose 5kg in 3 months</li>
                    <li>Improve overall strength</li>
                    <li>Run 5k without stopping</li>
                </ul>
            </div>
            
            <!-- Last Updated -->
            <div class="last-updated">Last updated: 2 days ago</div>
            
            <!-- AI Recommendations -->
            <h2 class="card-title">AI Recommendations</h2>
            <div class="recommendations">
                <div class="recommendation-card">
                    <h3>Increase Protein Intake</h3>
                    <p>Based on your goals, try to consume 1.6-1.8g of protein per kg of body weight daily to support muscle recovery and growth.</p>
                    <a href="#" class="learn-more">Learn more <i class="fas fa-chevron-right"></i></a>
                </div>
                
                <div class="recommendation-card">
                    <h3>Add HIIT Training</h3>
                    <p>Adding 2 high-intensity interval training sessions per week can help you reach your weight loss goals faster.</p>
                    <a href="#" class="learn-more">Learn more <i class="fas fa-chevron-right"></i></a>
                </div>
                
                <div class="recommendation-card">
                    <h3>Improve Sleep Quality</h3>
                    <p>Your sleep data shows irregular patterns. Try to maintain a consistent sleep schedule to improve recovery.</p>
                    <a href="#" class="learn-more">Learn more <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to update the current date
        function updateDate() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('current-date').textContent = now.toLocaleDateString('en-US', options);
        }
        
        // Initialize the date on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateDate();
            
            // Add click event to navigation items
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    navItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>