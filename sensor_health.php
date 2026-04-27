<?php
$conn = new mysqli("localhost", "root", "", "app_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$temp = $_POST['temperature'] ?? null;
if ($temp !== null) {
    $stmt = $conn->prepare("INSERT INTO sensor_health (temperature, timestamp) VALUES (?, NOW())");
    $stmt->bind_param("d", $temp);
    $stmt->execute();
    $stmt->close();
}
$conn->close();
?>