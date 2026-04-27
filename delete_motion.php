<?php
session_start();
// optional: require login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "app_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete single record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $stmt = $conn->prepare("DELETE FROM motion_alerts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // redirect back to homepage (or wherever your modal lives)
    header("Location: homepage.php");
    exit();
}

// Delete all records
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_all'])) {
    // Use DELETE if you want to keep auto_increment; TRUNCATE cannot be used in prepared statement easily.
    $conn->query("TRUNCATE TABLE motion_alerts");
    $conn->close();

    header("Location: homepage.php");
    exit();
}

$conn->close();
?>
