<?php
session_start();

// OPTIONAL SECURITY
// if ($_SESSION["email"] !== "admin@system.com") {
//     header("Location: login.php");
//     exit;
// }
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    margin:0;
    font-family:Arial;
    background:#1e1e1e;
    color:white;
}

.header {
    padding:15px;
    background:#111;
    color:orange;
    text-align:center;
}

.grid {
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

button {
    background:orange;
    border:none;
    padding:10px;
    margin:5px;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="header">
    🛡️ ADMIN DASHBOARD
</div>

<div class="grid">

    <div>

        <div class="card">
            <h3>📊 Weekly Chart</h3>
            <canvas id="chart"></canvas>
        </div>

        <div class="card">
            <h3>📍 Live Map (Placeholder)</h3>
            <p>Amaia Scapes Location Tracker Here</p>
        </div>

    </div>

    <div>

        <div class="card">
            <h3>📡 Recent Alerts</h3>
            <p>No data yet</p>
        </div>

        <div class="card">
            <h3>⚙️ Control Panel</h3>

            <button onclick="location.href='tel:911'">Dial Emergency</button>
            <button>System Settings</button>
            <button>Add Sensor</button>
            <button>Export Logs</button>
        </div>

    </div>

</div>

<script>
const ctx = document.getElementById('chart');

new Chart(ctx, {
    type:'line',
    data:{
        labels:['Mon','Tue','Wed','Thu','Fri'],
        datasets:[{
            label:'Incidents',
            data:[2,4,3,5,1]
        }]
    }
});
</script>

</body>
</html>