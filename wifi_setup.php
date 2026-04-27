<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sensor WiFi Setup</title>

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
    font-size: 20px;
    color: orange;
}

/* CENTER CONTAINER */
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 90vh;
}

/* FORM BOX */
.box {
    background: #2a2a2a;
    padding: 25px;
    border-radius: 10px;
    width: 350px;
    text-align: center;
    box-shadow: 0 0 10px rgba(0,0,0,0.5);
}

h2 {
    color: orange;
    margin-bottom: 20px;
}

/* INPUTS */
input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #444;
    border-radius: 6px;
    background: #1e1e1e;
    color: white;
    outline: none;
}

input:focus {
    border-color: orange;
}

/* BUTTON */
button {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    background: orange;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}

button:hover {
    background: #ffb84d;
}

/* SMALL TEXT */
.note {
    font-size: 12px;
    color: #aaa;
    margin-top: 10px;
}
</style>

</head>

<body>

<div class="header">
    🔧 SENSOR NETWORK SETUP
</div>

<div class="container">

    <div class="box">

        <h2>Connect Sensor to WiFi</h2>

        <form method="POST" action="send_to_esp32.php">

            <input type="text" name="ssid" placeholder="WiFi Name (SSID)" required>

            <input type="password" name="password" placeholder="WiFi Password" required>

            <button type="submit">Connect Sensor</button>

        </form>

    </div>

</div>

</body>
</html>