<?php
session_start();
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "root", "", "app_db");

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

// Fetch the latest motion alert
$sql = "SELECT id, location, timestamp FROM motion_alerts ORDER BY timestamp DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode([
        "id" => null,
        "location" => "Living Room",
        "timestamp" => "2025-04-29 12:34:56"
    ]); // No motion alerts
}

$conn->close();
?>
