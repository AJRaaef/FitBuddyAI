<?php
session_start();
require 'db.php';
include 'exercises_data.php';

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

// Check if we need to alter the table to add image_path column
$check_column = $conn->query("SHOW COLUMNS FROM user_suggested_workouts LIKE 'image_path'");
if ($check_column->num_rows == 0) {
    $conn->query("ALTER TABLE user_suggested_workouts ADD COLUMN image_path VARCHAR(255) AFTER suggestion");
}

// Filter exercises based on user profile with fallback mechanism
$user_age = $user['age'];
$user_bmi = $user['bmi'];
$user_gender = $user['gender'];
$user_disease = $user['disease'] ?? 'No Disease';
$user_activity = $user['activity_level'];
$user_goal = $user['fitness_goal'];

// Function to check if exercise matches user criteria
function exerciseMatchesUser($exercise, $user) {
    // Age check
    if ($user['age'] < $exercise['min_age'] || $user['age'] > $exercise['max_age']) {
        return false;
    }
    
    // BMI check
    if ($user['bmi'] > $exercise['max_bmi']) {
        return false;
    }
    
    // Gender check
    if (!in_array($user['gender'], $exercise['gender'])) {
        return false;
    }
    
    // Disease check
    if ($exercise['disease'] !== 'No Disease') {
        $exercise_diseases = array_map('trim', explode(',', $exercise['disease']));
        $user_diseases = array_map('trim', explode(',', $user['disease']));
        if (count(array_intersect($exercise_diseases, $user_diseases)) == 0) {
            return false;
        }
    } else if ($user['disease'] !== 'No Disease') {
        return false;
    }
    
    // Activity level check
    if ($exercise['activity_level'] !== $user['activity_level']) {
        return false;
    }
    
    // Goal check
    if (!in_array($user['fitness_goal'], $exercise['goal'])) {
        return false;
    }
    
    return true;
}

// Function to calculate exercise match score (for fallback)
function exerciseMatchScore($exercise, $user) {
    $score = 0;
    
    // Age (higher score for closer match)
    $age_range = $exercise['max_age'] - $exercise['min_age'];
    $age_deviation = min(
        abs($user['age'] - $exercise['min_age']),
        abs($user['age'] - $exercise['max_age'])
    );
    $score += max(0, 10 - ($age_deviation / $age_range * 10));
    
    // BMI (higher score for closer match to max_bmi)
    $bmi_deviation = max(0, $user['bmi'] - $exercise['max_bmi']);
    $score += max(0, 10 - ($bmi_deviation * 2));
    
    // Gender
    if (in_array($user['gender'], $exercise['gender'])) {
        $score += 10;
    }
    
    // Disease
    if ($exercise['disease'] !== 'No Disease') {
        $exercise_diseases = array_map('trim', explode(',', $exercise['disease']));
        $user_diseases = array_map('trim', explode(',', $user['disease']));
        $matching_diseases = count(array_intersect($exercise_diseases, $user_diseases));
        $score += $matching_diseases * 5;
    } else if ($user['disease'] === 'No Disease') {
        $score += 10;
    }
    
    // Activity level
    $activity_levels = ['Sedentary', 'Lightly Active', 'Moderately Active', 'Active', 'Very Active'];
    $user_activity_index = array_search($user['activity_level'], $activity_levels);
    $exercise_activity_index = array_search($exercise['activity_level'], $activity_levels);
    $activity_diff = abs($user_activity_index - $exercise_activity_index);
    $score += max(0, 10 - ($activity_diff * 3));
    
    // Goal
    if (in_array($user['fitness_goal'], $exercise['goal'])) {
        $score += 10;
    }
    
    return $score;
}

// Try to find perfect matches first
$suggested_exercises = [];
foreach ($all_exercises as $exercise) {
    if (exerciseMatchesUser($exercise, $user)) {
        $suggested_exercises[] = $exercise;
        if (count($suggested_exercises) >= 5) {
            break;
        }
    }
}

