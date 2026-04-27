<?php
session_start();
require 'conn.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $name = $_POST['sensor_name'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("
        UPDATE sensors 
        SET sensor_name=?, status=? 
        WHERE id=?
    ");

    $stmt->bind_param("ssi", $name, $status, $id);
    $stmt->execute();

    header("Location: manage_sensors.php");
    exit();
}
?>