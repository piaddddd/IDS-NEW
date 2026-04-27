<?php

header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "root", "", "app_db");

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

// Get motion data from POST request
$motion = $_POST['motion'] ?? null;
$location = $_POST['location'] ?? null;

if ($motion && $location) {
    $stmt = $conn->prepare("INSERT INTO motion_alerts (location, timestamp) VALUES (?, NOW())");
    $stmt->bind_param("s", $location);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Motion alert logged']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to log motion alert']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}

$conn->close();
?>
