<?php
$conn = new mysqli("localhost", "root", "", "app_db");

if ($conn->connect_error) {
    die("Connection failed");
}

$mac = $_GET['mac'] ?? '';

// ❌ safety check
if ($mac == '') {
    echo json_encode(["error" => "No MAC provided"]);
    exit;
}

// 1. check if ESP already assigned
$stmt = $conn->prepare("SELECT * FROM sensors WHERE mac_address = ?");
$stmt->bind_param("s", $mac);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// ✅ already assigned
if ($row) {

    echo json_encode([
        "sensor_id" => $row['id'],
        "location" => $row['location_name']
    ]);

    exit;
}

// 2. find unassigned sensor created by admin
$result = $conn->query("SELECT * FROM sensors WHERE mac_address IS NULL LIMIT 1");
$sensor = $result->fetch_assoc();

// ❌ no available sensor
if (!$sensor) {
    echo json_encode(["error" => "No available sensor slot"]);
    exit;
}

// 3. assign ESP32 to that sensor
$id = $sensor['id'];

$stmt = $conn->prepare("UPDATE sensors SET mac_address = ? WHERE id = ?");
$stmt->bind_param("si", $mac, $id);
$stmt->execute();

// 4. return data to ESP32
echo json_encode([
    "sensor_id" => $id,
    "location" => $sensor['location_name']
]);
?>