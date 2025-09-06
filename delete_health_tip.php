<?php
session_start();
require_once 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Get tip_id from URL
$tip_id = isset($_GET['tip_id']) ? intval($_GET['tip_id']) : 0;

if ($tip_id > 0) {
    // Optionally, fetch the image to delete from server
    $stmt = $conn->prepare("SELECT image_url FROM health_tips WHERE tip_id = ?");
    $stmt->bind_param("i", $tip_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($result && !empty($result['image_url']) && file_exists($result['image_url'])) {
        unlink($result['image_url']); // Delete image file
    }

    // Delete the record
    $stmt = $conn->prepare("DELETE FROM health_tips WHERE tip_id = ?");
    $stmt->bind_param("i", $tip_id);
    if ($stmt->execute()) {
        $stmt->close();
        header("Location: admin_dashboard.php?msg=Health tip deleted successfully");
        exit();
    } else {
        echo "Error deleting health tip: " . $conn->error;
    }
} else {
    echo "Invalid tip ID.";
}
?>
