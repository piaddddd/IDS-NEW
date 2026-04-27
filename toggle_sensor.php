<?php
require 'conn.php';

$id = intval($_GET['id']);

$result = $conn->query("SELECT status FROM sensors WHERE id=$id");
$row = $result->fetch_assoc();

if ($row) {
    $newStatus = ($row['status'] === 'online') ? 'offline' : 'online';
    $conn->query("UPDATE sensors SET status='$newStatus' WHERE id=$id");
}

header("Location: manage_sensors.php");
exit();
?>