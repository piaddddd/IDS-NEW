<?php
// Require the bundled autoload file - the path may need to change
// based on where you downloaded and unzipped the SDK
require 'SMS/twilio-php-main/src/Twilio/autoload.php';

// Your Account SID and Auth Token from console.twilio.com
$sid = "ACe956bde8c8f25b4ee2249d03f460f4d6";
$token = "0abe28322d7de966a9bd0ca653d118c6";
$client = new Twilio\Rest\Client($sid, $token);

// Use the Client to make requests to the Twilio REST API
$client->messages->create(
    // The number you'd like to send the message to
    '+639307739814',
    [
        // A Twilio phone number you purchased at https://console.twilio.com
        'from' => '+639700974537',
        // The body of the text message you'd like to send
        'body' => "Hey Jenny! Good luck on the bar exam!"
    ]
);