<?php
session_start();
require_once 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Check if user_id is provided
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    die("Invalid request.");
}

$user_id = intval($_GET['user_id']);

// Check if user exists first
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $stmt->close();
    die("User not found.");
}
$stmt->close();

// Attempt to delete
$stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: admin_dashboard.php?message=User+deleted+successfully");
    exit();
} else {
    $stmt->close();
    die("Error deleting user: " . $conn->error);
}
?>
