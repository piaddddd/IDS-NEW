<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
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
        hr {
            border: 1px solid #FFA500;
            margin: 20px 0;
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
            display: none;
        }
        .email-error {
            color: #FFA500;
            font-size: 12px;
            display: block;
        }
    </style>
</head>
<body>
<div class="container">

    <h1><img src="img/logo2.png" alt="Logo" width="150"></h1>
    <h3>Sign Up</h3>
    <form action="signup_process.php" method="post" onsubmit="return validatePassword() && validateContactNumber()">
        <input type="text" name="FULLNAME" placeholder="Fullname" required><br>
        <input type="email" name="EMAIL" placeholder="Email" required><br>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'email_taken'): ?>
            <span class="email-error">Email is already taken! Please use a different one.</span><br>
        <?php endif; ?>

        <input type="text" name="CONTACT_NUM" maxlength="11" placeholder="Contact Number" required>
        
        <span id="contactNumberError" class="error"></span><br>

        <input type="password" name="PASSWORD" placeholder="Password" required><br>
        <input type="password" name="CONFIRM_PASSWORD" placeholder="Confirm Password" required>
        <span id="passwordError" class="error">Passwords do not match!</span>
        <span id="passwordLengthError" class="error">Password must be at least 8 characters long.</span><br>

        <button type="submit">Sign Up</button><br>
        <p>Already have an account? <a href="login.php">LOGIN</a></p>
    </form>
</div>

<script>
    function validatePassword() {
        var password = document.querySelector('[name="PASSWORD"]').value;
        var confirmPassword = document.querySelector('[name="CONFIRM_PASSWORD"]').value;
        var passwordError = document.getElementById('passwordError');
        var passwordLengthError = document.getElementById('passwordLengthError');

        if (password !== confirmPassword) {
            passwordError.style.display = 'block';
            return false;
        } else {
            passwordError.style.display = 'none';
        }
        if (password.length < 8) {
            passwordLengthError.style.display = 'block';
            return false;
        } else {
            passwordLengthError.style.display = 'none';
        }

        return true;
    }

    function validateContactNumber() {
        var contactNumber = document.querySelector('[name="CONTACT_NUM"]').value;
        var contactNumberError = document.getElementById('contactNumberError');
        
        var regex = /^09\d{9}$/;
        if (!regex.test(contactNumber)) {
            contactNumberError.textContent = "Contact number must start with '09' and contain 11 digits.";
            contactNumberError.style.display = 'block';
            return false;
        } else {
            contactNumberError.style.display = 'none';
        }

        return true;
    }
</script>

</body>
</html>
