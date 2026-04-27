<?php 
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['FULLNAME']);
    $email = mysqli_real_escape_string($conn, $_POST['EMAIL']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['CONTACT_NUM']);
    $pass = $_POST['PASSWORD'];
    $confirm_pass = $_POST['CONFIRM_PASSWORD'];

    // Initialize error messages
    $password_error = '';
    $contact_number_error = '';

    // Validate password length
    if (strlen($pass) < 8) {
        $password_error = "Password must be at least 8 characters long.";
    }

    // Validate password match
    if ($pass !== $confirm_pass) {
        $password_error = "Passwords do not match!";
    }

    // Validate contact number format
    if (!preg_match("/^09\d{9}$/", $contact_number)) {
        $contact_number_error = "Contact number must start with '09' and contain 11 digits.";
    }

    // Stop if there are validation errors
    if ($password_error || $contact_number_error) {
        echo json_encode([
            'password_error' => $password_error,
            'contact_number_error' => $contact_number_error
        ]);
        exit;
    }

    // Check for duplicate email
    $sql = "SELECT * FROM users WHERE EMAIL = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: signup.php?error=email_taken");
        exit;
    }

    // ✅ Hash only the password
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Insert the new user (contact number stays as plain text)
    $stmt = $conn->prepare("INSERT INTO users (FULLNAME, EMAIL, CONTACT_NUM, PASSWORD) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $contact_number, $hashed_password);

    if ($stmt->execute()) {
        header("Location: login.php?signup=success");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
