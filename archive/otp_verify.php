<?php
session_start();
require 'conn.php';  // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['EMAIL']);
    $password = $_POST['PASSWORD'];

    // Simple user validation (You should hash passwords in a real-world app)
    $sql = "SELECT * FROM users WHERE EMAIL = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Check password (use password_verify() in a real-world scenario)
        if ($password == $row['PASSWORD']) {
            // Generate OTP
            $otp = rand(100000, 999999); // 6-digit OTP
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_time'] = time();  // Record OTP generation time
            
            // Send OTP to the user's email
            $subject = "Your OTP Code";
            $message = "Your OTP code is: $otp";
            $headers = "From: your-email@example.com";  // Replace with your email address

            if (mail($email, $subject, $message, $headers)) {
                // Redirect to OTP verification page
                header("Location: verify_otp.php");
                exit;
            } else {
                $error_message = "Failed to send OTP email!";
            }
        } else {
            $error_message = "Incorrect password!";
        }
    } else {
        $error_message = "No user found with that email!";
    }
}

$conn->close();
?>