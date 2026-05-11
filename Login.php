<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Login - Online Car Sales Platform</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php" class="logo">
                <img src="Logo.png" alt="SpeedCar Logo" class="logo-img">
            </a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="search.php">Find Cars</a></li>
                <li><a href="Register.php">Seller Register</a></li>
                <li><a href="Login.php" class="active">Seller Login</a></li>
                <li><a href="add-car.php">Add Car</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2 class="page-title">Seller Account Login</h2>

        <?php if (isset($_GET['registered'])): ?>
            <div class="alert alert-success">Registration successful. Please login with your new account.</div>
        <?php endif; ?>

        <?php if (isset($_GET['logout'])): ?>
            <div class="alert alert-success">You have logged out.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <?php
                if ($_GET['error'] === 'wrong') {
                    echo 'Invalid username or password.';
                } elseif ($_GET['error'] === 'need_login') {
                    echo 'Please login before adding a car.';
                } else {
                    echo 'Login failed. Please try again.';
                }
                ?>
            </div>
        <?php endif; ?>

        <div class="card form-card">
            <div class="login-tabs">
                <div class="login-tab active" data-target="password-login">Password</div>
                <div class="login-tab" data-target="phone-login">Phone</div>
                <div class="login-tab" data-target="email-login">Email</div>
            </div>

            <div id="password-login" class="login-form-panel active">
                <form id="loginFormPassword" action="login_process.php" method="POST">
                    <div class="form-group">
                        <label for="loginUsername">Username</label>
                        <input type="text" id="loginUsername" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="loginPassword">Password</label>
                        <input type="password" id="loginPassword" name="password" required>
                    </div>

                    <p class="error-text" id="loginPasswordError"></p>
                    <button type="submit" class="btn">Login</button>
                    <p class="register-link">
                        Don't have an account? <a href="Register.php">Register now</a>
                    </p>
                </form>
            </div>

            <div id="phone-login" class="login-form-panel">
                <p class="login-note">After phone verification, the seller will enter the add car page directly.</p>
                <form id="loginFormPhone">
                    <div class="form-group">
                        <label for="loginPhone">Phone Number</label>
                        <input type="text" id="loginPhone" placeholder="e.g., 13800138000" required>
                        <p class="error-text" id="loginPhoneError">Please enter a valid phone number</p>
                    </div>
                    <div class="form-group">
                        <label for="loginPhoneCode">Verification Code</label>
                        <input type="text" id="loginPhoneCode" placeholder="Enter verification code" required>
                        <p class="error-text" id="loginPhoneCodeError"></p>
                    </div>
                    <button type="button" class="btn btn-small" id="sendPhoneCodeBtn">Get Code</button>
                    <button type="submit" class="btn" style="margin-top:1rem;">Login with Phone</button>
                </form>
            </div>

            <div id="email-login" class="login-form-panel">
                <p class="login-note">After email verification, the seller will enter the add car page directly.</p>
                <form id="loginFormEmail">
                    <div class="form-group">
                        <label for="loginEmail">Email Address</label>
                        <input type="email" id="loginEmail" placeholder="e.g., name@example.com" required>
                        <p class="error-text" id="loginEmailError">Please enter a valid email address</p>
                    </div>
                    <div class="form-group">
                        <label for="loginEmailCode">Verification Code</label>
                        <input type="text" id="loginEmailCode" placeholder="Enter verification code" required>
                        <p class="error-text" id="loginEmailCodeError"></p>
                    </div>
                    <button type="button" class="btn btn-small" id="sendEmailCodeBtn">Get Code</button>
                    <button type="submit" class="btn" style="margin-top:1rem;">Login with Email</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Online Car Sales Platform. All rights reserved.</p>
    </footer>
    <script src="login.js"></script>
</body>
</html>
