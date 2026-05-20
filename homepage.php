<?php
session_start();
require 'conn.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


$user_id = $_SESSION['user_id'];
$query = $conn->prepare("SELECT FULLNAME, EMAIL, CONTACT_NUM FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

$fullname = htmlspecialchars($user['FULLNAME']);
$email = htmlspecialchars($user['EMAIL']);
$contact = htmlspecialchars($user['CONTACT_NUM']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDS - Intrusion Detection System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            margin: 0;
            color: #fff;
        }
        .header {
            display: flex;
            align-items: center;
            padding: 20px;
            background-color: #222;
            position: relative;
            justify-content: space-between;
        }
        .header img {
            width: 100px;
        }
        .header h1 {
            font-size: 20px;
        }
        .container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            width: 80%;
            max-width: 1000px;
            margin: 30px auto;
        }
        .box {
            background-color: #222;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s;
            cursor: pointer;
            min-height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .box:hover {
            transform: translateY(-10px);
            background-color: #f57c00;
        }
        .box i {
            font-size: 40px;
            color: #FFA500;
            margin-bottom: 8px;
        }
        .box p { margin: 0; font-size: 16px; color: #fff; }
        button {
            width: 10%;
            padding: 12px;
            background-color: #FFA500;
            color: white;
            border: none;
            border-radius: 5px;
            margin-right: 100%;
            margin: 10px;
            cursor: pointer;
            font-size: 16px;
            box-sizing: border-box;
        }
        button:hover {
            background-color: #e87e00; 
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            overflow: auto;
            padding-top: 60px;
        }
        .modal-content {
            background-color: #222;
            margin: 5% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 800px;
            text-align: center;
            color: white;
            border: 2px solid #f57c00;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: #f57c00;
        }
        .modal h2 {
            margin-top: 0;
            color: #f57c00;
        }
        .modal p {
            font-size: 18px;
        }
        .sensor-status-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            color: white;
        }
        .sensor-status-table th, .sensor-status-table td {
            padding: 12px;
            text-align: left;
        }
        .sensor-status-table th {
            background-color: #444;
            border-radius: 8px;
        }
        .sensor-status-table tr {
            background-color: #222;
        }
        .sensor-status-table tr:hover {
            background-color: #333;
        }
        
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            margin-top: 15px; 
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            border-radius: 50%;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }
        .modal-center {
            text-align: center;
        }
        .profile-button-wrapper {
            text-align: center;
            margin-top: 8px;
        }
        .profile-button-wrapper .btn-inline {
            display: inline-block;
            margin: 0 6px;
            padding: 8px 14px;
            background: #FFA500;
            color: #fff;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .profile-button-wrapper .btn-inline:hover { background:#e87e00; }

        .settings-separator {
            width: 50%;
            height: 1px;
            background: #555;
            margin: 18px auto;
            border: none;
        }
        .hidden { display: none; }
        .left-nav {
    display: flex;
    align-items: center;
    gap: 20px;
    }

    .profile-dropdown {
        position: relative;
    }

    .profile-btn {
        background: none;
        border: none;
        color: #FFA500;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: bold;
        transition: color 0.3s;
    }

    .profile-btn:hover {
        color: #fff;
    }

    .profile-menu {
        display: none;
        position: absolute;
        top: 30px;
        left: 0;
        background-color: #222;
        border: 1px solid #444;
        border-radius: 8px;
        min-width: 160px;
        z-index: 10;
        box-shadow: 0px 4px 8px rgba(0,0,0,0.3);
    }

    .profile-menu a {
        display: block;
        padding: 10px 14px;
        color: #fff;
        text-decoration: none;
        font-size: 14px;
        transition: background 0.3s;
    }

    .profile-menu a:hover {
        background-color: #f57c00;
    }

    .profile-dropdown:hover .profile-menu {
        display: block;
    }

    </style>
</head>
<body>
    <div class="header">
        <div class="left-nav">
            <img src="img/logo2.png" alt="Logo">
            <div class="profile-dropdown">
                <button class="profile-btn">
                    <i class="fas fa-user-circle"></i> <?= $fullname ?>
                </button>
                <div class="profile-menu">
                    <hr>
                    <a href="profile.php"><i class="fas fa-id-badge"></i> View Profile</a>
                </div>
            </div>
        </div>
    <h1>Intrusion Detection Tracker</h1>
</div>

    
    <div class="container">
        <div class="box" onclick="openModal('dialModal')">
            <i class="fas fa-phone-alt"></i>
            <p>Dial</p>
        </div>
        <div class="box" onclick="openModal('motionHistoryModal')">
            <i class="fas fa-history"></i>
            <p>Motion History</p>
        </div>
        
        <div class="box" onclick="openModal('dashboardModal')">
            <i class="fas fa-chart-line"></i>
            <p>Dashboard</p>
        </div>
        <div class="box" onclick="openModal('settingsModal')">
            <i class="fas fa-cogs"></i>
            <p>Settings</p>
        </div>
        <div class="box" onclick="openModal('logOutModal')">
            <i class="fas fa-sign-out-alt"></i>
            <p>Log Out</p>
        </div>
    </div>
    <div id="motionAlertsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('motionAlertsModal')">&times;</span>
        </div>
    </div>

    <div id="dialModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('dialModal')">&times;</span>
            <span class="back-button" onclick="backToIntruderAlert()">&larr;</span>
            <h2>Dial</h2>
            <p>Enter a custom phone number:</p>
            <form action="dial_num.php" method="POST">
                <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="Enter phone number" required 
                    style="width: 80%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;">
                <button type="submit" class="modal-button">Call</button>
            </form>
            <button class="modal-button" style="margin-top:20px;" onclick="window.location.href='tel:911'">Call 911</button>
        </div>
    </div>
<div id="motionHistoryModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('motionHistoryModal')">&times;</span>
        <h2>Motion History</h2>
        <div style="max-height: 400px; overflow-y: auto; border-radius: 8px;">
            <table border="1" style="width: 100%; color: white; border-collapse: collapse;">
                <tr>
                    <th>ID</th>
                    <th>Location</th>
                    <th>Timestamp</th>
                    <th>Action</th>
                </tr>
                <tbody id="motionHistoryBody">
                    <?php
                    $conn = new mysqli("localhost", "root", "", "app_db");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                
                    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_id"])) {
                        $delete_id = intval($_POST["delete_id"]);
                        $conn->query("DELETE FROM motion_alerts WHERE id = $delete_id");
                        
                    }

            
                    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["clear_all"])) {
                        $conn->query("DELETE FROM motion_alerts");
                       
                    }

                    $sql = "SELECT id, location, timestamp FROM motion_alerts ORDER BY timestamp DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["id"] . "</td>
                                    <td>" . htmlspecialchars($row["location"]) . "</td>
                                    <td>" . $row["timestamp"] . "</td>
                                    <td style='text-align:center; vertical-align:middle;'>
                                        <form method='POST' style='margin:0;' onsubmit='return confirm(\"Delete this record?\");'>
                                            <input type='hidden' name='delete_id' value='" . $row["id"] . "'>
                                            <button type='submit' 
                                                style='background-color:#FF0000;color:white;padding:10px 45px;
                                                border:none;border-radius:6px;cursor:pointer;
                                                transition:background-color 0.3s;font-size:14px;display:flex;align-items:center;justify-content:center;margin:auto;'>
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No Motion Alerts</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>

        
            <form method="POST" style="text-align:center; margin-top:20px;" onsubmit="return confirm('Are you sure you want to delete all motion history?');">
                <button type="submit" name="clear_all" 
                    style="background-color:#FF0000;color:white;padding:10px 20px;
                    border:none;border-radius:8px;cursor:pointer;font-size:16px;">
                    Clear All
                </button>
            </form>
        </div>
    </div>
