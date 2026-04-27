<?php
session_start();
$conn = new mysqli("localhost", "root", "", "app_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"];

    // check if email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {

        // generate OTP
        $code = rand(100000, 999999);

        // store session
        $_SESSION["reset_email"] = $email;

        // save code to DB
        $stmt2 = $conn->prepare("UPDATE users SET reset_code = ? WHERE email = ?");
        $stmt2->bind_param("ss", $code, $email);
        $stmt2->execute();

        // send email via PHPMailer
        require 'send_mail.php';
        $sent = sendOTP($email, $code);

        if ($sent) {
            header("Location: verify_code.php");
            exit();
        } else {
            $message = "Failed to send email. Please try again.";
        }

    } else {
        $message = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: #121212;
    color: white;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    box-sizing: border-box;
}

/* CARD */
.box {
    background: #1e1e1e;
    padding: 25px;
    width: 100%;
    max-width: 360px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 0 10px rgba(0,0,0,0.5);
}

h2 {
    color: orange;
    margin-bottom: 20px;
}

/* INPUT */
input {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    border: 1px solid #444;
    border-radius: 6px;
    background: #2a2a2a;
    color: white;
    box-sizing: border-box;
}

/* BUTTON */
button {
    width: 100%;
    padding: 12px;
    margin-top: 15px;
    background: orange;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}

button:hover {
    background: #ffb84d;
}

/* MESSAGE */
.msg {
    margin-top: 10px;
    color: #ffb84d;
    font-size: 13px;
}

.back-arrow {
    position: absolute;
    top: 12px;
    left: 12px;
    width: 38px;
    height: 38px;
    background: #2a2a2a;
    color: orange;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    text-decoration: none;
    font-size: 18px;
    border: 1px solid #444;
    transition: 0.2s;
}

.back-arrow:hover {
    background: orange;
    color: black;
}

/* MOBILE FIX */
@media (max-width: 480px) {
    .box {
        padding: 20px;
        max-width: 100%;
    }

    h2 {
        font-size: 20px;
    }

    input, button {
        font-size: 14px;
        padding: 10px;
    }
}
</style>

</head>
<body>
   
<div class="box">
     <a href="login.php" class="back-arrow">←</a>


    <h2>Forgot Password</h2>

    <form method="POST">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Send Code</button>
    </form>

    <?php if (!empty($message)): ?>
        <div class="msg"><?php echo $message; ?></div>
    <?php endif; ?>

</div>

</body>
</html>