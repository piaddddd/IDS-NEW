<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "app_db";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    echo json_encode(["state" => "off", "error" => "Database connection failed"]);
    exit();
}


$sensor = $_GET['sensor'] ?? 'PIR_LivingRoom';


$stmt = $conn->prepare("SELECT state FROM sensors WHERE sensor = ?");
$stmt->bind_param("s", $sensor);
$stmt->execute();
$result = $stmt->get_result();


if ($row = $result->fetch_assoc()) {
    echo json_encode(["state" => $row['state']]);
} else {
    echo json_encode(["state" => "off"]);
}

$stmt->close();
$conn->close();
?>
