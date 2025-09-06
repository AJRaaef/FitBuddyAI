<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current user details
$query = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $age = $_POST['age'];
    $weight_kg = $_POST['weight_kg'];
    $height_cm = $_POST['height_cm'];
    $activity_level = $_POST['activity_level'];
    $dietary_pref = $_POST['dietary_pref'];
    $fitness_goal = $_POST['fitness_goal'];
    $disease = $_POST['disease'];
    $allergy = $_POST['allergy'];
    $pressure_level = $_POST['pressure_level'];
    $sugar_level = $_POST['sugar_level'];

    // Handle profile picture
    if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['name'] != ''){
        $file_name = time().'_'.basename($_FILES['profile_picture']['name']);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], 'uploads/'.$file_name);
        $profile_picture_sql = ", profile_picture='uploads/{$file_name}'";
    } else {
        $profile_picture_sql = "";
    }

    // Recalculate BMI, BMR, and calories per kg
    $bmi = ($height_cm > 0) ? round($weight_kg / (($height_cm/100)**2), 2) : 0;
    // BMR using Mifflin-St Jeor Formula (assume male/female)
    if ($gender == 'Male') {
        $bmr = round(10*$weight_kg + 6.25*$height_cm - 5*$age + 5);
    } else {
        $bmr = round(10*$weight_kg + 6.25*$height_cm - 5*$age - 161);
    }
    $calories_per_kg = ($weight_kg > 0) ? round($bmr / $weight_kg, 2) : 0;

    // Check tracked fields for changes
    $fields_to_track = ['weight_kg','height_cm','bmi','bmr','calories_per_kg','activity_level','dietary_pref','fitness_goal','disease','allergy','pressure_level','sugar_level'];
    $has_changed = false;
    foreach ($fields_to_track as $field) {
        $new_val = $$field ?? '';
        $old_val = $user[$field] ?? '';
        if (in_array($field, ['weight_kg','height_cm','bmi','bmr','calories_per_kg'])) {
            if (floatval($old_val) !== floatval($new_val)) { $has_changed = true; break; }
        } else {
            if (trim($old_val) !== trim($new_val)) { $has_changed = true; break; }
        }
    }

    // Update users table
    $update_query = "UPDATE users SET
        first_name='$first_name',
        last_name='$last_name',
        email='$email',
        phone_number='$phone_number',
        gender='$gender',
        date_of_birth='$date_of_birth',
        age='$age',
        weight_kg='$weight_kg',
        height_cm='$height_cm',
        bmi='$bmi',
        bmr='$bmr',
        calories_per_kg='$calories_per_kg',
        activity_level='$activity_level',
        dietary_pref='$dietary_pref',
        fitness_goal='$fitness_goal',
        disease='$disease',
        allergy='$allergy',
        pressure_level='$pressure_level',
        sugar_level='$sugar_level'
        $profile_picture_sql
        WHERE user_id='$user_id'";
    mysqli_query($conn, $update_query);

    // Insert into user_tracking if any tracked field changed
if ($has_changed) {
    $insert_query = "INSERT INTO user_tracking 
        (user_id, weight_kg, height_cm, bmi, bmr, calories_per_kg, activity_level, dietary_pref, fitness_goal, disease, allergy, pressure_level, sugar_level, age, created_at)
        VALUES
        ('$user_id', '$weight_kg', '$height_cm', '$bmi', '$bmr', '$calories_per_kg', '$activity_level', '$dietary_pref', '$fitness_goal', '$disease', '$allergy', '$pressure_level', '$sugar_level', '$age', NOW())";
    mysqli_query($conn, $insert_query);
}


    header("Location: user_profile.php");
    exit();
}

