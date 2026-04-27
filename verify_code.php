<?php
session_start();
$conn = new mysqli("localhost", "root", "", "app_db");

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $code = $_POST["code"];
    $email = $_SESSION["reset_email"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND reset_code=?");
    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: reset_password.php");
        exit();
    } else {
        $error = "Invalid code.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Verify Code</title>
<style>
body {background:#121212;color:white;display:flex;justify-content:center;align-items:center;height:100vh;font-family:Arial;}
.box {background:#1e1e1e;padding:20px;width:300px;border-radius:10px;}
input,button {width:100%;padding:10px;margin-top:10px;}
button {background:orange;border:none;}
</style>
</head>
<body>

<div class="box">
    <h3>Enter Verification Code</h3>

    <form method="POST">
        <input type="text" name="code" placeholder="6-digit code" required>
        <button type="submit">Verify</button>
    </form>

    <p style="color:orange;"><?php echo $error; ?></p>
</div>

</body>
</html>