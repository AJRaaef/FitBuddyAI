<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_signin.php?message=" . urlencode("Please sign in or sign up to continue."));
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Extract necessary variables
$age = intval($user['age']);
$gender = $user['gender'];
$weight = floatval($user['weight_kg']);
$height = floatval($user['height_cm']);
$bmi = floatval($user['bmi']);
$activity = $user['activity_level'];
$disease = strtolower($user['disease']); // convert to lowercase for easier checking
$allergy = strtolower($user['allergy']);
$pressure = strtolower($user['pressure_label']);
$sugar = strtolower($user['sugar_label']);
$goal = strtolower($user['fitness_goal']);

// Force logout if user not found
if (!$user) {
    session_destroy();
    header("Location: user_signin.php?message=" . urlencode("User not found. Please sign in again."));
    exit();
}

// Health Alerts
$health_alerts = [];

$bmi = $user['bmi'] ?? 0;
if ($bmi < 18.5) {
    $health_alerts[] = "Your BMI is below normal; focus on proper nutrition and healthy weight gain.";
} elseif ($bmi >= 25 && $bmi < 30) {
    $health_alerts[] = "Your BMI is above normal; monitor weight and maintain a healthy diet.";
} elseif ($bmi >= 30) {
    $health_alerts[] = "Obese BMI detected; consider consulting a healthcare professional for weight management.";
} else {
    $health_alerts[] = "Your BMI is within the normal range; maintain a balanced diet and activity.";
}

$sugar = strtolower($user['sugar_label'] ?? '');
if ($sugar === 'high') {
    $health_alerts[] = "High sugar level detected; monitor diet and consult a healthcare professional if needed.";
}

$pressure = strtolower($user['pressure_label'] ?? '');
if ($pressure === 'high') {
    $health_alerts[] = "High blood pressure detected; avoid excessive salt and stress, consult a doctor if needed.";
}

$allergy = strtolower($user['allergy'] ?? 'none');
if ($allergy !== 'none') {
    $health_alerts[] = "Take care of your allergies: " . $user['allergy'];
}

$health_attention = !empty($health_alerts) ? implode(" ", $health_alerts) : "No major health alerts. Keep up your healthy habits!";

// Fitness Suggestions based on goal
$goal = strtolower($user['fitness_goal'] ?? '');
$suggestions = [];
$age = $user['age'] ?? 25;
$bmi_category = '';
if ($bmi < 18.5) $bmi_category = 'underweight';
elseif ($bmi < 25) $bmi_category = 'normal';
elseif ($bmi < 30) $bmi_category = 'overweight';
else $bmi_category = 'obese';

switch($goal) {
    case 'muscle building':
        $suggestions[] = "Include strength training 4-5 times per week.";
        $suggestions[] = "Consume 1.6-2g of protein per kg of body weight daily.";
        $suggestions[] = ($age < 20) ? "Focus on compound exercises safely due to growing age." : "Ensure adequate rest and recovery between workouts.";
        $suggestions[] = "Track your progress and adjust weights gradually.";
        break;
    case 'weight loss':
        $suggestions[] = "Follow a calorie deficit diet with balanced nutrition.";
        $suggestions[] = "Incorporate 3-4 cardio sessions per week.";
        $suggestions[] = (strpos($user['disease'], 'diabetes') !== false || strpos($user['disease'], 'hypertension') !== false || strpos($user['disease'], 'high cholesterol') !== false)
            ? "Monitor blood sugar and blood pressure while exercising."
            : "Track your progress and stay consistent with workouts.";
        $suggestions[] = "Include high-fiber foods and stay hydrated.";
        break;
    case 'weight gain':
        $suggestions[] = "Increase daily calorie intake with nutrient-dense foods.";
        $suggestions[] = "Include compound strength training exercises 3-4 times per week.";
        $suggestions[] = (!empty($allergy) && $allergy != 'none') 
            ? "Avoid foods you are allergic to while increasing calories."
            : "Eat protein-rich meals every 3-4 hours.";
        $suggestions[] = ($bmi_category === 'underweight' && strtolower($user['activity_level']) != 'sedentary') 
            ? "Focus on progressive overload in workouts to build lean muscle."
            : "Include healthy snacks and smoothies to increase calorie intake safely.";
        break;
    case 'maintain fitness':
        $suggestions[] = "Maintain a balanced diet with moderate calories.";
        $suggestions[] = "Mix cardio and strength training regularly.";
        $suggestions[] = ($bmi >= 25 || strpos($user['disease'], 'fatty liver') !== false) 
            ? "Monitor your weight and body composition regularly."
            : "Stay active daily and monitor your health metrics.";
        $suggestions[] = "Keep track of your hydration and sleep quality.";
        break;
    default:
        $suggestions[] = "No specific suggestions available.";
}

