<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: add-car.php');
    exit();
}

$seller_id = $_SESSION['seller_id'];
$color = trim($_POST['color'] ?? '');
$model = trim($_POST['model'] ?? '');
$year = (int)($_POST['year'] ?? 0);
$location = trim($_POST['location'] ?? '');
$price = (float)($_POST['price'] ?? 0);
$image = trim($_POST['image'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($color === '' || $model === '' || $location === '' || $image === '' || $year < 1990 || $year > 2026 || $price <= 0) {
    header('Location: add-car.php?error=invalid');
    exit();
}

$stmt = $conn->prepare('INSERT INTO cars (seller_id, color, model, year, location, price, image, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
$stmt->bind_param('issisdss', $seller_id, $color, $model, $year, $location, $price, $image, $description);

if ($stmt->execute()) {
    $stmt->close();
    header('Location: add-car.php?added=1');
    exit();
}

$stmt->close();
header('Location: add-car.php?error=server');
exit();
?>
