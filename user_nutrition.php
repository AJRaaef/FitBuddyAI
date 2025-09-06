<?php
session_start();
require 'db.php';
include 'nutrition_data.php';

// Check if user is logged in
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit();
}

// Fetch user details
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}

// Check if we need to create the nutrition table
$table_exists = $conn->query("SHOW TABLES LIKE 'user_suggested_nutrition'");
if ($table_exists->num_rows == 0) {
    $create_table = "CREATE TABLE user_suggested_nutrition (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        food_name VARCHAR(255) NOT NULL,
        meal_type VARCHAR(50) NOT NULL,
        calories INT NOT NULL,
        protein DECIMAL(5,1) NOT NULL,
        carbs DECIMAL(5,1) NOT NULL,
        fats DECIMAL(5,1) NOT NULL,
        suggestion TEXT,
        image_path VARCHAR(255),
        meal_time TIME,
        is_eaten BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(user_id)
    )";
    $conn->query($create_table);
}

// Filter nutrition items based on user profile with fallback mechanism
$user_age = $user['age'];
$user_bmi = $user['bmi'];
$user_gender = $user['gender'];
$user_disease = $user['disease'] ?? 'No Disease';
$user_activity = $user['activity_level'];
$user_goal = $user['fitness_goal'];

// Function to check if food matches user criteria
function foodMatchesUser($food, $user) {
    // Age check
    if ($user['age'] < $food['min_age'] || $user['age'] > $food['max_age']) {
        return false;
    }
    
    // BMI check
    if ($user['bmi'] > $food['max_bmi']) {
        return false;
    }
    
    // Gender check
    if (!in_array($user['gender'], $food['gender'])) {
        return false;
    }
    
    // Disease check
    if ($food['disease'] !== 'No Disease') {
        $food_diseases = array_map('trim', explode(',', $food['disease']));
        $user_diseases = array_map('trim', explode(',', $user['disease']));
        if (count(array_intersect($food_diseases, $user_diseases)) == 0) {
            return false;
        }
    } else if ($user['disease'] !== 'No Disease') {
        return false;
    }
    
    // Activity level check
    if ($food['activity_level'] !== $user['activity_level']) {
        return false;
    }
    
    // Goal check
    if (!in_array($user['fitness_goal'], $food['goal'])) {
        return false;
    }
    
    return true;
}

// Function to calculate food match score (for fallback)
function foodMatchScore($food, $user) {
    $score = 0;
    
    // Age (higher score for closer match)
    $age_range = $food['max_age'] - $food['min_age'];
    $age_deviation = min(
        abs($user['age'] - $food['min_age']),
        abs($user['age'] - $food['max_age'])
    );
    $score += max(0, 10 - ($age_deviation / $age_range * 10));
    
    // BMI (higher score for closer match to max_bmi)
    $bmi_deviation = max(0, $user['bmi'] - $food['max_bmi']);
    $score += max(0, 10 - ($bmi_deviation * 2));
    
    // Gender
    if (in_array($user['gender'], $food['gender'])) {
        $score += 10;
    }
    
    // Disease
    if ($food['disease'] !== 'No Disease') {
        $food_diseases = array_map('trim', explode(',', $food['disease']));
        $user_diseases = array_map('trim', explode(',', $user['disease']));
        $matching_diseases = count(array_intersect($food_diseases, $user_diseases));
        $score += $matching_diseases * 5;
    } else if ($user['disease'] === 'No Disease') {
        $score += 10;
    }
    
    // Activity level
    $activity_levels = ['Sedentary', 'Lightly Active', 'Moderately Active', 'Active', 'Very Active'];
    $user_activity_index = array_search($user['activity_level'], $activity_levels);
    $food_activity_index = array_search($food['activity_level'], $activity_levels);
    $activity_diff = abs($user_activity_index - $food_activity_index);
    $score += max(0, 10 - ($activity_diff * 3));
    
    // Goal
    if (in_array($user['fitness_goal'], $food['goal'])) {
        $score += 10;
    }
    
    return $score;
}