// -----------------------------
// Helper Functions for Nutrition
// -----------------------------
function bmiCategory($bmi) {
    if ($bmi < 18.5) return 'Underweight';
    elseif ($bmi < 25) return 'Normal weight';
    elseif ($bmi < 30) return 'Overweight';
    elseif ($bmi < 35) return 'Obese Class I';
    elseif ($bmi < 40) return 'Obese Class II';
    else return 'Obese Class III';
}

function avoidAllergies($foodList, $allergy) {
    if ($allergy == 'none' || empty($allergy)) return $foodList;
    $avoid = explode(',', $allergy);
    foreach ($avoid as $item) {
        $item = trim(strtolower($item));
        foreach ($foodList as $key => $food) {
            if (stripos(strtolower($food), $item) !== false) {
                unset($foodList[$key]);
            }
        }
    }
    return array_values($foodList);
}

function suggestNutritionCategories($goal, $diseases, $bmi_cat) {
    $suggestions = [];

    // Workout goal
    if ($goal === "muscle building") {
        $suggestions[] = "High-Protein Foods";
        $suggestions[] = "Complex Carbohydrates (Energy Foods)";
    }
    if ($goal === "weight loss") {
        $suggestions[] = "High-Protein Foods";
        $suggestions[] = "High-Fiber Foods";
        $suggestions[] = "Low-Carbohydrate Foods";
    }
    if ($goal === "weight gain") {
        $suggestions[] = "Weight Gain Foods";
    }
    if ($goal === "maintain fitness") {
        $suggestions[] = "Balanced Energy Foods";
    }

    // Diseases
    if (in_array("diabetes", $diseases)) {
        $suggestions[] = "Diabetic-Friendly Foods";
    }
    if (in_array("hypertension", $diseases)) {
        $suggestions[] = "Low-Sodium Foods";
    }
    if (in_array("high cholesterol", $diseases)) {
        $suggestions[] = "Low-Fat / Heart-Healthy Foods";
    }
    if (in_array("fatty liver", $diseases)) {
        $suggestions[] = "Low-Fat / Heart-Healthy Foods";
    }

    // BMI considerations
    if ($bmi_cat === "Underweight") {
        $suggestions[] = "Weight Gain Foods";
    } elseif (in_array($bmi_cat, ["Overweight", "Obese Class I", "Obese Class II", "Obese Class III"])) {
        $suggestions[] = "Weight Loss Foods";
    }

    // General
    $suggestions[] = "Vitamin-Rich & Antioxidant Foods";
    $suggestions[] = "Hydrating Foods";

    return array_slice(array_unique($suggestions), 0, 5);
}

// -----------------------------
// Dynamic Nutrition Plan
// -----------------------------
$plan = [
    'Breakfast' => '',
    'Lunch' => '',
    'Dinner' => '',
    'Snack' => ''
];

$bmi = $user['bmi'] ?? 0;
$sugar = strtolower($user['sugar_level'] ?? '');
$pressure = strtolower($user['pressure_level'] ?? '');
$allergy = strtolower($user['allergy'] ?? 'none');
$goal = strtolower($user['fitness_goal'] ?? '');
$pref = strtolower($user['dietary_pref'] ?? 'omnivore');
$bmi_cat = bmiCategory($bmi);
$age = $user['age'] ?? 25;

// Possible options
$breakfast_options = [
    'Low-Fat / Heart-Healthy Foods',
    'High-Protein Foods with Complex Carbs',
    'Protein & Calorie-Dense Foods',
    'Balanced Breakfast with Protein & Fiber',
    'Smoothie with Fruits and Protein'
];
$lunch_options = [
    'High-Protein Foods with Veggies',
    'Low-Calorie, High-Fiber Foods',
    'Calorie-Dense, Nutrient-Rich Foods',
    'Balanced Meal with Protein & Carbs',
    'Grilled Lean Meat with Salad'
];
$dinner_options = [
    'Low-Carbohydrate Foods',
    'Protein-Rich Foods',
    'Light, Balanced Dinner',
    'Vegetable Soup with Lean Protein'
];
$snack_options = [
    'Low-Sugar / High-Fiber Snacks',
    'Protein & Healthy Fat Snacks',
    'High-Fiber Snacks',
    'Nuts and Seeds',
    'Fruit with Yogurt'
];

