<?php
session_start();
require 'db.php';

// Fetch health tips from DB
$sql = "SELECT * FROM health_tips ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Tips | FitBuddy</title>
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
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
            display: inline-block;
        }

        .header p {
            color: var(--gray);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .header-icon {
            font-size: 2.8rem;
            margin-bottom: 15px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .filter-bar {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 20px;
            background: white;
            border: 2px solid var(--primary);
            border-radius: 30px;
            color: var(--primary);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-btn:hover, .filter-btn.active {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .tips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .tip-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .tip-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .tip-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .tip-content {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .tip-category {
            display: inline-block;
            padding: 5px 12px;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .tip-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: var(--dark);
            line-height: 1.3;
        }

        .tip-description {
            color: var(--gray);
            margin-bottom: 20px;
            flex-grow: 1;
            line-height: 1.6;
        }

        .tip-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .tip-date {
            font-size: 0.85rem;
            color: var(--gray);
        }

        .read-more {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: var(--transition);
        }

        .read-more:hover {
            color: var(--secondary);
            gap: 8px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            grid-column: 1 / -1;
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--gray);
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--gray);
            max-width: 500px;
            margin: 0 auto;
        }

        /* Animation for cards */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tip-card {
            animation: fadeInUp 0.5s ease forwards;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .tips-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 20px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .filter-bar {
                gap: 10px;
            }
            
            .filter-btn {
                padding: 8px 16px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .tips-grid {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 1.8rem;
            }
            
            .header p {
                font-size: 1rem;
            }
            
            body {
                padding: 15px;
            }
        }

        /* Custom scrollbar for webkit browsers */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-icon">
                <i class="fas fa-heartbeat"></i>
            </div>
            <h1>Health & Wellness Tips</h1>
            <p>Discover expert advice to improve your health, fitness, and overall well-being</p>
        </div>

        <div class="filter-bar">
            <button class="filter-btn active">All Tips</button>
            <button class="filter-btn">Nutrition</button>
            <button class="filter-btn">Exercise</button>
            <button class="filter-btn">Mental Health</button>
            <button class="filter-btn">Prevention</button>
        </div>

        <div class="tips-grid">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="tip-card">
                        <?php if (!empty($row['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Health Tip" class="tip-image">
                        <?php else: ?>
                            <div style="height: 200px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-heartbeat" style="font-size: 3rem; color: white;"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="tip-content">
                            <span class="tip-category">Wellness</span>
                            <h3 class="tip-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                            <p class="tip-description"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                            
                            <div class="tip-footer">
                                <span class="tip-date">
                                    <i class="far fa-calendar-alt"></i> 
                                    <?php echo date("M d, Y", strtotime($row['created_at'])); ?>
                                </span>
                                <a href="#" class="read-more">
                                    Read more <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3>No health tips available yet</h3>
                    <p>Check back later for new health and wellness tips from our experts.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Simple filter functionality
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // In a real application, you would filter the content here
                // For this example, we'll just show a notification
                console.log('Filtering by: ' + this.textContent);
            });
        });

        // Add animation delay to cards for staggered effect
        document.querySelectorAll('.tip-card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    </script>
</body>
</html>