<?php
$servername = "localhost";
$username = "root";  // Change this to your database username
$password = "";      // Change this to your database password
$db = "app_db";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

