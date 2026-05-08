<?php
session_start();
require_once 'db_connect.php';
require_once 'helpers.php';

$model = trim($_GET['model'] ?? '');
$year = trim($_GET['year'] ?? '');

$sql = 'SELECT c.car_id, c.color, c.model, c.year, c.location, c.price, c.image, c.description, s.username
        FROM cars c
        JOIN sellers s ON c.seller_id = s.seller_id
        WHERE 1=1';
$params = [];
$types = '';

if ($model !== '') {
    $sql .= ' AND c.model LIKE ?';
    $params[] = '%' . $model . '%';
    $types .= 's';
}

if ($year !== '') {
    $sql .= ' AND c.year = ?';
    $params[] = (int)$year;
    $types .= 'i';
}

$sql .= ' ORDER BY c.created_at DESC';
$stmt = $conn->prepare($sql);
if ($types !== '') {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$cars = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
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
            <li><a href="add-car.php">Add Car</a></li>
        </ul>
    </nav>
</header>
<main>
    <h2 class="page-title">Search for Your Ideal Vehicle</h2>
    <div class="card">
        <form id="searchForm" class="search-form" method="GET" action="search.php">
            <div class="form-group"><input type="text" name="model" id="searchModel" value="<?php echo h($model); ?>" placeholder="Enter car model"></div>
            <div class="form-group"><input type="number" name="year" id="searchYear" min="1990" max="2026" value="<?php echo h($year); ?>" placeholder="Enter registration year"></div>
            <button type="submit" class="btn">Search</button>
        </form>
    </div>
    <h3 class="list-title">Vehicle List</h3>
    <div class="car-list" id="carList">
        <?php if (count($cars) === 0): ?>
            <div class="empty-result">No matching vehicle information available.</div>
        <?php else: ?>
            <?php foreach ($cars as $car): ?>
                <div class="car-item">
                    <img src="<?php echo h($car['image']); ?>" alt="<?php echo h($car['model']); ?>">
                    <div class="car-info">
                        <h4><?php echo h($car['model']); ?> <?php echo h($car['year']); ?></h4>
                        <p class="car-price">¥<?php echo number_format((float)$car['price']); ?></p>
                        <p class="car-meta">Color: <?php echo h($car['color']); ?> | Location: <?php echo h($car['location']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>
<footer><p>&copy; 2026 Online Car Sales Platform. All rights reserved.</p></footer>
</body>
</html>
