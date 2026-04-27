<?php
require 'vendor/autoload.php'; // Twilio SDK
use Twilio\Rest\Client;

require 'conn.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $fullname = $_POST['FULLNAME'];
    $email = $_POST['EMAIL'];
    $contact_num = $_POST['CONTACT_NUM'];
    $password = $_POST['PASSWORD'];

    // Generate OTP
    $otp = rand(100000, 999999);

    // Store OTP in session
    session_start();
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;

    // Send OTP to user's phone using Twilio
    $sid = 'your_twilio_sid'; // Your Twilio SID
    $token = 'your_twilio_auth_token'; // Your Twilio Auth Token
    $from = 'your_twilio_phone_number'; // Your Twilio phone number
    $to = '+1' . $contact_num; // The phone number to send OTP to (make sure it's in the correct format)

    $client = new Client($sid, $token);
    try {
        $message = $client->messages->create(
            $to,
            [
                'from' => $from,
                'body' => "Your OTP is: $otp"
            ]
        );

        // Redirect to OTP verification page
        header("Location: otp_verification.php");
        exit;
    } catch (Exception $e) {
        // Handle error
        echo "Error: " . $e->getMessage();
    }
}
?>
