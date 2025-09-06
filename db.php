<?php
// db.php
$host = "localhost";   // Database host
$user = "root";        // MySQL username
$pass = "";            // MySQL password (leave blank if none)
$dbname = "fitbuddyai"; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
