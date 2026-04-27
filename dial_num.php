<?php
// filepath: c:\xampp\htdocs\Main-CybroX\dial_num.php

// Database connection
$conn = new mysqli("localhost", "root", "", "app_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phoneNumber = $_POST['phoneNumber'];

    // Validate the phone number
    if (preg_match('/^\+?[0-9]{10,15}$/', $phoneNumber)) {
        // Insert the phone number into the database
        $stmt = $conn->prepare("INSERT INTO dial_num (phone_number, timestamp) VALUES (?, NOW())");
        $stmt->bind_param("s", $phoneNumber);

        if ($stmt->execute()) {
            // Redirect to the tel: link to initiate the call
            header("Location: tel:$phoneNumber");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid phone number.";
    }
}

$conn->close();
?>