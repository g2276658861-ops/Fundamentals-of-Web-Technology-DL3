<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Register - Online Car Sales Platform</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <nav>
        <a href="index.php" class="logo"><img src="Logo.png" alt="SpeedCar Logo" class="logo-img"></a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="search.php">Find Cars</a></li>
            <li><a href="Register.php" class="active">Seller Register</a></li>
            <li><a href="Login.php">Seller Login</a></li>
        </ul>
    </nav>
</header>

<main>
    <h2 class="page-title">Seller Account Registration</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">
            <?php
            if ($_GET['error'] === 'duplicate') {
                echo 'This username, email, or phone number has already been used.';
            } elseif ($_GET['error'] === 'invalid') {
                echo 'Please check the form details and try again.';
            } else {
                echo 'Registration failed. Please try again.';
            }
            ?>
        </div>
    <?php endif; ?>
    <div class="card form-card">
        <form id="registerForm" action="register_process.php" method="POST" novalidate>
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
                <p class="error-text" id="nameError">Only letters and spaces are allowed</p>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
                <p class="error-text" id="addressError">Only letters, numbers and spaces are allowed</p>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" required>
                <p class="error-text" id="phoneError">Please enter a valid Chinese mainland phone number</p>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
                <p class="error-text" id="emailError">Please enter a valid email address</p>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
                <p class="error-text" id="usernameError">At least 6 characters, letters and numbers only</p>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <p class="error-text" id="passwordError">At least 6 characters, letters and numbers only</p>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <p class="error-text" id="confirmPasswordError">Passwords must match</p>
            </div>
            <p class="success-text" id="registerSuccess">Form looks good. Submitting to server...</p>
            <button type="submit" class="btn">Complete Registration</button>
        </form>
    </div>
</main>
<footer><p>&copy; 2026 Online Car Sales Platform. All rights reserved.</p></footer>
<script type="module" src="validateRegisterForm.js"></script>
</body>
</html>
