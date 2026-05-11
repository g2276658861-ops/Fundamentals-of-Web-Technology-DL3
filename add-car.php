<?php
require_once 'auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Car - Online Car Sales Platform</title>
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
                <li><a href="add-car.php" class="active">List Car</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2 class="page-title">List Car Information</h2>

        <div class="seller-bar">
            <span>Logged in as <strong><?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></strong></span>
            <a href="logout.php" class="btn btn-small">Logout</a>
        </div>

        <?php if (isset($_GET['login'])): ?>
            <div class="alert alert-success">Login successful. You can add a car now.</div>
        <?php endif; ?>

        <?php if (isset($_GET['added'])): ?>
            <div class="alert alert-success">Car listed successfully. The search page can now read it from the database.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">Please check the car details and try again.</div>
        <?php endif; ?>

        <div class="card form-card">
            <form id="addCarForm" action="add_car_process.php" method="POST" novalidate>
                <div class="form-group">
                    <label for="carColor">Body Color</label>
                    <input type="text" id="carColor" name="color" required>
                </div>

                <div class="form-group">
                    <label for="carModel">Car Model</label>
                    <input type="text" id="carModel" name="model" required>
                </div>

                <div class="form-group">
                    <label for="carYear">Registration Year</label>
                    <input type="number" id="carYear" name="year" min="1990" max="2026" required>
                </div>

                <div class="form-group">
                    <label for="carLocation">Car Location</label>
                    <input type="text" id="carLocation" name="location" required>
                </div>

                <div class="form-group">
                    <label for="carPrice">Price (CNY)</label>
                    <input type="number" id="carPrice" name="price" min="0" required>
                </div>

                <div class="form-group">
                    <label for="carImage">Car Image URL or File Name</label>
                    <input type="text" id="carImage" name="image" required placeholder="Example: Tesla_Model3.png or https://...">
                </div>

                <div class="form-group">
                    <label for="carDescription">Description</label>
                    <textarea id="carDescription" name="description" rows="4" placeholder="Add some basic information about the car"></textarea>
                </div>

                <p class="success-text" id="carSuccess">Car form looks ready.</p>
                <button type="submit" class="btn">Publish Car Information</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Online Car Sales Platform. All rights reserved.</p>
    </footer>
    <script src="addCar.js"></script>
</body>
</html>
