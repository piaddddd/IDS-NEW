<?php
session_start();
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "app_db");

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

$sql = "SELECT id, location, timestamp FROM motion_alerts ORDER BY timestamp DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode([
        "id" => null,
        "location" => "",
        "timestamp" => ""
    ]); 
}

$conn->close();
?>
