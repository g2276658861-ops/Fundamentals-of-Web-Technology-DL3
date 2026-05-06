<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Cars - Online Car Sales Platform</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <nav>
        <a href="index.php" class="logo"><img src="Logo.png" alt="SpeedCar Logo" class="logo-img"></a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="search.php" class="active">Find Cars</a></li>
            <li><a href="Register.php">Seller Register</a></li>
            <li><a href="Login.php">Seller Login</a></li>
        </ul>
    </nav>
</header>
<main>
    <h2 class="page-title">Search for Your Ideal Vehicle</h2>
    <div class="card">
        <form id="searchForm" class="search-form" method="GET" action="search.php">
            <div class="form-group"><input type="text" name="model" id="searchModel" placeholder="Enter car model"></div>
            <div class="form-group"><input type="number" name="year" id="searchYear" min="1990" max="2026" placeholder="Enter registration year"></div>
            <button type="submit" class="btn">Search</button>
        </form>
    </div>
    <h3 class="list-title">Vehicle List</h3>
    <div class="car-list" id="carList">
        <div class="empty-result">Search result area prepared. Database results will be added next.</div>
    </div>
</main>
<footer><p>&copy; 2026 Online Car Sales Platform. All rights reserved.</p></footer>
</body>
</html>
