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
        <a href="index.php" class="logo"><img src="Logo.png" alt="SpeedCar Logo" class="logo-img"></a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="search.php">Find Cars</a></li>
            <li><a href="Register.php">Seller Register</a></li>
            <li><a href="Login.php" class="active">Seller Login</a></li>
        </ul>
    </nav>
</header>
<main>
    <h2 class="page-title">Seller Account Login</h2>
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
                <button type="submit" class="btn">Login</button>
            </form>
        </div>

        <div id="phone-login" class="login-form-panel">
            <p class="login-note">Phone login interface prepared. Code login will be added later.</p>
            <input type="text" id="loginPhone" placeholder="Phone number">
        </div>

        <div id="email-login" class="login-form-panel">
            <p class="login-note">Email login interface prepared. Code login will be added later.</p>
            <input type="email" id="loginEmail" placeholder="Email address">
        </div>
    </div>
</main>
<footer><p>&copy; 2026 Online Car Sales Platform. All rights reserved.</p></footer>
<script src="login.js"></script>
</body>
</html>
