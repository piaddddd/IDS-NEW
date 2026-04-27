<?php
$conn = new mysqli("localhost", "root", "", "app_db");

$id = $_GET['id'];

$result = $conn->query("SELECT location_name FROM sensors WHERE id=$id");
$row = $result->fetch_assoc();

echo json_encode($row);
?>