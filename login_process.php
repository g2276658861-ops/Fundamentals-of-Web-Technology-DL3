<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Login.php');
    exit();
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

$stmt = $conn->prepare('SELECT seller_id, username, password_hash FROM sellers WHERE username = ? LIMIT 1');
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$seller = $result->fetch_assoc();
$stmt->close();

if ($seller && password_verify($password, $seller['password_hash'])) {
    $_SESSION['seller_id'] = $seller['seller_id'];
    $_SESSION['username'] = $seller['username'];
    header('Location: add-car.php?login=1');
    exit();
}

header('Location: Login.php?error=wrong');
exit();
?>