// If not enough perfect matches, use scoring system
if (count($suggested_exercises) < 5) {
    $scored_exercises = [];
    
    foreach ($all_exercises as $exercise) {
        // Skip exercises that are already in the suggestions
        $already_suggested = false;
        foreach ($suggested_exercises as $suggested) {
            if ($suggested['name'] === $exercise['name']) {
                $already_suggested = true;
                break;
            }
        }
        
        if (!$already_suggested) {
            $score = exerciseMatchScore($exercise, $user);
            $scored_exercises[] = [
                'exercise' => $exercise,
                'score' => $score
            ];
        }
    }
    
    // Sort by score descending
    usort($scored_exercises, function($a, $b) {
        return $b['score'] - $a['score'];
    });
    
    // Add top-scoring exercises to suggestions
    $needed = 5 - count($suggested_exercises);
    for ($i = 0, $count = count($scored_exercises); $i < min($needed, $count); $i++) {
        $suggested_exercises[] = $scored_exercises[$i]['exercise'];
    }
}

// Clear previous suggestions and insert new ones with image paths
$conn->query("DELETE FROM user_suggested_workouts WHERE user_id = $user_id");

foreach ($suggested_exercises as $ex) {
    $stmt = $conn->prepare("INSERT INTO user_suggested_workouts 
    (user_id, exercise_name, exercise_type, duration_min, frequency_day, intensity, suggestion, image_path, created_at) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param(
    "issiiiss",
    $user_id,
    $ex['name'],
    $ex['type'],
    $ex['duration'],
    $ex['frequency'],
    $ex['intensity'],
    $ex['suggestion'],
    $ex['image']
);
    $stmt->execute();
}

// Fetch the inserted workouts
$workouts_result = $conn->query("SELECT * FROM user_suggested_workouts WHERE user_id = $user_id ORDER BY created_at DESC");
$workouts = [];
while ($row = $workouts_result->fetch_assoc()) {
    $workouts[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitBuddy - Exercise Recommendations</title>
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
            text-align: center;
            margin-bottom: 30px;
        }
        
        h1 {
            font-size: 36px;
            color: var(--dark);
            margin-bottom: 10px;
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
            grid-template-columns: 1fr 2fr;
            gap: 30px;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 25px;
        }
        
        .user-profile {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
        }
        
        .profile-info h2 {
            margin-bottom: 5px;
        }
        
        .profile-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .stat {
            background: var(--light);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }
        
        .stat-value {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
        }
        
        .stat-label {
            font-size: 14px;
            color: var(--gray);
        }
        
        .exercises-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .exercise-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }
        
        .exercise-card:hover {
            transform: translateY(-5px);
        }
        
        .exercise-image {
            height: 200px;
            background-color: #ddd;
            background-size: cover;
            background-position: center;
        }
        
        .exercise-content {
            padding: 20px;
        }
        
        .exercise-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .exercise-type {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .type-cardio {
            background: #ffebee;
            color: var(--danger);
        }
        
        .type-strength {
            background: #e3f2fd;
            color: var(--primary);
        }
        
        .type-flexibility {
            background: #f1f8e9;
            color: var(--accent);
        }
        
        .type-balance {
            background: #fff3e0;
            color: var(--warning);
        }
        
        .exercise-title {
            font-size: 20px;
            margin-bottom: 10px;
            color: var(--dark);
        }
        
        .exercise-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            color: var(--gray);
        }
        
        .exercise-suggestion {
            margin-bottom: 15px;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .exercise-details {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--light);
        }
        
        .detail-item {
            text-align: center;
        }
        
        .detail-value {
            font-weight: 600;
            color: var(--dark);
        }
        
        .detail-label {
            font-size: 12px;
            color: var(--gray);
        }
        
        .no-results {
            text-align: center;
            padding: 40px;
            color: var(--gray);
        }
        
        .last-updated {
            text-align: center;
            color: var(--gray);
            font-size: 14px;
            margin: 20px 0;
        }
        
        @media (max-width: 992px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 576px) {
            .profile-stats {
                grid-template-columns: 1fr;
            }
            
            .exercises-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>FitBuddy Exercise Recommendations</h1>
            <p>Personalized workouts based on your profile</p>
        </header>
        
        <div class="dashboard">
            <div class="user-profile">
                <div class="card">
                    <div class="profile-header">
                        <img src="<?php echo $user['profile_picture'] ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80'; ?>" 
                             alt="<?php echo $user['first_name'] . ' ' . $user['last_name']; ?>" class="profile-img">
                        <div class="profile-info">
                            <h2><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h2>
                            <p><?php echo $user['age']; ?> years old</p>
                        </div>
                    </div>
                    
                    <div class="profile-stats">
                        <div class="stat">
                            <div class="stat-value"><?php echo $user['weight_kg'] ?? 'N/A'; ?> kg</div>
                            <div class="stat-label">Weight</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value"><?php echo $user['height_cm'] ?? 'N/A'; ?> cm</div>
                            <div class="stat-label">Height</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value"><?php echo $user['activity_level'] ?? 'N/A'; ?></div>
                            <div class="stat-label">Activity</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value"><?php echo $user['dietary_pref'] ?? 'N/A'; ?></div>
                            <div class="stat-label">Diet</div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <h3>Health Information</h3>
                    <div class="profile-stats">
                        <div class="stat">
                            <div class="stat-value"><?php echo round($user['bmi'], 1) ?? 'N/A'; ?></div>
                            <div class="stat-label">BMI</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value"><?php echo $user['gender'] ?? 'N/A'; ?></div>
                            <div class="stat-label">Gender</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value"><?php echo $user['disease'] ?? 'None'; ?></div>
                            <div class="stat-label">Condition</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value"><?php echo $user['fitness_goal'] ?? 'N/A'; ?></div>
                            <div class="stat-label">Goal</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="exercise-recommendations">
                <div class="card">
                    <h2>Recommended Exercises</h2>
                    <p>Based on your profile, we've selected these exercises for you:</p>
                    
                    <div class="exercises-grid">
                        <?php if (count($workouts) > 0): ?>
                            <?php 
                            $displayed_exercises = [];
                            foreach ($workouts as $workout): 
                                // Skip duplicates
                                if (in_array($workout['exercise_name'], $displayed_exercises)) continue;
                                $displayed_exercises[] = $workout['exercise_name'];
                            ?>
                                <div class="exercise-card">
                                    <div class="exercise-image" style="background-image: url('<?php echo $workout['image_path']; ?>')"></div>
                                    <div class="exercise-content">
                                        <div class="exercise-header">
                                            <span class="exercise-type type-<?php echo strtolower($workout['exercise_type']); ?>">
                                                <?php echo $workout['exercise_type']; ?>
                                            </span>
                                            <span class="exercise-intensity"><?php echo $workout['intensity']; ?> Intensity</span>
                                        </div>
                                        <h3 class="exercise-title"><?php echo $workout['exercise_name']; ?></h3>
                                        <div class="exercise-meta">
                                            <span class="meta-item"><i class="far fa-clock"></i> <?php echo $workout['duration_min']; ?> mins</span>
                                            <span class="meta-item"><i class="far fa-calendar"></i> <?php echo $workout['frequency_day']; ?>/week</span>
                                        </div>
                                        <p class="exercise-suggestion"><?php echo $workout['suggestion']; ?></p>
                                        <div class="exercise-details">
                                            <div class="detail-item">
                                                <div class="detail-value"><?php echo $workout['intensity']; ?></div>
                                                <div class="detail-label">Intensity</div>
                                            </div>
                                            <div class="detail-item">
                                                <div class="detail-value"><?php echo $workout['exercise_type']; ?></div>
                                                <div class="detail-label">Type</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-results">
                                <i class="fas fa-info-circle"></i>
                                <p>No exercises match your current profile. Please update your profile or try different filters.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="last-updated">
                        Last updated: <?php echo date('F j, Y, g:i a'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>