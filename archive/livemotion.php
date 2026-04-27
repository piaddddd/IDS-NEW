<?php
// livemotion.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Motion Detection</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            color: #fff;
            justify-content: center;
            padding: 20px;
        }
        .box {
            background-color: #222;
            border-radius: 10px;
            width:300px;
            padding: 20px;
            text-align: center;
            color: #fff;
        }
        .box i {
            font-size: 40px;
            color: #f57c00;
        }
        .box p {
            font-size: 16px;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="box">
    <i class="fas fa-eye"></i>
    <p>Live Motion Detection</p>
    <p>Status: <span id="status">Checking...</span></p>
    <p>Last detected motion: <span id="lastDetection">None</span></p>
</div>

<script>
    // Simulating real-time motion detection
    setTimeout(() => {
        document.getElementById('status').innerText = "Motion Detected!";
        document.getElementById('lastDetection').innerText = new Date().toLocaleString();
    }, 3000); // Simulating motion detection after 3 seconds
</script>

</body>
</html>
