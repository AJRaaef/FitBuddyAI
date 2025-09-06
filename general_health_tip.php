<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitBuddy - Health Tips</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header Styles */
        header {
            background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%);
            color: white;
            padding: 20px 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
        }
        
        .logo i {
            margin-right: 10px;
        }
        
        /* Hero Section */
        .hero {
            background: url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80') no-repeat center center/cover;
            height: 400px;
            display: flex;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
            margin-bottom: 40px;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        
        .hero-content {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .hero h1 {
            font-size: 42px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }
        
        /* Category Navigation */
        .category-nav {
            background: white;
            padding: 20px 0;
            margin-bottom: 40px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        
        .category-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .category-btn {
            padding: 12px 25px;
            background: #f1f2f6;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .category-btn:hover, .category-btn.active {
            background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%);
            color: white;
        }
        
        /* Tips Section */
        .tips-section {
            padding: 20px 0 60px;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
            color: #2F3542;
            font-size: 36px;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: #FF6B6B;
            margin: 15px auto;
            border-radius: 2px;
        }
        
        .tips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }
        
        .tip-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .tip-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .tip-img {
            height: 200px;
            overflow: hidden;
        }
        
        .tip-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .tip-card:hover .tip-img img {
            transform: scale(1.1);
        }
        
        .tip-content {
            padding: 25px;
        }
        
        .tip-content h3 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #2F3542;
        }
        
        .tip-content p {
            color: #666;
            margin-bottom: 20px;
        }
        
        .tip-meta {
            display: flex;
            justify-content: space-between;
            color: #888;
            font-size: 14px;
        }
        
        /* Footer */
        footer {
            background: #2F3542;
            color: white;
            padding: 40px 0 20px;
            text-align: center;
        }
        
        .footer-content {
            margin-bottom: 30px;
        }
        
        .footer-logo {
            font-size: 24px;
            margin-bottom: 20px;
            display: inline-block;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .footer-links a {
            color: #E8F5E9;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: #FF6B6B;
            text-decoration: underline;
        }
        
        .social-icons a {
            display: inline-block;
            margin: 0 10px;
            color: white;
            font-size: 20px;
            transition: color 0.3s ease;
        }
        
        .social-icons a:hover {
            color: #FF6B6B;
        }
        
        .footer-bottom {
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 20px;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            
            .hero h1 {
                font-size: 32px;
            }
            
            .hero p {
                font-size: 16px;
            }
            
            .category-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .category-btn {
                width: 80%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-content">
            <div class="logo">
                <i class="fas fa-dumbbell"></i>
                FitBuddy
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Essential Health Tips for Everyone</h1>
            <p>Your guide to a healthier lifestyle with practical advice for nutrition, exercise, and overall wellbeing</p>
        </div>
    </section>

    <!-- Category Navigation -->
    <section class="category-nav">
        <div class="container">
            <div class="category-buttons">
                <button class="category-btn active">All Tips</button>
                <button class="category-btn">Nutrition</button>
                <button class="category-btn">Exercise</button>
                <button class="category-btn">Sleep</button>
                <button class="category-btn">Mental Health</button>
                <button class="category-btn">Hydration</button>
            </div>
        </div>
    </section>

    <!-- Tips Section -->
    <section class="tips-section">
        <div class="container">
            <h2 class="section-title">General Health Tips</h2>
            
            <div class="tips-grid">
                <!-- Tip 1 -->
                <div class="tip-card">
                    <div class="tip-img">
                        <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Balanced Diet">
                    </div>
                    <div class="tip-content">
                        <h3>Eat a Balanced Diet</h3>
                        <p>Focus on whole foods like fruits, vegetables, lean proteins, and whole grains. Try to fill half your plate with vegetables and fruits at each meal.</p>
                        <div class="tip-meta">
                            <span><i class="fas fa-utensils"></i> Nutrition</span>
                            <span><i class="fas fa-clock"></i> Daily</span>
                        </div>
                    </div>
                </div>
                
                <!-- Tip 2 -->
                <div class="tip-card">
                    <div class="tip-img">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Exercise">
                    </div>
                    <div class="tip-content">
                        <h3>Stay Active Daily</h3>
                        <p>Aim for at least 30 minutes of moderate exercise most days. This can include walking, swimming, cycling, or any activity you enjoy.</p>
                        <div class="tip-meta">
                            <span><i class="fas fa-running"></i> Exercise</span>
                            <span><i class="fas fa-clock"></i> 30 min/day</span>
                        </div>
                    </div>
                </div>
                
                <!-- Tip 3 -->
                <div class="tip-card">
                    <div class="tip-img">
                        <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Sleep">
                    </div>
                    <div class="tip-content">
                        <h3>Prioritize Quality Sleep</h3>
                        <p>Adults need 7-9 hours of quality sleep per night. Establish a regular sleep schedule and create a restful environment for better sleep.</p>
                        <div class="tip-meta">
                            <span><i class="fas fa-bed"></i> Sleep</span>
                            <span><i class="fas fa-clock"></i> 7-9 hours/night</span>
                        </div>
                    </div>
                </div>
                
                <!-- Tip 4 -->
                <div class="tip-card">
                    <div class="tip-img">
                        <img src="https://images.unsplash.com/photo-1590065480004-477ef6d4d5de?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Hydration">
                    </div>
                    <div class="tip-content">
                        <h3>Stay Hydrated</h3>
                        <p>Drink plenty of water throughout the day. Proper hydration helps maintain bodily functions, improves skin health, and boosts energy levels.</p>
                        <div class="tip-meta">
                            <span><i class="fas fa-tint"></i> Hydration</span>
                            <span><i class="fas fa-clock"></i> 8 glasses/day</span>
                        </div>
                    </div>
                </div>
                
                <!-- Tip 5 -->
                <div class="tip-card">
                    <div class="tip-img">
                        <img src="https://images.unsplash.com/photo-1518458028785-8fbcd101ebb9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Mental Health">
                    </div>
                    <div class="tip-content">
                        <h3>Practice Stress Management</h3>
                        <p>Try meditation, deep breathing, or yoga to manage stress. Taking care of your mental health is as important as physical health.</p>
                        <div class="tip-meta">
                            <span><i class="fas fa-brain"></i> Mental Health</span>
                            <span><i class="fas fa-clock"></i> Daily</span>
                        </div>
                    </div>
                </div>
                
                <!-- Tip 6 -->
                <div class="tip-card">
                    <div class="tip-img">
                        <img src="https://images.unsplash.com/photo-1504814532849-cff240bbc503?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Preventive Care">
                    </div>
                    <div class="tip-content">
                        <h3>Don't Skip Check-ups</h3>
                        <p>Regular health check-ups and screenings can detect potential health issues early. Don't skip your annual physical and recommended screenings.</p>
                        <div class="tip-meta">
                            <span><i class="fas fa-stethoscope"></i> Preventive Care</span>
                            <span><i class="fas fa-clock"></i> Yearly</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <i class="fas fa-dumbbell"></i> FitBuddy
                </div>
                
                <div class="footer-links">
                    <a href="#">Home</a>
                    <a href="#">About</a>
                    <a href="#">Services</a>
                    <a href="#">Contact</a>
                    <a href="#">Privacy Policy</a>
                </div>
                
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2023 FitBuddy. All rights reserved.</p>
            </div>
        </div>
    </footer>


</body>
</html>