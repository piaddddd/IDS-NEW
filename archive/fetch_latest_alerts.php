<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "root", "", "app_db");

// Check connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}

// Fetch the latest motion alert
$sql = "SELECT location FROM motion_alerts ORDER BY timestamp DESC LIMIT 1";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["status" => "error", "message" => "Query failed"]);
    exit();
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["status" => "alert", "location" => $row["location"]]);
} else {
    echo json_encode(["status" => "clear"]);
}

$conn->close();
?>