// Apply conditions (Breakfast)
if ($bmi >= 30 || $sugar === 'high' || $pressure === 'high') {
    $plan['Breakfast'] = $breakfast_options[0];
} elseif ($goal === 'muscle building') {
    $plan['Breakfast'] = $breakfast_options[1];
} elseif ($goal === 'weight gain') {
    $plan['Breakfast'] = $breakfast_options[2];
} else {
    $plan['Breakfast'] = $breakfast_options[3];
}

// Lunch
if ($goal === 'muscle building') {
    $plan['Lunch'] = $lunch_options[0];
} elseif ($goal === 'weight loss') {
    $plan['Lunch'] = $lunch_options[1];
} elseif ($goal === 'weight gain') {
    $plan['Lunch'] = $lunch_options[2];
} else {
    $plan['Lunch'] = $lunch_options[3];
}

// Dinner
if ($goal === 'weight loss' || $bmi >= 25) {
    $plan['Dinner'] = $dinner_options[0];
} elseif ($goal === 'muscle building') {
    $plan['Dinner'] = $dinner_options[1];
} else {
    $plan['Dinner'] = $dinner_options[2];
}

// Snack
if ($sugar === 'high') {
    $plan['Snack'] = $snack_options[0];
} elseif ($goal === 'weight gain') {
    $plan['Snack'] = $snack_options[1];
} else {
    $plan['Snack'] = $snack_options[2];
}

// Allergy filtering
foreach ($plan as $meal => $items) {
    $plan[$meal] = implode(', ', avoidAllergies(explode('/', $items), $allergy));
}

// Nutrition categories
$diseases = array_map('trim', explode(',', strtolower($user['disease'] ?? '')));
$nutrition_categories = suggestNutritionCategories($goal, $diseases, $bmi_cat);

// Final string
$recommended_nutrition_plan = "Recommended Nutrition Plan: ";
$parts = [];
foreach ($plan as $meal => $items) {
    $parts[] = "$meal: $items";
}
$recommended_nutrition_plan .= implode(" | ", $parts);
$recommended_nutrition_plan .= " | Suggested Categories: " . implode(', ', $nutrition_categories);

// -----------------------------
// Save to DB
// -----------------------------
$created_at = $updated_at = date('Y-m-d H:i:s');

