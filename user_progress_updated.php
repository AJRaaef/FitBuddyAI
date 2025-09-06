<?php
session_start();
require 'db.php';

// ----------------------
// Ensure user logged in
// ----------------------
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo "You must be logged in to access this page.";
    exit;
}

// ----------------------
// Fetch latest user details
// ----------------------
$sql = "SELECT age, weight_kg, height_cm, activity_level, pressure_level, sugar_level 
        FROM users WHERE user_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();

$weight_kg = $user_data['weight_kg'] ?? '';
$height_cm = $user_data['height_cm'] ?? '';
$activity_level = $user_data['activity_level'] ?? '';
$pressure_level = $user_data['pressure_level'] ?? '';
$sugar_level = $user_data['sugar_level'] ?? '';
$age = $user_data['age'] ?? 25; // fallback

// ----------------------
// Handle form submission
// ----------------------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $weight_kg = floatval($_POST['weight_kg']);
    $height_cm = floatval($_POST['height_cm']);
    $activity_level = $_POST['activity_level'];
    $pressure_level = $_POST['pressure_level'];
    $sugar_level = $_POST['sugar_level'];

    // Calculate BMI
    $height_m = $height_cm / 100;
    $bmi = $weight_kg / ($height_m * $height_m);

    // Calculate BMR (Mifflin-St Jeor, assuming male by default)
    $bmr = 10 * $weight_kg + 6.25 * $height_cm - 5 * $age + 5;

    // Calories per kg
    $calories_per_kg = $bmr / $weight_kg;

    // 1. Insert into progress table
    $stmt = $conn->prepare("INSERT INTO user_progress 
        (user_id, age, weight_kg, height_cm, activity_level, pressure_level, sugar_level, bmi, bmr, calories_per_kg) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiddsssddd", $user_id, $age, $weight_kg, $height_cm,
                      $activity_level, $pressure_level, $sugar_level, $bmi, $bmr, $calories_per_kg);
    $stmt->execute();

    // 2. Update users table with latest info
    $stmt = $conn->prepare("UPDATE users 
                            SET weight_kg= ?, height_cm= ?, activity_level = ?, pressure_level = ?, sugar_level = ? 
                            WHERE user_id = ?");
    $stmt->bind_param("ddsssi", $weight_kg, $height_cm, $activity_level, $pressure_level, $sugar_level, $user_id);
    $stmt->execute();

    // Refresh page to load new values
    header("Location: user_progress.php");
    exit;
}

// ----------------------
// Fetch progress history
// ----------------------
$sql = "SELECT date_recorded, weight_kg, bmi, bmr, calories_per_kg 
        FROM user_progress WHERE user_id = ? ORDER BY date_recorded ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$dates = [];
$weights = [];
$bmis = [];
$bmrs = [];
$calories = [];

while ($row = $result->fetch_assoc()) {
    $dates[] = date('M', strtotime($row['date_recorded'])); // Format as short month name
    $weights[] = $row['weight_kg'];
    $bmis[] = $row['bmi'];
    $bmrs[] = $row['bmr'];
    $calories[] = $row['calories_per_kg'];
}

