<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Online Car Sales Platform</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php" class="logo">
                <img src="Logo.png" alt="SpeedCar Logo" class="logo-img">
            </a>
            <ul class="nav-links">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="search.php">Find Cars</a></li>
                <li><a href="Register.php">Seller Register</a></li>
                <?php if (isset($_SESSION['seller_id'])): ?>
                    <li><a href="add-car.php">Add Car</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="Login.php">Seller Login</a></li>
                    <li><a href="add-car.php">Add Car</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h1>Professional Online Car Sales Platform</h1>
            <p>We provide convenient car listing services for sellers and accurate vehicle search functions for buyers. One-stop solution for all your car trading needs.</p>
            <a href="search.php" class="btn btn-small">Find Cars Now</a>
        </section>


        <section class="showcase-carousel" aria-label="Popular car examples">
            <div class="showcase-heading">
                <h2>Popular Car Examples</h2>
            </div>

            <div class="carousel-window">
                <div class="carousel-track">
                    <article class="showcase-item">
                        <img src="audi_a4_40tfsi.jpg" alt="Audi A4 40 TFSI">
                        <div class="showcase-item-info">
                            <span class="showcase-badge">Comfort Sedan</span>
                            <h3>Audi A4 40 TFSI</h3>
                            <p>A refined business sedan with balanced performance, modern lighting and a quiet cabin.</p>
                        </div>
                    </article>
                    <article class="showcase-item">
                        <img src="bmw_3series_320i.jpg" alt="BMW 3 Series 320i">
                        <div class="showcase-item-info">
                            <span class="showcase-badge">Sporty Choice</span>
                            <h3>BMW 3 Series 320i</h3>
                            <p>A dynamic daily car for drivers who want precise handling and a premium interior.</p>
                        </div>
                    </article>
                    <article class="showcase-item">
                        <img src="honda_civic.jpg" alt="Honda Civic Type R">
                        <div class="showcase-item-info">
                            <span class="showcase-badge">Performance</span>
                            <h3>Honda Civic Type R</h3>
                            <p>A sharp hatchback with a sporty look, strong acceleration and driver-focused design.</p>
                        </div>
                    </article>
                    <article class="showcase-item">
                        <img src="mercedes_c200.jpg" alt="Mercedes-Benz C200">
                        <div class="showcase-item-info">
                            <span class="showcase-badge">Luxury Sedan</span>
                            <h3>Mercedes-Benz C200</h3>
                            <p>A comfortable premium sedan with elegant styling and smooth long-distance cruising.</p>
                        </div>
                    </article>
                    <article class="showcase-item">
                        <img src="tesla_model3.jpg" alt="Tesla Model 3">
                        <div class="showcase-item-info">
                            <span class="showcase-badge">Electric</span>
                            <h3>Tesla Model 3</h3>
                            <p>An electric sedan with quick response, clean design and low running costs.</p>
                        </div>
                    </article>
                    <article class="showcase-item">
                        <img src="toyota_camry.jpg" alt="Toyota Camry">
                        <div class="showcase-item-info">
                            <span class="showcase-badge">Reliable</span>
                            <h3>Toyota Camry</h3>
                            <p>A practical family sedan known for comfort, reliability and everyday value.</p>
                        </div>
                    </article>

                    <article class="showcase-item" aria-hidden="true">
                        <img src="audi_a4_40tfsi.jpg" alt="">
                        <div class="showcase-item-info">
                            <span class="showcase-badge">Comfort Sedan</span>
                            <h3>Audi A4 40 TFSI</h3>
                            <p>A refined business sedan with balanced performance, modern lighting and a quiet cabin.</p>
                        </div>
                    </article>
                    <article class="showcase-item" aria-hidden="true">
                        <img src="bmw_3series_320i.jpg" alt="">
                        <div class="showcase-item-info">
                            <span class="showcase-badge">Sporty Choice</span>
                            <h3>BMW 3 Series 320i</h3>
                            <p>A dynamic daily car for drivers who want precise handling and a premium interior.</p>
                        </div>
                    </article>
                    <article class="showcase-item" aria-hidden="true">
                        <img src="honda_civic.jpg" alt="">
                        <div class="showcase-item-info">
                            <span class="showcase-badge">Performance</span>
                            <h3>Honda Civic Type R</h3>
                            <p>A sharp hatchback with a sporty look, strong acceleration and driver-focused design.</p>
                        </div>
                    </article>
                    <article class="showcase-item" aria-hidden="true">
                        <img src="mercedes_c200.jpg" alt="">
                        <div class="showcase-item-info">
                            <span class="showcase-badge">Luxury Sedan</span>
                            <h3>Mercedes-Benz C200</h3>
                            <p>A comfortable premium sedan with elegant styling and smooth long-distance cruising.</p>
                        </div>
                    </article>
                    <article class="showcase-item" aria-hidden="true">
                        <img src="tesla_model3.jpg" alt="">
                        <div class="showcase-item-info">
                            <span class="showcase-badge">Electric</span>
                            <h3>Tesla Model 3</h3>
                            <p>An electric sedan with quick response, clean design and low running costs.</p>
                        </div>
                    </article>
                    <article class="showcase-item" aria-hidden="true">
                        <img src="toyota_camry.jpg" alt="">
                        <div class="showcase-item-info">
                            <span class="showcase-badge">Reliable</span>
                            <h3>Toyota Camry</h3>
                            <p>A practical family sedan known for comfort, reliability and everyday value.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="feature-grid">
            <div class="card feature-card">
                <h3>Seller Exclusive Services</h3>
                <p>Register, login and publish car information with a real database.</p>
            </div>
            <div class="card feature-card">
                <h3>Accurate Search Function</h3>
                <p>Buyers can search cars by model, year and price range.</p>
            </div>
            <div class="card feature-card">
                <h3>Responsive Platform</h3>
                <p>The page layout still follows the original responsive design.</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Online Car Sales Platform. All rights reserved.</p>
    </footer>
</body>
</html>