</div>

<?php
$conn = new mysqli("localhost", "root", "", "app_db");

$monthlyData = [];

$sql = "
    SELECT 
        DATE(timestamp) as day,
        DATE_FORMAT(timestamp, '%Y-%m') as month,
        COUNT(*) as total
    FROM motion_alerts
    GROUP BY day
    ORDER BY day ASC
";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $month = $row['month'];

    if (!isset($monthlyData[$month])) {
        $monthlyData[$month] = [];
    }

    $monthlyData[$month][] = [
        "day" => $row['day'],
        "total" => $row['total']
    ];
}

$conn->close();
?>

   <div id="dashboardModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('dashboardModal')">&times;</span>
        <h2>Dashboard</h2>

        
        <div id="chartsContainer"></div>

    </div>
</div>
</div>
    <div id="settingsModal" class="modal">
        <div class="modal-content modal-center">
            <span class="close" onclick="closeModal('settingsModal')">&times;</span>
            <h2>Settings</h2>

            <div class="profile-button-wrapper">
                <button class="btn-inline" id="sensorStatusBtn" onclick="toggleSensorStatus()">Sensor Status</button>
            </div>

            <hr class="settings-separator">


            <div id="sensorStatusPanel" class="hidden" style="text-align:left; margin-top:10px;">
                <h3 style="color:#f57c00; margin-bottom:6px;">Sensor Status</h3>
                <table class="sensor-status-table">
                    <thead>
                        <tr>
                            <th style="width:45%;">Sensor</th>
                            <th style="width:30%;">Status</th>
                            <th style="width:25%;">Last Response</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                
                        $conn = new mysqli("localhost", "root", "", "app_db");
                        if ($conn->connect_error) {
                            echo '<tr><td colspan="3" style="background:#c00; color:#fff; padding:12px; border-radius:8px;">Connection failed: '.htmlspecialchars($conn->connect_error).'</td></tr>';
                        } else {
                            $sensors = [
                                "PIR_LivingRoom" => "PIR Sensor (Living Room)"
                            ];
                            foreach ($sensors as $id => $name) {
                                $sql = "SELECT status, last_ping FROM sensor_status WHERE sensor='" . $conn->real_escape_string($id) . "'";
                                $result = $conn->query($sql);
                                if ($result && $row = $result->fetch_assoc()) {
                                    $status = htmlspecialchars($row['status']);
                                    $last_ping = $row['last_ping'];
                                    $last_response = "No Response";
                                    if ($last_ping) {
                                        try {
                                            $now = new DateTime();
                                            $ping = new DateTime($last_ping);
                                            $diff = $now->getTimestamp() - $ping->getTimestamp();
                                            $minutes = floor($diff / 60);
                                            $last_response = ($minutes < 1) ? "<span style='color:#0f0;'>Just now</span>" : "<span style='color:#FFA500;'>" . $minutes . " min ago</span>";
                                        } catch (Exception $e) {
                                            $last_response = htmlspecialchars($last_ping);
                                        }
                                    }
                                    $status_display = ($status == "online" || $status == "connected") ? "<span style='color:#0f0;font-weight:bold;'>🟢 " . $status . "</span>" : "<span style='color:#c00;font-weight:bold;'>🔴 Offline</span>";
                                    echo "<tr style='background-color:#222;'>
                                            <td style='padding:12px;'>" . htmlspecialchars($name) . "</td>
                                            <td style='padding:12px;'>" . $status_display . "</td>
                                            <td style='padding:12px;'>" . $last_response . "</td>
                                          </tr>";
                                } else {
                                    echo "<tr style='background-color:#222;'>
                                            <td style='padding:12px;'>" . htmlspecialchars($name) . "</td>
                                            <td style='padding:12px;'><span style='color:#c00;font-weight:bold;'>🔴 Offline</span></td>
                                            <td style='padding:12px;'>No Response</td>
                                          </tr>";
                                }
                            }
                            $conn->close();
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <hr class="settings-separator">

            <div style="text-align:center;">
            
                <label class="switch">
                    <input type="checkbox" id="sensorToggle" onchange="toggleSensor(this)">
                    <span class="slider"></span>
                </label>
                <p id="sensorStatusText" style="margin-top:10px;">Sensor is OFF</p>
            </div>
        </div>
    </div>
    <div id="logOutModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('logOutModal')">&times;</span>
            <h2>Log Out</h2>
            <p>Are you sure you want to log out?</p>
            <button><a href="login.php">Logout</a></button>
            <button><a href="homepage.php">Cancel</a></button>
        </div>
    </div>


    <div id="intruderAlertModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('intruderAlertModal')">&times;</span>
            <h2>🚨INTRUDER ALERT!🚨</h2>
            <p>New motion detected!</p>
            <p id="alertLocation"></p>  
            <p id="alertTimestamp"></p>
            <button class="modal-button" onclick="handleDialClick()">Dial</button>
        </div>
    </div>

    <script>
        let lastAlertId = null; 

        function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";


    if (modalId === 'dashboardModal') {
        setTimeout(loadChart, 300);
    }
}

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        function openOffcanvas() {
            document.getElementById('offcanvas').classList.add('open');
        }

        function fetchMotionAlerts() {
            fetch('motion_alerts.php')
                .then(response => response.json())
                .then(data => {
                    if (data.id && data.id !== lastAlertId) {
                        lastAlertId = data.id;
                        document.getElementById('alertLocation').innerText = 'Location: ' + data.location;
                        document.getElementById('alertTimestamp').innerText = 'Timestamp: ' + data.timestamp;
                        openModal('intruderAlertModal');
                        navigator.vibrate(200);
                    }
                })
                .catch(error => console.error('Error fetching alerts:', error));
        }

        function handleDialClick() {
            closeModal('intruderAlertModal');
            openModal('dialModal');
        }

        function handleDialFormSubmit(event) {
            event.preventDefault();
            const phoneNumber = document.getElementById('phoneNumber').value;
            if (phoneNumber) {
                window.location.href = `tel:${phoneNumber}`;
            } else {
                alert('Please enter a valid phone number.');
            }
        }

        function backToIntruderAlert() {
            closeModal('dialModal');
            openModal('intruderAlertModal');
        }
        function toggleSensor(checkbox) {
            const state = checkbox.checked ? 'on' : 'off';
            document.getElementById('sensorStatusText').innerText = 'Sensor is ' + state.toUpperCase();

            fetch('toggle_sensor.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'state=' + encodeURIComponent(state) + '&sensor=' + encodeURIComponent('PIR_LivingRoom')
            })
            .then(r => r.json())
            .then(j => console.log('toggle response', j))
            .catch(e => console.error('toggle error', e));
        }

        function toggleSensorStatus() {
            const panel = document.getElementById('sensorStatusPanel');
            const btn = document.getElementById('sensorStatusBtn');
            if (!panel) return;
            if (panel.classList.contains('hidden')) {
                panel.classList.remove('hidden');
                btn.innerText = 'Hide Sensor Status';
            } else {
                panel.classList.add('hidden');
                btn.innerText = 'Sensor Status';
            }
        }

        window.addEventListener('load', () => {
            fetch('get_sensor_state.php?sensor=PIR_LivingRoom')
                .then(response => response.json())
                .then(data => {
                    const checkbox = document.getElementById('sensorToggle');
                    const state = (data && data.state) ? data.state : 'off';
                    if (checkbox) checkbox.checked = (state === 'on');
                    const txt = document.getElementById('sensorStatusText');
                    if (txt) txt.innerText = 'Sensor is ' + state.toUpperCase();
                })
                .catch(err => console.error('Failed to get sensor state', err));
        });

        setInterval(fetchMotionAlerts, 3000);
        
        const motionData = <?php echo json_encode($monthlyData); ?>;

function loadChart() {
    const container = document.getElementById('chartsContainer');
    container.innerHTML = "";

    Object.keys(motionData).forEach(month => {

    
        const title = document.createElement('h3');
        title.innerText = "Month: " + month;
        title.style.color = "#FFA500";
        container.appendChild(title);

        
        const canvas = document.createElement('canvas');
        canvas.style.marginBottom = "40px";
        container.appendChild(canvas);

        const ctx = canvas.getContext('2d');

        let labels = [];
        let values = [];

        motionData[month].forEach(item => {
            labels.push(item.day);
            values.push(item.total);
        });
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Daily Motion Detection',
                    data: values,
                    borderWidth: 2,
                    fill: false,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: { color: 'white' }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: 'white' }
                    },
                    y: {
                        ticks: { color: 'white' },
                        beginAtZero: true
                    }
                }
            }
        });

    });
}
    </script>
</body>
</html>