// For demo purposes, if no data exists, let's create some sample data
if (empty($weights)) {
    $dates = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
    $weights = [83, 80, 78, 76, 75, 74];
    $bmis = [25.8, 24.6, 23.95, 23.3, 23.1, 22.9];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Analytics Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
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
            padding: 0;
            margin: 0;
        }
        
        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eaeaea;
        }
        
        .header h1 {
            color: var(--primary);
            font-weight: 700;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
        }
        
        .card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .stats {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
        }
        
        .stat-label {
            font-size: 14px;
            color: var(--gray);
        }
        
        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }
        
        .progress-form {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
        }
        
        .form-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--dark);
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e1e5eb;
            border-radius: 8px;
            font-size: 16px;
            transition: var(--transition);
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }
        
        .btn {
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        
        .metric-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--card-shadow);
        }
        
        .metric-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--dark);
        }
        
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .metrics-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="header">
            <h1>Progress Analytics</h1>
            <div class="user-info">
                <div class="user-avatar">U</div>
                <span>User Profile</span>
            </div>
        </div>
        
        <div class="progress-form">
            <h2 class="form-title">Update Your Progress</h2>
            <form method="post">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="weight_kg">Weight (kg)</label>
                        <input type="number" step="0.1" class="form-control" id="weight_kg" name="weight_kg" value="<?php echo $weight_kg; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="height_cm">Height (cm)</label>
                        <input type="number" step="0.1" class="form-control" id="height_cm" name="height_cm" value="<?php echo $height_cm; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="activity_level">Activity Level</label>
                        <select class="form-control" id="activity_level" name="activity_level" required>
                            <option value="Sedentary" <?php if($activity_level=="Sedentary") echo "selected"; ?>>Sedentary</option>
                            <option value="Lightly Active" <?php if($activity_level=="Lightly Active") echo "selected"; ?>>Lightly Active</option>
                            <option value="Moderately Active" <?php if($activity_level=="Moderately Active") echo "selected"; ?>>Moderately Active</option>
                            <option value="Very Active" <?php if($activity_level=="Very Active") echo "selected"; ?>>Very Active</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="pressure_level">Blood Pressure Level</label>
                        <input type="text" class="form-control" id="pressure_level" name="pressure_level" value="<?php echo $pressure_level; ?>" placeholder="e.g. Normal / High">
                    </div>
                    
                    <div class="form-group">
                        <label for="sugar_level">Sugar Level</label>
                        <input type="text" class="form-control" id="sugar_level" name="sugar_level" value="<?php echo $sugar_level; ?>" placeholder="e.g. Normal / High">
                    </div>
                </div>
                
                <button type="submit" class="btn">Save Progress</button>
            </form>
        </div>
        
        <div class="dashboard-grid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Weight Progress</h3>
                    <div class="card-icon">
                        <i class="fas fa-weight"></i>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="weightChart"></canvas>
                </div>
                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-value"><?php echo end($weights) ?? 'N/A'; ?> kg</div>
                        <div class="stat-label">Current</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value"><?php echo isset($weights[0]) ? $weights[0] - end($weights) : 'N/A'; ?> kg</div>
                        <div class="stat-label">Total Loss</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">-1.2 kg</div>
                        <div class="stat-label">This Month</div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">BMI Progress</h3>
                    <div class="card-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="bmiChart"></canvas>
                </div>
                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-value"><?php echo end($bmis) ?? 'N/A'; ?></div>
                        <div class="stat-label">Current</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value"><?php echo isset($bmis[0]) ? round($bmis[0] - end($bmis), 2) : 'N/A'; ?></div>
                        <div class="stat-label">Total Improvement</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">-1.0</div>
                        <div class="stat-label">This Month</div>
                    </div>
                </div>
            </div>
        </div>
        
        <h2 style="margin: 30px 0 20px;">Body Measurements</h2>
        
        <div class="metrics-grid">
            <div class="metric-card">
                <h3 class="metric-title">Activity Level</h3>
                <div class="stat-value"><?php echo $activity_level ?: 'Not set'; ?></div>
            </div>
            
            <div class="metric-card">
                <h3 class="metric-title">Blood Pressure</h3>
                <div class="stat-value"><?php echo $pressure_level ?: 'Not set'; ?></div>
            </div>
            
            <div class="metric-card">
                <h3 class="metric-title">Sugar Level</h3>
                <div class="stat-value"><?php echo $sugar_level ?: 'Not set'; ?></div>
            </div>
        </div>
    </div>

    <script>
        const dates = <?php echo json_encode($dates); ?>;
        const weights = <?php echo json_encode($weights); ?>;
        const bmis = <?php echo json_encode($bmis); ?>;
        
        // Weight Chart
        new Chart(document.getElementById('weightChart'), {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Weight (kg)',
                    data: weights,
                    borderColor: '#4361ee',
                    backgroundColor: 'rgba(67, 97, 238, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#4361ee',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // BMI Chart
        new Chart(document.getElementById('bmiChart'), {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'BMI',
                    data: bmis,
                    borderColor: '#4cc9f0',
                    backgroundColor: 'rgba(76, 201, 240, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#4cc9f0',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>