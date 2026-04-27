<?php
session_start();
require 'conn.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>Settings</title>
<style>
body { background:#121212; color:white; font-family:Arial; }
.box { padding:20px; }
input { padding:10px; margin:5px; width:100%; }
button { padding:10px; background:orange; border:none; }
</style>
</head>

<body>
<div class="box">
    <h2>⚙️ System Settings</h2>

    <form>
        <label>Emergency Contact</label>
        <input type="text" placeholder="911"><br>

        <label>System Name</label>
        <input type="text" value="Intrusion Detection System"><br>

        <button>Save Settings</button>
    </form>
</div>
</body>
</html>