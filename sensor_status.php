<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "app_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$sensor = $_POST['sensor'] ?? null;
$status = $_POST['status'] ?? null;

if ($sensor && $status) {
    $stmt = $conn->prepare("REPLACE INTO sensor_status (sensor, status, last_ping) VALUES (?, ?, NOW())");
    if ($stmt) {
        $stmt->bind_param("ss", $sensor, $status);
        if ($stmt->execute()) {
            echo "OK";
        } else {
            echo "DB_ERROR";
        }
        $stmt->close();
    } else {
        echo "PREPARE_FAILED";
    }
} else {
    echo "INVALID_PARAMS";
}

$conn->close();
?>
