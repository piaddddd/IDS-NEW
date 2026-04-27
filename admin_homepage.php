<?php
session_start();
require 'conn.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add_sensor'])) {

    $sensor_name = $_POST['sensor_name'] ?? '';
    $homeowner_name = $_POST['homeowner_name'] ?? '';
    $location_name = $_POST['location_name'] ?? 'Amaia Scapes';
    $house_area = $_POST['house_area'] ?? '';
    $block = $_POST['block'] ?? '';
    $lot = $_POST['lot'] ?? '';

    $stmt = $conn->prepare("
        INSERT INTO sensors 
        (sensor_name, homeowner_name, location_name, house_area, block, lot, status)
        VALUES (?, ?, ?, ?, ?, ?, 'offline')
    ");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "ssssss",
        $sensor_name,
        $homeowner_name,
        $location_name,
        $house_area,
        $block,
        $lot
    );

    if ($stmt->execute()) {
        header("Location: admin_homepage.php");
        exit();
    } else {
        die("Insert failed: " . $stmt->error);
    }
}

/* ================= RECENT DETECTIONS ================= */
$res = $conn->query("
    SELECT ma.timestamp, s.homeowner_name, s.block, s.lot, s.location_name
    FROM motion_alerts ma
    INNER JOIN sensors s ON ma.sensor_id = s.sensor_id
    ORDER BY ma.timestamp DESC
");

/* ================= OPTIMIZED MONTH DATA ================= */
$year = date("Y");

$result = $conn->query("
    SELECT 
        MONTH(timestamp) as month,
        DAY(timestamp) as day,
        COUNT(*) as total
    FROM motion_alerts
    WHERE YEAR(timestamp) = $year
    GROUP BY month, day
");

$monthlyData = [];

while ($row = $result->fetch_assoc()) {
    $m = (int)$row['month'];
    $d = (int)$row['day'];

    if (!isset($monthlyData[$m])) {
        $monthlyData[$m] = array_fill(0, 31, 0);
    }

    $monthlyData[$m][$d - 1] = (int)$row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<style>

/* GLOBAL */
body {
    margin:0;
    font-family:Arial;
    background:#1e1e1e;
    color:white;
}

.header {
    background:#111;
    padding:15px;
    text-align:center;
    color:orange;
}

/* DASHBOARD */
.dashboard {
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:15px;
    padding:15px;
}

.card {
    background:#2a2a2a;
    padding:15px;
    border-radius:10px;
}

/* METRICS */
.metrics {
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:10px;
}

.metric-box {
    background:#333;
    padding:15px;
    text-align:center;
    border-radius:8px;
    cursor:pointer;
}

.metric-box h2 { color:orange; }

/* MAP */
#map {
    height:320px;
    border-radius:10px;
}

/* TABLE */
table {
    width:100%;
    border-collapse:collapse;
}

th, td {
    padding:8px;
    border-bottom:1px solid #444;
}

/* SCROLL */
.scroll-box {
    max-height:300px;
    overflow-y:auto;
}

/* BUTTON */
.btn {
    background:orange;
    border:none;
    padding:10px;
    margin:5px;
    border-radius:6px;
    cursor:pointer;
    width:100%;
}

/* MODALS */
#sensorModal, #monthModal {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.7);
    justify-content:center;
    align-items:center;
    z-index:9999;
}

.modal-box {
    background:#2a2a2a;
    padding:30px;
    width:450px;
    border-radius:12px;

    /* FIX CENTER + ALIGN */
    display:flex;
    flex-direction:column;
    align-items:stretch;
    gap:12px;
}

/* FORM INSIDE MODAL */
.modal-box form {
    display:flex;
    flex-direction:column;
    gap:12px;
    width:100%;
}

/* INPUT ALIGNMENT FIX */
.modal-box input {
    width:100%;
    padding:12px 14px;
    background:#1e1e1e;
    border:1px solid #444;
    color:white;
    border-radius:6px;
    font-size:14px;
    box-sizing:border-box;
}

/* TITLE FIX */
.modal-box h3 {
    text-align:center;
    margin:0;
    margin-bottom:5px;
}
/* MONTH */
.month-item {
    padding:10px;
    border-bottom:1px solid #444;
    text-align:center;
    cursor:pointer;
}

.month-item:hover {
    background:orange;
}

</style>
</head>

<body>

<div class="header">🛡️ ADMIN DASHBOARD</div>

<div class="dashboard">

<!-- LEFT -->
<div>

    <div class="card">
        <h3>📍 Live Map</h3>
        <div id="map"></div>
    </div>

    <div class="card">
        <h3>📅 Monthly Incidents</h3>
        <canvas id="monthlyChart"></canvas>
    </div>

    <div class="metrics">

        <?php
        $active = $conn->query("SELECT COUNT(*) c FROM sensors WHERE status='online'")->fetch_assoc()['c'];
        $offline = $conn->query("SELECT COUNT(*) c FROM sensors WHERE status='offline'")->fetch_assoc()['c'];
        $incidents = $conn->query("SELECT COUNT(*) c FROM motion_alerts")->fetch_assoc()['c'];
        ?>

        <div class="metric-box"><h2><?= $active ?></h2><p>Active</p></div>
        <div class="metric-box"><h2><?= $offline ?></h2><p>Offline</p></div>
        <div class="metric-box"><h2><?= $incidents ?></h2><p>Total Alerts</p></div>

        <div class="metric-box" onclick="openMonthModal()">
            <h2 id="selectedMonth"><?= date("F") ?></h2>
            <p>Month</p>
        </div>

    </div>

</div>

<!-- RIGHT -->
<div>

    <div class="card">
    <h3>📜 Recent Detections</h3>

    <div class="scroll-box">

        <table>
            <thead>
                <tr style="background:#111;">
                    <th>Homeowner</th>
                    <th>Location</th>
                    <th>Block / Lot</th>
                    <th>Time</th>
                </tr>
            </thead>

            <tbody>

            <?php
            $res = $conn->query("
                SELECT 
                    ma.timestamp,
                    s.homeowner_name,
                    s.block,
                    s.lot,
                    s.location_name
                FROM motion_alerts ma
                INNER JOIN sensors s ON ma.sensor_id = s.sensor_id
                ORDER BY ma.timestamp DESC
                LIMIT 20
            ");

            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    echo "
                    <tr>
                        <td><b>{$row['homeowner_name']}</b></td>
                        <td>{$row['location_name']}</td>
                        <td>Block {$row['block']} - Lot {$row['lot']}</td>
                        <td>{$row['timestamp']}</td>
                    </tr>
                    ";
                }
            } else {
                echo "
                <tr>
                    <td colspan='4' style='text-align:center; color:#aaa;'>
                        No detections found
                    </td>
                </tr>";
            }
            ?>

            </tbody>
        </table>

    </div>
