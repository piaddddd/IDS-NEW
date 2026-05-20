<?php
session_start();
$conn = new mysqli("localhost", "root", "", "app_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["EMAIL"];
    $password = $_POST["PASSWORD"];

    $sql = "SELECT * FROM users WHERE EMAIL = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();


    if ($row) {

        if (password_verify($password, $row["PASSWORD"])) {

            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $row["EMAIL"];
            $_SESSION["user_id"] = $row["ID"];
            $_SESSION["role"] = $row["role"];



            if ($row["role"] === "admin") {
                header("Location: admin_homepage.php");
                exit();
            } else {
                header("Location: homepage.php");
                exit();
            }

        } else {
            $error_message = "Invalid password.";
        }

    } else {
        $error_message = "Email not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        p {
            text-align: center;
        }
        a {
            color: #FFA500;
        }
        a:hover {
            color: #e87e00;
        }
        .error {
            color: #FFA500;
            font-size: 12px;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1><img src="img/logo2.png" alt="Logo" width="150"></h1>
    <h3>Login</h3>
    <form action="" method="post">
        <input type="email" name="EMAIL" placeholder="Email" required><br>
        <input type="password" name="PASSWORD" placeholder="Password" required><br>
        
        <?php if (!empty($error_message)): ?>
            <span class="error"><?php echo $error_message; ?></span><br>
        <?php endif; ?>
        
        <button type="submit">Login</button><br>
        <p>Don't have an account? <a href="signup.php">SIGN UP</a></p>
        <p><a href="forgot_password.php">Forgot Password?</a></p>
    </form>
</div>
</body>
</html>
