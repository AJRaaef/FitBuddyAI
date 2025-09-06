<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FitBuddy AI - Your Personal Fitness Assistant</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #4361ee;
      --secondary: #3a0ca3;
      --accent: #4cc9f0;
      --success: #4ade80;
      --light: #f8f9fa;
      --dark: #212529;
      --gradient-primary: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
      --gradient-accent: linear-gradient(135deg, #4cc9f0 0%, #3a0ca3 100%);
      --gradient-bg: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      --transition: all 0.3s ease;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--gradient-bg);
      color: var(--dark);
      line-height: 1.6;
      overflow-x: hidden;
    }

    h1, h2, h3, h4, h5, h6 {
      font-family: 'Montserrat', sans-serif;
      font-weight: 700;
    }

    .navbar {
      background: rgba(255, 255, 255, 0.95);
      box-shadow: var(--shadow);
      padding: 15px 0;
      backdrop-filter: blur(10px);
    }

    .navbar-brand {
      font-weight: 800;
      font-size: 1.8rem;
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 80px 0;
      position: relative;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: -100px;
      right: -100px;
      width: 500px;
      height: 500px;
      border-radius: 50%;
      background: var(--gradient-accent);
      opacity: 0.1;
      z-index: -1;
    }

    .hero::after {
      content: '';
      position: absolute;
      bottom: -100px;
      left: -100px;
      width: 400px;
      height: 400px;
      border-radius: 50%;
      background: var(--gradient-primary);
      opacity: 0.1;
      z-index: -1;
    }

    .hero-title {
      font-size: 3.5rem;
      font-weight: 800;
      margin-bottom: 24px;
      line-height: 1.2;
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .hero-text {
      font-size: 1.25rem;
      margin-bottom: 40px;
      color: #555;
    }

    .btn-custom {
      padding: 14px 32px;
      font-size: 1.1rem;
      border-radius: 50px;
      font-weight: 600;
      transition: var(--transition);
      border: none;
      box-shadow: var(--shadow);
    }

    .btn-primary-custom {
      background: var(--gradient-primary);
      color: white;
    }

    .btn-primary-custom:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 25px rgba(67, 97, 238, 0.3);
    }

    .btn-outline-custom {
      border: 2px solid var(--primary);
      color: var(--primary);
      background: transparent;
    }

    .btn-outline-custom:hover {
      background: var(--primary);
      color: white;
      transform: translateY(-3px);
    }

    .hero-image {
      position: relative;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: var(--shadow);
      transform: perspective(1000px) rotateY(-5deg) rotateX(5deg);
      transition: var(--transition);
    }

    .hero-image:hover {
      transform: perspective(1000px) rotateY(0) rotateX(0);
    }

    .hero-image img {
      width: 100%;
      height: auto;
      transition: var(--transition);
    }

    .hero-image::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: var(--gradient-primary);
      opacity: 0.1;
      z-index: 1;
    }

    .features {
      padding: 100px 0;
      background: white;
    }

    .feature-card {
      background: white;
      border-radius: 16px;
      padding: 30px;
      box-shadow: var(--shadow);
      transition: var(--transition);
      height: 100%;
      border: 1px solid rgba(67, 97, 238, 0.1);
    }

    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .feature-icon {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background: rgba(67, 97, 238, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      color: var(--primary);
      font-size: 28px;
    }

    .section-title {
      text-align: center;
      margin-bottom: 60px;
      font-size: 2.5rem;
      font-weight: 800;
      color: var(--dark);
    }

    .section-title span {
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    footer {
      background: var(--dark);
      color: white;
      padding: 60px 0 30px;
    }

    .footer-links h5 {
      margin-bottom: 20px;
      font-weight: 600;
    }

    .footer-links ul {
      list-style: none;
      padding: 0;
    }

    .footer-links li {
      margin-bottom: 10px;
    }

    .footer-links a {
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      transition: var(--transition);
    }

    .footer-links a:hover {
      color: white;
    }

    .social-icons {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }

    .social-icons a {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      transition: var(--transition);
    }

    .social-icons a:hover {
      background: var(--primary);
      transform: translateY(-3px);
    }

    .copyright {
      text-align: center;
      margin-top: 40px;
      padding-top: 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      color: rgba(255, 255, 255, 0.6);
    }

    /* Animation */
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    .floating {
      animation: float 5s ease-in-out infinite;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .hero-title {
        font-size: 2.8rem;
      }
      
      .hero-text {
        font-size: 1.1rem;
      }
      
      .hero-image {
        transform: none;
        margin-top: 50px;
      }
    }

    @media (max-width: 768px) {
      .hero-title {
        font-size: 2.2rem;
      }
      
      .section-title {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand" href="#">
        <i class="fas fa-dumbbell me-2"></i>FitBuddy AI
      </a>
      <div class="d-flex ms-auto">
        <a href="user_signin.php" class="btn btn-outline-custom me-2">Sign In</a>
        <a href="signup_user.php" class="btn btn-primary-custom">Sign Up</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <div class="row align-items-center">
        
        <!-- Left side -->
        <div class="col-lg-6">
          <h1 class="hero-title">Transform Your Fitness Journey with AI</h1>
          <p class="hero-text">FitBuddy AI combines cutting-edge artificial intelligence with fitness expertise to deliver personalized workout plans, nutrition guidance, and progress tracking—all in one powerful platform.</p>
          <div class="d-flex flex-wrap gap-3">
            <a href="signup_user.php" class="btn btn-primary-custom btn-custom">
              <i class="fas fa-rocket me-2"></i>Get Started
            </a>
            <a href="user_signin.php" class="btn btn-outline-custom btn-custom">
              <i class="fas fa-sign-in-alt me-2"></i>Sign In
            </a>
          </div>
        </div>

        <!-- Right side -->
        <div class="col-lg-6">
          <div class="hero-image floating">
            <img src="images/gym.avif" alt="Fitness Illustration">
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features">
    <div class="container">
      <h2 class="section-title">Why Choose <span>FitBuddy AI</span></h2>
      
      <div class="row g-4">
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-brain"></i>
            </div>
            <h3>AI-Powered Plans</h3>
            <p>Get personalized workout and nutrition plans that adapt to your progress and goals using advanced machine learning algorithms.</p>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <h3>Progress Tracking</h3>
            <p>Monitor your fitness journey with detailed analytics, visual progress reports, and intelligent insights to keep you motivated.</p>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-heartbeat"></i>
            </div>
            <h3>Health Monitoring</h3>
            <p>Track vital health metrics, receive alerts, and get recommendations based on your body's responses to different exercises and diets.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-4">
          <h3 class="fw-bold"><i class="fas fa-dumbbell me-2"></i>FitBuddy AI</h3>
          <p>Your personal AI fitness assistant that helps you achieve your health and wellness goals through personalized guidance.</p>
          <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
        
        <div class="col-lg-2 col-md-4 mb-4">
          <div class="footer-links">
            <h5>Quick Links</h5>
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">About</a></li>
              <li><a href="#">Features</a></li>
              <li><a href="#">Pricing</a></li>
            </ul>
          </div>
        </div>
        
        <div class="col-lg-2 col-md-4 mb-4">
          <div class="footer-links">
            <h5>Support</h5>
            <ul>
              <li><a href="#">Help Center</a></li>
              <li><a href="#">FAQ</a></li>
              <li><a href="#">Contact</a></li>
              <li><a href="#">Community</a></li>
            </ul>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-4 mb-4">
          <div class="footer-links">
            <h5>Newsletter</h5>
            <p>Subscribe to get updates on new features and fitness tips.</p>
            <div class="input-group mb-3">
              <input type="email" class="form-control" placeholder="Your email">
              <button class="btn btn-primary" type="button">Subscribe</button>
            </div>
          </div>
        </div>
      </div>
      
      <div class="copyright">
        <p>&copy; <?php echo date("Y"); ?> FitBuddy AI. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>