$insert_stmt = $conn->prepare("
    INSERT INTO user_nutrition_data
    (user_id, weight_kg, height_cm, bmi, bmr, calories_per_kg, activity_level, dietary_pref, fitness_goal, disease, allergy, pressure_level, sugar_level, age, nutrition_suggestion, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$insert_stmt->bind_param(
    "idddddsssssssisss",
    $user['user_id'],
    $user['weight_kg'],
    $user['height_cm'],
    $user['bmi'],
    $user['bmr'],
    $user['calories_per_kg'],
    $user['activity_level'],
    $user['dietary_pref'],
    $user['fitness_goal'],
    $user['disease'],
    $user['allergy'],
    $user['pressure_level'],
    $user['sugar_level'],
    $user['age'],
    $recommended_nutrition_plan,
    $created_at,
    $updated_at
);

$insert_stmt->execute();
$insert_stmt->close();

// -----------------------------
// Helper Functions for Health Feedback
// -----------------------------
function bmiCategory1($bmi) {
    if ($bmi < 18.5) return 'Underweight';
    elseif ($bmi < 25) return 'Normal weight';
    elseif ($bmi < 30) return 'Overweight';
    elseif ($bmi < 35) return 'Obese Class I';
    elseif ($bmi < 40) return 'Obese Class II';
    else return 'Obese Class III';
}

function assignDiseasesAndFeedback($age, $bmi_cat, $activity_level) {
    $diseases = [];
    $feedback = "";

    // Disease assignment rules
    if ($age >= 40 && in_array($bmi_cat, ['Overweight','Obese Class I','Obese Class II','Obese Class III']) 
        && in_array($activity_level, ['Sedentary','Lightly Active'])) {
        $diseases[] = 'Hypertension';
    }
    if ($age >= 35 && in_array($bmi_cat, ['Overweight','Obese Class I','Obese Class II','Obese Class III']) 
        && $activity_level === 'Sedentary') {
        $diseases[] = 'Diabetes';
    }
    if ($age >= 35 && in_array($bmi_cat, ['Overweight','Obese Class I','Obese Class II','Obese Class III']) 
        && in_array($activity_level, ['Sedentary','Lightly Active'])) {
        $diseases[] = 'High Cholesterol';
    }
    if ($age >= 30 && in_array($bmi_cat, ['Overweight','Obese Class I','Obese Class II','Obese Class III']) 
        && $activity_level === 'Sedentary') {
        $diseases[] = 'Fatty Liver';
    }

    // Personalized feedback
    if ($bmi_cat === 'Normal weight') {
        $feedback = "Healthy BMI! Keep up the good work 😊";
    } elseif (in_array("Diabetes", $diseases)) {
        $feedback = "Focus on low-GI foods and balanced carbs to control blood sugar.";
    } elseif (in_array("Hypertension", $diseases)) {
        $feedback = "Limit salt intake and eat more potassium-rich foods to control blood pressure.";
    } elseif (in_array("High Cholesterol", $diseases)) {
        $feedback = "Choose heart-healthy fats and avoid fried/high-fat meals.";
    } elseif (in_array("Fatty Liver", $diseases)) {
        $feedback = "Adopt a low-fat diet and stay active to improve liver health.";
    } else {
        $feedback = "Focus on balanced diet and regular activity for better health.";
    }

    return [$diseases, $feedback];
}

// -----------------------------
// Process user data for health feedback
// -----------------------------
$bmi = $user['bmi'] ?? 0;
$age = $user['age'] ?? 25;
$activity_level = $user['activity_level'] ?? 'Moderately Active';
$bmi_cat = bmiCategory1($bmi);

list($detected_diseases, $health_feedback) = assignDiseasesAndFeedback($age, $bmi_cat, $activity_level);

// Final suggestion string
$final_suggestion = "Health Feedback: " . $health_feedback;
if (!empty($detected_diseases)) {
    $final_suggestion .= "";
}

// -----------------------------
// Save to DB -> health_feedback_suggestions
// -----------------------------
$created_at = date('Y-m-d H:i:s');

$insert_stmt = $conn->prepare("
    INSERT INTO health_feedback_suggestions (user_id, suggestion, created_at)
    VALUES (?, ?, ?)
");
$insert_stmt->bind_param(
    "iss",
    $user['user_id'],
    $final_suggestion,
    $created_at
);
$insert_stmt->execute();
$insert_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FitBuddy Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
/* Modern CSS Reset & Variables */
:root {
    --primary: #4361ee;
    --secondary: #3a0ca3;
    --accent: #4cc9f0;
    --success: #2ecc71;
    --warning: #f39c12;
    --danger: #e74c3c;
    --info: #1abc9c;
    --dark: #2b2d42;
    --light: #f8f9fa;
    --gray: #8d99ae;
    --card-bg: #ffffff;
    --sidebar-bg: #2b2d42;
    --header-height: 70px;
    --border-radius: 16px;
    --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    --transition: all 0.3s ease;
}

* { 
    margin: 0; 
    padding: 0; 
    box-sizing: border-box; 
}

body { 
    font-family: 'Poppins', sans-serif;
    background-color: #f5f7fa; 
    color: var(--dark);
    line-height: 1.6;
    overflow-x: hidden;
}

/* Dashboard Layout */
.dashboard {
    display: grid;
    grid-template-columns: 280px 1fr;
    min-height: 100vh;
}

/* Modern Sidebar */
.sidebar {
    background: var(--sidebar-bg);
    color: white;
    padding: 25px 20px;
    position: fixed;
    width: 280px;
    height: 100%;
    overflow-y: auto;
    z-index: 100;
    transition: var(--transition);
    box-shadow: var(--shadow);
}

.logo {
    display: flex;
    align-items: center;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.logo i {
    font-size: 28px;
    margin-right: 12px;
    color: var(--accent);
    background: linear-gradient(135deg, var(--accent), var(--primary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.logo h1 {
    font-size: 24px;
    font-weight: 700;
    background: linear-gradient(135deg, #fff, var(--accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 14px 18px;
    border-radius: 12px;
    margin-bottom: 8px;
    cursor: pointer;
    transition: var(--transition);
    color: #adb5bd;
    font-weight: 500;
}

.nav-item:hover, .nav-item.active {
    background: rgba(255, 255, 255, 0.08);
    color: white;
    transform: translateX(5px);
}

.nav-item i {
    margin-right: 12px;
    font-size: 20px;
    width: 24px;
    text-align: center;
}

.nav-item a {
    color: inherit;
    text-decoration: none;
    flex-grow: 1;
}

.notification-badge {
    background: var(--danger);
    color: white;
    font-size: 12px;
    padding: 2px 8px;
    border-radius: 10px;
}

/* Main Content */
.main-content {
    grid-column: 2;
    padding: 30px;
    padding-top: calc(var(--header-height) + 30px);
}

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    background: var(--card-bg);
    padding: 20px 30px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    position: fixed;
    top: 0;
    right: 0;
    left: 280px;
    z-index: 90;
    height: var(--header-height);
}

.welcome h1 {
    font-size: 24px;
    color: var(--dark);
    margin-bottom: 4px;
    font-weight: 600;
}

.date {
    color: var(--gray);
    font-size: 14px;
    font-weight: 500;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--primary);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
}

.user-info div {
    font-weight: 500;
}

/* Profile Card */
.profile-card {
    display: flex;
    align-items: center;
    gap: 30px;
    padding: 25px;
    background: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    margin-bottom: 30px;
}

.profile-picture {
    text-align: center;
    flex-shrink: 0;
}

.profile-picture img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--primary);
    box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
}

.age-badge {
    display: inline-block;
    margin-top: 12px;
    background: var(--primary);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 500;
    font-size: 14px;
}

.profile-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    flex-grow: 1;
    justify-content: center;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 18px;
    border-radius: 12px;
    font-weight: 500;
    background: var(--light);
    transition: var(--transition);
}

.stat-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

/* Recommendations Grid */
.recommendations-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

/* Card Design */
.suggestion-card {
    background: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 25px;
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: var(--transition);
    border-top: 4px solid var(--primary);
}

.suggestion-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.suggestion-card h3 {
    color: var(--dark);
    margin-bottom: 18px;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    font-weight: 600;
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.suggestion-card h3 i {
    color: var(--primary);
}

.suggestion-card p {
    margin-bottom: 15px;
    text-align: justify;
    color: #495057;
    line-height: 1.7;
}

.suggestion-card strong {
    color: var(--dark);
    font-weight: 600;
}

/* Health Boxes */
.health-boxes {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin: 15px 0;
}

.health-box {
    flex: 1;
    min-width: 100px;
    padding: 12px;
    border-radius: 12px;
    font-weight: 600;
    text-align: center;
    color: white;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.health-bmi { background: linear-gradient(135deg, var(--primary), var(--secondary)); }
.health-sugar { 
    background: linear-gradient(135deg, <?php echo (strtolower($user['sugar_label'] ?? '') === 'high' ? 'var(--danger)' : 'var(--success)'); ?>, #2c3e50); 
}
.health-pressure { 
    background: linear-gradient(135deg, <?php echo (strtolower($user['pressure_label'] ?? '') === 'high' ? 'var(--danger)' : 'var(--success)'); ?>, #2c3e50); 
}

.health-attention {
    background: #fff0f5;
    color: #c0392b;
    padding: 15px;
    border-radius: 12px;
    margin-top: 15px;
    font-weight: 500;
    text-align: justify;
    border-left: 4px solid #e74c3c;
}

/* Suggestion List */
.suggestion-list {
    list-style: none;
    margin-top: 10px;
}

.suggestion-list li {
    padding: 10px 0;
    padding-left: 30px;
    position: relative;
    text-align: justify;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.suggestion-list li:last-child {
    border-bottom: none;
}

.suggestion-list li:before {
    content: "•";
    color: var(--accent);
    font-size: 24px;
    position: absolute;
    left: 0;
    top: 8px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .dashboard {
        grid-template-columns: 240px 1fr;
    }
    
    .sidebar {
        width: 240px;
    }
    
    .header {
        left: 240px;
    }
}

@media (max-width: 992px) {
    .dashboard {
        grid-template-columns: 1fr;
    }
    
    .sidebar {
        position: fixed;
        left: -280px;
        width: 280px;
        z-index: 1000;
    }
    
    .sidebar.active {
        left: 0;
    }
    
    .main-content {
        grid-column: 1;
        padding: 20px;
        padding-top: calc(var(--header-height) + 20px);
    }
    
    .header {
        left: 0;
    }
    
    .menu-toggle {
        display: block;
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1100;
        background: var(--primary);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
}

@media (max-width: 768px) {
    .recommendations-grid {
        grid-template-columns: 1fr;
    }
    
    .header {
        flex-direction: column;
        align-items: flex-start;
        height: auto;
        padding: 15px 20px;
    }
    
    .user-info {
        margin-top: 15px;
        width: 100%;
        justify-content: flex-end;
    }
    
    .profile-card {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-stats {
        justify-content: center;
    }
    
    .health-boxes {
        flex-direction: column;
    }
}

@media (max-width: 576px) {
    .profile-stats {
        flex-direction: column;
    }
    
    .stat-item {
        width: 100%;
        justify-content: center;
    }
    
    .main-content {
        padding: 15px;
        padding-top: calc(var(--header-height) + 15px);
    }
}

/* Menu Toggle Button (for mobile) */
.menu-toggle {
    display: none;
}

/* Overlay for mobile menu */
.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

/* Custom Scrollbar */
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
    background: var(--secondary);
}

/* Animation for cards */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.suggestion-card {
    animation: fadeIn 0.5s ease forwards;
}

.suggestion-card:nth-child(2) {
    animation-delay: 0.1s;
}

.suggestion-card:nth-child(3) {
    animation-delay: 0.2s;
}

.suggestion-card:nth-child(4) {
    animation-delay: 0.3s;
}

/* Logout button styling */
.logout-btn {
    margin-top: auto;
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 14px 18px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    transition: var(--transition);
    width: 100%;
}

.logout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
}
</style>
</head>
<body>
<div class="dashboard">
    <!-- Mobile Menu Toggle -->
    <div class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </div>
    
    <!-- Overlay for mobile menu -->
    <div class="overlay" id="overlay"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Logo -->
        <div class="logo">
            <i class="fas fa-dumbbell"></i>
            <h1>FitBuddy</h1>
        </div>

        <!-- Notifications -->
        <div class="nav-item">
            <i class="fas fa-bell"></i>
            <a href="user_notifications.php">Notifications</a>
            <span class="notification-badge">3</span>
        </div>

        <!-- Navigation Links -->
        <div class="nav-item">
            <i class="fas fa-user"></i>
            <a href="user_profile.php">My Profile</a>
        </div>
        <div class="nav-item active">
            <i class="fas fa-home"></i>
            <a href="user_dashboard.php">Dashboard</a>
        </div>
        <div class="nav-item">
            <i class="fas fa-running"></i>
            <a href="user_workouts.php">Workouts</a>
        </div>
        <div class="nav-item">
            <i class="fas fa-utensils"></i>
            <a href="user_nutrition.php">Nutrition</a>
        </div>
        <div class="nav-item">
            <i class="fas fa-chart-line"></i>
            <a href="user_progress.php">Progress</a>
        </div>
        <div class="nav-item">
            <i class="fas fa-envelope"></i>
            <a href="Message.php">Message</a>
        </div>
        <div class="nav-item">
            <i class="fas fa-heartbeat"></i>
            <a href="health_tips.php">Health Tips</a>
        </div>
        <div class="nav-item">
            <i class="fas fa-cog"></i>
            <a href="user_settings.php">Settings</a>
        </div>

        <!-- Logout at Bottom -->
        <button class="logout-btn" onclick="window.location.href='logout.php'">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </button>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="welcome">
                <h1>Welcome back, <?= ($user['first_name'] ?? 'User') ?>!</h1>
                <div class="date" id="current-date"><?= date("l, F j, Y") ?></div>
            </div>
            <div class="user-info">
                <img src="<?= $user['profile_picture'] ?? 'uploads/default.png' ?>" alt="Profile" class="user-img">
                <div><?= ($user['first_name'] ?? '') . " " . ($user['last_name'] ?? '') ?></div>
            </div>
        </div>

        <!-- User Profile Card -->
        <div class="profile-card">
            <!-- Left: Profile Picture + Age -->
            <div class="profile-picture">
                <img src="<?= $user['profile_picture'] ?? 'uploads/default.png' ?>" alt="Profile Picture">
                <div class="age-badge">Age: <?= $user['age'] ?? 'N/A' ?> yrs</div>
            </div>

            <!-- Center: Stats with spacing -->
            <div class="profile-stats">
                <div class="stat-item" style="color: #e74c3c;">
                    <i class="fas fa-weight"></i> <strong>Weight:</strong> <?= $user['weight_kg'] ?? 'N/A' ?> kg
                </div>
                <div class="stat-item" style="color: #3498db;">
                    <i class="fas fa-ruler-vertical"></i> <strong>Height:</strong> <?= $user['height_cm'] ?? 'N/A' ?> cm
                </div>
                <div class="stat-item" style="color: #2ecc71;">
                    <i class="fas fa-running"></i> <strong>Activity:</strong> <?= $user['activity_level'] ?? 'N/A' ?>
                </div>
                <div class="stat-item" style="color: #f39c12;">
                    <i class="fas fa-carrot"></i> <strong>Diet:</strong> <?= $user['dietary_pref'] ?? 'N/A' ?>
                </div>
                <div class="stat-item" style="color: #8e44ad;">
                    <i class="fas fa-heartbeat"></i> <strong>BMI:</strong> <?= $user['bmi'] ?? 'N/A' ?>
                </div>
            </div>
        </div>

        <!-- Recommendations Grid -->
        <div class="recommendations-grid">
            <!-- Health Data Card -->
            <div class="suggestion-card">
                <h3><i class="fas fa-heartbeat"></i> Health Data</h3>
                <p><strong>Recent Symptoms:</strong> <?= $user['disease'] ?? 'No recent symptoms' ?></p>
                <p><strong>Allergies:</strong> <?= $user['allergy'] ?? 'None' ?></p>
                
                <div class="health-boxes">
                    <div class="health-box health-bmi">
                        BMI: <?= $bmi ?? 'N/A' ?>
                    </div>
                    <div class="health-box health-sugar">
                        Sugar: <?= $user['sugar_label'] ?? 'N/A' ?>
                    </div>
                    <div class="health-box health-pressure">
                        Pressure: <?= $user['pressure_label'] ?? 'N/A' ?>
                    </div>
                </div>
                
                <div class="health-attention">
                    <?= $health_attention ?>
                </div>
            </div>

            <!-- Fitness Goals Card -->
            <div class="suggestion-card">
                <h3><i class="fas fa-bullseye"></i> Fitness Goals</h3>
                <p><strong>Primary Goal:</strong> <?= ucfirst($user['fitness_goal'] ?? 'No goals set') ?></p>
                
                <h4 style="margin: 15px 0 10px 0; font-weight: 600;">Suggestions:</h4>
                <ul class="suggestion-list">
                    <?php foreach ($suggestions as $s): ?>
                        <li><?= $s ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Nutrition Suggestions Card -->
            <div class="suggestion-card">
                <h3><i class="fas fa-utensils"></i> Nutrition Suggestions</h3>
                <p><?= $recommended_nutrition_plan ?></p>
            </div>

            <!-- Health Feedback Card -->
            <div class="suggestion-card">
                <h3><i class="fas fa-stethoscope"></i> Health Feedback</h3>
                <p><?= $final_suggestion ?></p>
            </div>
        </div>
    </div>
</div>

<script>
// Dynamic Date
function updateDate() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('current-date').textContent = now.toLocaleDateString('en-US', options);
}

// Mobile Menu Toggle
const menuToggle = document.getElementById('menuToggle');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

menuToggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
});

overlay.addEventListener('click', () => {
    sidebar.classList.remove('active');
    overlay.style.display = 'none';
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateDate();
    
    // Add animation delay to cards for staggered effect
    const cards = document.querySelectorAll('.suggestion-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});

// Adjust layout on window resize
window.addEventListener('resize', function() {
    if (window.innerWidth > 992) {
        sidebar.classList.remove('active');
        overlay.style.display = 'none';
    }
});
</script>
</body>
</html>