// Try to find perfect matches first
$suggested_foods = [];
foreach ($nutrition_data as $food) {
    if (foodMatchesUser($food, $user)) {
        $suggested_foods[] = $food;
        if (count($suggested_foods) >= 5) {
            break;
        }
    }
}

// If not enough perfect matches, use scoring system
if (count($suggested_foods) < 5) {
    $scored_foods = [];
    
    foreach ($nutrition_data as $food) {
        // Skip foods that are already in the suggestions
        $already_suggested = false;
        foreach ($suggested_foods as $suggested) {
            if ($suggested['name'] === $food['name']) {
                $already_suggested = true;
                break;
            }
        }
        
        if (!$already_suggested) {
            $score = foodMatchScore($food, $user);
            $scored_foods[] = [
                'food' => $food,
                'score' => $score
            ];
        }
    }
    
    // Sort by score descending
    usort($scored_foods, function($a, $b) {
        return $b['score'] - $a['score'];
    });
    
    // Add top-scoring foods to suggestions
    $needed = 5 - count($suggested_foods);
    for ($i = 0, $count = count($scored_foods); $i < min($needed, $count); $i++) {
        $suggested_foods[] = $scored_foods[$i]['food'];
    }
}

// Clear previous suggestions and insert new ones with image paths
$conn->query("DELETE FROM user_suggested_nutrition WHERE user_id = $user_id");

// Define meal times for different meal types
$meal_times = [
    'Breakfast' => '08:00:00',
    'Lunch' => '12:30:00',
    'Dinner' => '19:00:00',
    'Snack' => '15:00:00'
];

foreach ($suggested_foods as $food) {
    $meal_time = $meal_times[$food['type']] ?? '12:00:00';
    
    $stmt = $conn->prepare("INSERT INTO user_suggested_nutrition 
        (user_id, food_name, meal_type, calories, protein, carbs, fats, suggestion, image_path, meal_time) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "issidddsss",
        $user_id,
        $food['name'],
        $food['type'],
        $food['calories'],
        $food['protein'],
        $food['carbs'],
        $food['fats'],
        $food['suggestion'],
        $food['image'],
        $meal_time
    );
    $stmt->execute();
}

// Fetch the inserted nutrition items
$nutrition_result = $conn->query("SELECT * FROM user_suggested_nutrition WHERE user_id = $user_id ORDER BY meal_time ASC");
$nutrition_items = [];
while ($row = $nutrition_result->fetch_assoc()) {
    $nutrition_items[] = $row;
}

// Calculate nutrition summary
$total_calories = 0;
$total_protein = 0;
$total_carbs = 0;
$total_fats = 0;

foreach ($nutrition_items as $item) {
    $total_calories += $item['calories'];
    $total_protein += $item['protein'];
    $total_carbs += $item['carbs'];
    $total_fats += $item['fats'];
}

// Calculate goals based on user profile
$calorie_goal = 2000; // Default
$protein_goal = 140;  // Default
$carbs_goal = 220;    // Default
$fats_goal = 70;      // Default

