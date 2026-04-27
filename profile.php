<?php
session_start();
require 'conn.php'; // ✅ Connect to DB

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch latest user info
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT FULLNAME, EMAIL, CONTACT_NUM FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $fullname = htmlspecialchars($user['FULLNAME']);
    $email = htmlspecialchars($user['EMAIL']);
    $contact = htmlspecialchars($user['CONTACT_NUM']);
} else {
    $fullname = "Unknown User";
    $email = "N/A";
    $contact = "N/A";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | IDS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .profile-container {
            width: 400px;
            margin: 80px auto;
            padding: 30px;
            background-color: #1e1e1e;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            text-align: center;
        }
        h1 {
            color: #FFA500;
            margin-bottom: 20px;
        }
        .profile-info {
            text-align: left;
            margin-top: 20px;
        }
        .profile-info p {
            font-size: 16px;
            margin: 10px 0;
        }
        .profile-info i {
            color: #FFA500;
            margin-right: 10px;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #FFA500;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .btn:hover {
            background-color: #e87e00;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1><i class="fas fa-id-badge"></i> Profile</h1>
        <div class="profile-info">
            <p><i class="fas fa-user"></i> <strong>Full Name:</strong> <?= $fullname ?></p>
            <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <?= $email ?></p>
            <p><i class="fas fa-phone"></i> <strong>Contact:</strong> <?= $contact ?></p>
        </div>
        <a href="homepage.php" class="btn"><i class="fas fa-home"></i> Back to Homepage</a>
    </div>
</body>
</html>
