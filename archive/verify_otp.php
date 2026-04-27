<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entered_otp = $_POST['otp'];

    // Check if OTP is correct and not expired
    if (isset($_SESSION['otp']) && $_SESSION['otp'] == $entered_otp) {
        // Check if OTP is expired (valid for 5 minutes)
        if (time() - $_SESSION['otp_time'] <= 300) {
            // OTP is valid, user can proceed
            echo "OTP verified successfully!";
            // You can redirect to the next page or perform further actions
        } else {
            echo "OTP expired! Please request a new one.";
        }
    } else {
        echo "Invalid OTP!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
                body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 300px;
            padding: 20px;
            background-color: #1e1e1e;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        h1 {
            text-align: center;
            color: #FFA500;
        }
        h3 {
            text-align: center;
            color: #FFA500;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #FFA500;
            border-radius: 5px;
            background-color: #2a2a2a;
            color: white;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #FFA500;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            box-sizing: border-box;
        }
        button:hover {
            background-color: #e87e00;
        }
        .error {
            color: #FFA500;
            font-size: 14px;
            display: block;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>OTP Verification</h1>
    <form action="verify_otp.php" method="post">
        <input type="text" name="otp" placeholder="Enter OTP" required><br>
        <button type="submit">Verify OTP</button><br>
    </form>
</div>
</body>
</html>