</div>

    <div class="card">
    <h3>📡 Sensors</h3>

    <?php
    $sensors = $conn->query("SELECT * FROM sensors");

    while ($s = $sensors->fetch_assoc()) {
        echo "
        <div style='margin-bottom:10px; padding:8px; background:#1e1e1e; border-radius:6px;'>
            <b>{$s['sensor_name']}</b> " . ($s['status']=='online'?'🟢':'🔴') . "<br>
            <small>
                Owner: {$s['homeowner_name']}<br>
                Block {$s['block']} - Lot {$s['lot']}<br>
                Location: Amaia Scapes
            </small>
        </div>
        ";
    }
    ?>

    </div>

    <div class="card">
    <h3>🎛️ Control</h3>

    <button class="btn" onclick="window.location.href='tel:911'">🚨 Emergency</button>
    <button class="btn" onclick="openModal()">➕ Add Sensor</button>
    <button class="btn" onclick="window.location.href='manage_sensors.php'">📡 Manage</button>
    <button class="btn" onclick="window.location.href='export_logs.php'">📤 Export</button>

    <button class="btn" style="background:red;" onclick="window.location.href='logout.php'">🚪 Logout</button>
</div>

</div>

</div>

<!-- SENSOR MODAL -->
<div id="sensorModal">
<div class="modal-box">

    <h3>➕ Add Sensor</h3>

    <form method="POST">

        <input name="sensor_name" placeholder="Sensor Name" required>
        <input name="homeowner_name" placeholder="Homeowner Name" required>
        <input name="block" placeholder="Block" required>
        <input name="lot" placeholder="Lot" required>
        <input name="house_area" placeholder="House Area" required>

        <input type="hidden" name="location_name" value="Amaia Scapes">

<div style="padding:10px; background:#1e1e1e; border:1px solid #444; border-radius:6px; text-align:center;">
    📍 Amaia Scapes (Fixed Location)
</div>

        <button class="btn" type="submit" name="add_sensor">💾 Save Sensor</button>
        <button class="btn" type="button" onclick="closeModal()" style="background:#555;">Cancel</button>

    </form>

</div>
</div>

<!-- MONTH MODAL -->
<div id="monthModal">
<div class="month-box">

<h3 style="text-align:center;">Select Month</h3>

<?php
for ($m=1;$m<=12;$m++){
    $name=date("F",mktime(0,0,0,$m,1));
    echo "<div class='month-item' onclick='selectMonth($m,\"$name\")'>$name</div>";
}
?>

<button class="btn" onclick="closeMonthModal()">Close</button>

</div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

var map = L.map('map').setView([10.7206,122.5630],17);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

/* MODALS */
function openModal(){ document.getElementById("sensorModal").style.display="flex"; }
function closeModal(){ document.getElementById("sensorModal").style.display="none"; }

function openMonthModal(){ document.getElementById("monthModal").style.display="flex"; }
function closeMonthModal(){ document.getElementById("monthModal").style.display="none"; }

/* CHART */
const monthlyData = <?= json_encode($monthlyData) ?>;

let chart = new Chart(document.getElementById('monthlyChart'), {
    type:'line',
    data:{ labels:[], datasets:[{ label:'Daily Incidents', data:[], borderWidth:2 }] }
});

function updateChart(month){
    let data = monthlyData[month] || [];
    let labels = data.map((_,i)=>i+1);

    chart.data.labels = labels;
    chart.data.datasets[0].data = data;
    chart.update();
}

function selectMonth(m,name){
    document.getElementById("selectedMonth").innerText = name;
    updateChart(m);
    closeMonthModal();
}

updateChart(new Date().getMonth()+1);

</script>

</body>
</html>