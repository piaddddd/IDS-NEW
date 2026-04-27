<?php
session_start();
$conn = new mysqli("localhost", "root", "", "app_db");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = $_SESSION["reset_email"];

    $stmt = $conn->prepare("UPDATE users SET password=?, reset_code=NULL WHERE email=?");
    $stmt->bind_param("ss", $password, $email);
    $stmt->execute();

    session_destroy();

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<style>
body {background:#121212;color:white;display:flex;justify-content:center;align-items:center;height:100vh;font-family:Arial;}
.box {background:#1e1e1e;padding:20px;width:300px;border-radius:10px;}
input,button {width:100%;padding:10px;margin-top:10px;}
button {background:orange;border:none;}
</style>
</head>
<body>

<div class="box">
    <h3>Reset Password</h3>

    <form method="POST">
        <input type="password" name="password" placeholder="New Password" required>
        <button type="submit">Reset</button>
    </form>
</div>

</body>
</html>