// Adjust goals based on user data
if ($user['fitness_goal'] == 'weight loss') {
    $calorie_goal = 1800;
    $protein_goal = 120;
} elseif ($user['fitness_goal'] == 'muscle gain') {
    $calorie_goal = 2500;
    $protein_goal = 160;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitBuddy - Nutrition Plan</title>
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
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        header {
            margin-bottom: 30px;
        }
        
        .welcome {
            font-size: 28px;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .date {
            color: var(--gray);
            font-size: 16px;
            margin-bottom: 20px;
        }
        
        h2 {
            font-size: 24px;
            color: var(--dark);
            margin-bottom: 20px;
        }
        
        h3 {
            font-size: 20px;
            color: var(--dark);
            margin-bottom: 15px;
        }
        
        .dashboard {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 25px;
        }
        
        .meal-plan {
            margin-bottom: 30px;
        }
        
        .meal-item {
            display: flex;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #eee;
        }
        
        .meal-time {
            min-width: 100px;
            font-weight: 600;
            color: var(--dark);
        }
        
        .meal-details {
            flex-grow: 1;
        }
        
        .meal-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
        }
        
        .meal-macros {
            display: flex;
            gap: 15px;
            margin-bottom: 10px;
        }
        
        .macro {
            font-size: 14px;
        }
        
        .macro-value {
            font-weight: 600;
            color: var(--dark);
        }
        
        .nutrition-summary {
            margin-bottom: 20px;
        }
        
        .summary-item {
            margin-bottom: 15px;
        }
        
        .summary-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--dark);
        }
        
        .progress-bar {
            height: 10px;
            background: #eee;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 5px;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 5px;
        }
        
        .calories-progress {
            background: linear-gradient(90deg, #3498db, #2ecc71);
        }
        
        .protein-progress {
            background: #3498db;
        }
        
        .carbs-progress {
            background: #f39c12;
        }
        
        .fats-progress {
            background: #e74c3c;
        }
        
        .water-progress {
            background: #3498db;
        }
        
        .summary-details {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: var(--gray);
        }
        
        .recommended-foods {
            margin-top: 30px;
        }
        
        .food-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .food-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .food-card:hover {
            transform: translateY(-5px);
        }
        
        .food-image {
            height: 120px;
            background-color: #ddd;
            background-size: cover;
            background-position: center;
        }
        
        .food-content {
            padding: 15px;
        }
        
        .food-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--dark);
        }
        
        .food-category {
            font-size: 12px;
            color: var(--gray);
            margin-bottom: 8px;
        }
        
        .food-description {
            font-size: 12px;
            margin-bottom: 10px;
            color: #666;
        }
        
        .food-calories {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
        }
        
        .search-bar {
            margin-bottom: 20px;
            position: relative;
        }
        
        .search-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        
        .search-icon {
            position: absolute;
            right: 15px;
            top: 12px;
            color: var(--gray);
        }
        
        .meal-tag {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .breakfast-tag {
            background-color: #ffeaa7;
            color: #d35400;
        }
        
        .lunch-tag {
            background-color: #81ecec;
            color: #00b894;
        }
        
        .dinner-tag {
            background-color: #fab1a0;
            color: #e17055;
        }
        
        .snack-tag {
            background-color: #fd79a8;
            color: #fd79a8;
        }
        
        .macro-summary {
            margin-bottom: 15px;
        }
        
        @media (max-width: 992px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 576px) {
            .meal-macros {
                flex-wrap: wrap;
            }
            
            .food-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1 class="welcome">Welcome back, <?php echo $user['first_name']; ?>!</h1>
            <p class="date"><?php echo date('l, F j, Y'); ?></p>
        </header>
        
        <div class="dashboard">
            <div class="main-content">
                <div class="card">
                    <h2>Nutrition Plan</h2>
                    <p>Your personalized meal plan and nutrition tracking</p>
                    
                    <div class="meal-plan">
                        <h3>Today's Meal Plan</h3>
                        
                        <?php if (count($nutrition_items) > 0): ?>
                            <?php foreach ($nutrition_items as $food): 
                                $tag_class = strtolower($food['meal_type']) . '-tag';
                            ?>
                                <div class="meal-item">
                                    <div class="meal-time">
                                        <?php echo date('g:i A', strtotime($food['meal_time'])); ?>
                                    </div>
                                    <div class="meal-details">
                                        <span class="meal-tag <?php echo $tag_class; ?>"><?php echo $food['meal_type']; ?></span>
                                        <div class="meal-title"><?php echo $food['food_name']; ?></div>
                                        <div class="meal-macros">
                                            <div class="macro">
                                                Calories: <span class="macro-value"><?php echo $food['calories']; ?></span>
                                            </div>
                                            <div class="macro">
                                                Protein: <span class="macro-value"><?php echo $food['protein']; ?>g</span>
                                            </div>
                                            <div class="macro">
                                                Carbs: <span class="macro-value"><?php echo $food['carbs']; ?>g</span>
                                            </div>
                                            <div class="macro">
                                                Fat: <span class="macro-value"><?php echo $food['fats']; ?>g</span>
                                            </div>
                                        </div>
                                        <p class="food-description"><?php echo $food['suggestion']; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No meal plan available. Please update your profile.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card recommended-foods">
                    <h3>Recommended Foods</h3>
                    <div class="search-bar">
                        <input type="text" class="search-input" placeholder="Search foods...">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                    
                    <div class="food-grid">
                        <?php 
                        $displayed_foods = [];
                        foreach ($nutrition_items as $food): 
                            if (in_array($food['food_name'], $displayed_foods)) continue;
                            $displayed_foods[] = $food['food_name'];
                            $tag_class = strtolower($food['meal_type']) . '-tag';
                        ?>
                            <div class="food-card">
                                <div class="food-image" style="background-image: url('<?php echo $food['image_path']; ?>')"></div>
                                <div class="food-content">
                                    <span class="meal-tag <?php echo $tag_class; ?>"><?php echo $food['meal_type']; ?></span>
                                    <div class="food-title"><?php echo $food['food_name']; ?></div>
                                    <div class="food-description"><?php echo $food['suggestion']; ?></div>
                                    <div class="food-calories"><?php echo $food['calories']; ?> calories per serving</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <div class="sidebar">
                <div class="card nutrition-summary">
                    <h3>Nutrition Summary</h3>
                    
                    <div class="summary-item">
                        <div class="summary-title">Daily Calories</div>
                        <div class="progress-bar">
                            <div class="progress-fill calories-progress" style="width: <?php echo min(100, ($total_calories / $calorie_goal) * 100); ?>%"></div>
                        </div>
                        <div class="summary-details">
                            <span><?php echo $total_calories; ?> / <?php echo $calorie_goal; ?> cal</span>
                            <span><?php echo round(($total_calories / $calorie_goal) * 100); ?>%</span>
                        </div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-title">Macronutrients</div>
                        
                        <div class="macro-summary">
                            <div class="summary-title">Protein</div>
                            <div class="progress-bar">
                                <div class="progress-fill protein-progress" style="width: <?php echo min(100, ($total_protein / $protein_goal) * 100); ?>%"></div>
                            </div>
                            <div class="summary-details">
                                <span><?php echo $total_protein; ?>g / <?php echo $protein_goal; ?>g</span>
                                <span><?php echo round(($total_protein / $protein_goal) * 100); ?>%</span>
                            </div>
                        </div>
                        
                        <div class="macro-summary">
                            <div class="summary-title">Carbs</div>
                            <div class="progress-bar">
                                <div class="progress-fill carbs-progress" style="width: <?php echo min(100, ($total_carbs / $carbs_goal) * 100); ?>%"></div>
                            </div>
                            <div class="summary-details">
                                <span><?php echo $total_carbs; ?>g / <?php echo $carbs_goal; ?>g</span>
                                <span><?php echo round(($total_carbs / $carbs_goal) * 100); ?>%</span>
                            </div>
                        </div>
                        
                        <div class="macro-summary">
                            <div class="summary-title">Fat</div>
                            <div class="progress-bar">
                                <div class="progress-fill fats-progress" style="width: <?php echo min(100, ($total_fats / $fats_goal) * 100); ?>%"></div>
                            </div>
                            <div class="summary-details">
                                <span><?php echo $total_fats; ?>g / <?php echo $fats_goal; ?>g</span>
                                <span><?php echo round(($total_fats / $fats_goal) * 100); ?>%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-title">Water Intake</div>
                        <div class="progress-bar">
                            <div class="progress-fill water-progress" style="width: 60%"></div>
                        </div>
                        <div class="summary-details">
                            <span>1.8 / 3 L</span>
                            <span>60%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>