<?php
session_start();
require_once 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Get admin_id from URL
$admin_id = isset($_GET['admin_id']) ? intval($_GET['admin_id']) : 0;

// Prevent deleting own account
if ($admin_id == $_SESSION['admin_id']) {
    header("Location: admin_dashboard.php?message=You+cannot+delete+your+own+account");
    exit();
}

// Delete admin
if ($admin_id > 0) {
    $stmt = $conn->prepare("DELETE FROM admins WHERE admin_id = ?");
    $stmt->bind_param("i", $admin_id);
    if ($stmt->execute()) {
        $stmt->close();
        header("Location: admin_dashboard.php?message=Admin+deleted+successfully");
        exit();
    } else {
        $stmt->close();
        header("Location: admin_dashboard.php?message=Error+deleting+admin");
        exit();
    }
} else {
    header("Location: admin_dashboard.php?message=Invalid+admin+ID");
    exit();
}
