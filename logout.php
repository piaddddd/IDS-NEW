<?php
session_start();

// If user clicks YES (confirm logout)
if (isset($_POST['confirm_logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// If user clicks NO (cancel logout)
if (isset($_POST['cancel_logout'])) {
    header("Location: admin_homepage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Logout Confirmation</title>

<style>
body {
    font-family: Arial;
    background: #121212;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.box {
    background: #1e1e1e;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    width: 300px;
}

button {
    padding: 10px 15px;
    margin: 10px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.yes {
    background: red;
    color: white;
}

.no {
    background: gray;
    color: white;
}
</style>
</head>

<body>

<div class="box">
    <h3>Are you sure you want to logout?</h3>

    <form method="POST">
        <button class="yes" type="submit" name="confirm_logout">Yes, Logout</button>
        <button class="no" type="submit" name="cancel_logout">No, Stay</button>
    </form>
</div>

</body>
</html>