// Determine profile picture path
$profile_picture_path = (!empty($user['profile_picture']) && file_exists('uploads/'.$user['profile_picture'])) ? 'uploads/'.$user['profile_picture'] : 'uploads/default.png';
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Profile</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body { font-family: 'Segoe UI', sans-serif; background:#f5f7fa; color:#333; padding:20px; }
.container { max-width:1000px; margin:0 auto; display:grid; gap:20px; }
.card { background:white; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.05); padding:20px; }
.profile-card { display:flex; gap:20px; align-items:center; }
.profile-left { text-align:center; width:200px; }
.profile-left img { width:150px; height:150px; border-radius:50%; object-fit:cover; border:3px solid #3498db; }
.profile-left small { display:block; margin-top:5px; color:#95a5a6; }
.profile-left h3 { margin-top:5px; }
.profile-right { flex:1; display:grid; grid-template-columns:1fr 1fr; gap:15px; }
.info-item { display:flex; flex-direction:column; }
.info-item label { font-size:14px; color:#95a5a6; margin-bottom:5px; }
.info-item span, .info-item input, .info-item select { font-size:16px; font-weight:600; color:#2c3e50; }
input, select { padding:5px 8px; border-radius:6px; border:1px solid #ccc; width:100%; }
.edit-btn { float:right; background:#3498db; color:white; padding:10px 20px; border:none; border-radius:8px; cursor:pointer; margin-bottom:10px; }
@media(max-width:800px){.profile-card{flex-direction:column;text-align:center}.profile-right{grid-template-columns:1fr}}
</style>
</head>
<body>
<div class="container">
    <button class="edit-btn" id="editBtn"><i class="fas fa-edit"></i> Edit Profile</button>
    <form method="post" enctype="multipart/form-data" id="profileForm">
        <!-- Profile Box -->
        <div class="card profile-card">
            <div class="profile-left">
              <img src="<?= !empty($user['profile_picture']) ? str_replace('\\','/',$user['profile_picture']) : 'uploads/default.png' ?>" id="profilePicPreview">
<input type="file" name="profile_picture" id="profilePic" style="display:none;">
                <small>Workout Goal</small>
                <span class="display-only"><?= !empty($user['fitness_goal']) ? $user['fitness_goal'] : '-' ?></span>
                <input type="text" name="fitness_goal" class="edit-only" value="<?= !empty($user['fitness_goal']) ? $user['fitness_goal'] : '' ?>" style="display:none;">
            </div>
            <div class="profile-right">
                <div class="info-item">
                    <label>Email</label>
                    <span class="display-only"><?= !empty($user['email']) ? $user['email'] : '-' ?></span>
                    <input type="email" name="email" class="edit-only" value="<?= !empty($user['email']) ? $user['email'] : '' ?>" style="display:none;">
                </div>
                <div class="info-item">
                    <label>Phone</label>
                    <span class="display-only"><?= !empty($user['phone_number']) ? $user['phone_number'] : '-' ?></span>
                    <input type="text" name="phone_number" class="edit-only" value="<?= !empty($user['phone_number']) ? $user['phone_number'] : '' ?>" style="display:none;">
                </div>
                <div class="info-item">
                    <label>Joined Date</label>
                    <span><?= $user['created_at'] ?></span>
                </div>
            </div>
        </div>

        <!-- Personal Information Box -->
        <div class="card">
            <h3>Personal Information</h3>
            <div class="info-group" style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                <div class="info-item">
                    <label>Full Name</label>
                    <span class="display-only"><?= $user['first_name'].' '.$user['last_name'] ?></span>
                    <input type="text" name="first_name" class="edit-only" value="<?= $user['first_name'] ?>" style="display:none;">
                    <input type="text" name="last_name" class="edit-only" value="<?= $user['last_name'] ?>" style="display:none;">
                </div>
                <div class="info-item">
                    <label>Gender</label>
                    <span class="display-only"><?= $user['gender'] ?></span>
                    <select name="gender" class="edit-only" style="display:none;">
                        <option value="Male" <?= $user['gender']=='Male'?'selected':'' ?>>Male</option>
                        <option value="Female" <?= $user['gender']=='Female'?'selected':'' ?>>Female</option>
                    </select>
                </div>
                <div class="info-item">
                    <label>Date of Birth</label>
                    <span class="display-only"><?= $user['date_of_birth'] ?></span>
                    <input type="date" name="date_of_birth" class="edit-only" value="<?= $user['date_of_birth'] ?>" style="display:none;">
                </div>
                <div class="info-item">
                    <label>Age</label>
                    <span class="display-only"><?= $user['age'] ?></span>
                    <input type="number" name="age" class="edit-only" value="<?= $user['age'] ?>" style="display:none;">
                </div>
                <div class="info-item">
                    <label>Activity Level</label>
                    <span class="display-only"><?= $user['activity_level'] ?></span>
                    <input type="text" name="activity_level" class="edit-only" value="<?= $user['activity_level'] ?>" style="display:none;">
                </div>
                <div class="info-item">
                    <label>Dietary Preference</label>
                    <span class="display-only"><?= $user['dietary_pref'] ?></span>
                    <input type="text" name="dietary_pref" class="edit-only" value="<?= $user['dietary_pref'] ?>" style="display:none;">
                </div>
            </div>
        </div>

        <!-- Health & Fitness Box -->
        <div class="card">
            <h3>Health & Fitness Information</h3>
            <div class="info-group" style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                <?php
                $fields = ['weight_kg'=>'Weight (kg)','height_cm'=>'Height (cm)','bmi'=>'BMI','bmr'=>'BMR','calories_per_kg'=>'Calories per kg','disease'=>'Disease','allergy'=>'Allergy','pressure_level'=>'Pressure Level','sugar_level'=>'Sugar Level'];
                foreach($fields as $key=>$label){
                    echo '<div class="info-item">
                        <label>'.$label.'</label>
                        <span class="display-only">'.(!empty($user[$key])?$user[$key]:'-').'</span>
                        <input type="text" name="'.$key.'" class="edit-only" value="'.(!empty($user[$key])?$user[$key]:'').'" style="display:none;">
                    </div>';
                }
                ?>
            </div>
        </div>
    </form>
</div>

<script>
const editBtn = document.getElementById('editBtn');
const displayEls = document.querySelectorAll('.display-only');
const editEls = document.querySelectorAll('.edit-only');
const profilePicInput = document.getElementById('profilePic');
const profilePicPreview = document.getElementById('profilePicPreview');

editBtn.addEventListener('click', ()=>{
    if(editBtn.innerText.includes('Edit')){
        displayEls.forEach(el=>el.style.display='none');
        editEls.forEach(el=>el.style.display='block');
        profilePicInput.style.display='block';
        editBtn.innerHTML='<i class="fas fa-save"></i> Save Changes';
    } else {
        document.getElementById('profileForm').submit();
    }
});

profilePicInput.addEventListener('change', (e)=>{
    const file = e.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = ()=>{ profilePicPreview.src = reader.result; }
        reader.readAsDataURL(file);
    }
});
</script>
</body>
</html>
