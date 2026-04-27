<?php
session_start();
require 'conn.php';

// 🔐 Security check
if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

/* ================================
   UPDATE SENSOR STATUS (FIXED)
================================ */
if (isset($_POST['sensor_id']) && isset($_POST['status'])) {

    $sensor_id = $_POST['sensor_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("
        UPDATE sensors 
        SET status = ? 
        WHERE sensor_id = ?
    ");

    $stmt->bind_param("si", $status, $sensor_id);
    $stmt->execute();

    header("Location: manage_sensors.php");
    exit();
}

/* ================================
   GET ALL SENSORS
================================ */
$sensors = $conn->query("SELECT * FROM sensors ORDER BY sensor_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Sensors</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: #1e1e1e;
    color: white;
}

/* HEADER */
.header {
    background: #111;
    padding: 15px;
    text-align: center;
    color: orange;
    font-size: 20px;
}

/* CONTAINER */
.container {
    padding: 20px;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    background: #2a2a2a;
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #444;
    text-align: left;
    font-size: 14px;
}

th {
    background: #111;
    color: orange;
}

/* BUTTONS */
.btn {
    padding: 6px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 12px;
}

.online {
    background: green;
    color: white;
}

.offline {
    background: red;
    color: white;
}

.back {
    margin-bottom: 15px;
    display: inline-block;
    color: orange;
    text-decoration: none;
}
</style>

</head>
<body>

<div class="header">📡 Manage Sensors</div>

<div class="container">

<a href="admin_homepage.php" class="back">← Back to Dashboard</a>

<table>
    <tr>
        <th>ID</th>
        <th>Sensor Name</th>
        <th>Homeowner</th>
        <th>Location</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php while ($s = $sensors->fetch_assoc()) { ?>

    <tr>
        <td><?= $s['sensor_id'] ?></td>
        <td><?= $s['sensor_name'] ?></td>
        <td><?= $s['homeowner_name'] ?></td>
        <td><?= $s['location_name'] ?></td>
        <td>
            <?php if ($s['status'] == "online") { ?>
                🟢 Online
            <?php } else { ?>
                🔴 Offline
            <?php } ?>
        </td>

        <td>

            <!-- SET ONLINE -->
            <form method="POST" style="display:inline;">
                <input type="hidden" name="sensor_id" value="<?= $s['sensor_id'] ?>">
                <button class="btn online" name="status" value="online">
                    Online
                </button>
            </form>

            <!-- SET OFFLINE -->
            <form method="POST" style="display:inline;">
                <input type="hidden" name="sensor_id" value="<?= $s['sensor_id'] ?>">
                <button class="btn offline" name="status" value="offline">
                    Offline
                </button>
            </form>

        </td>
    </tr>

    <?php } ?>

</table>

</div>

</body>
</html>