<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Register.php');
    exit();
}

$name = trim($_POST['name'] ?? '');
$address = trim($_POST['address'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$confirm_password = trim($_POST['confirm_password'] ?? '');
$email_verified = $_POST['email_verified'] ?? '0';
$phone_verified = $_POST['phone_verified'] ?? '0';

$valid = $name !== '' && $address !== '' && $phone !== '' && $email !== '' && $username !== '' && $password !== '';
$valid = $valid && ($password === $confirm_password);
$valid = $valid && ($email_verified === '1') && ($phone_verified === '1');
$valid = $valid && preg_match('/^[\p{L}\s]+$/u', $name);
$valid = $valid && preg_match('/^[\p{L}\p{N}\s,.-]+$/u', $address);
$valid = $valid && preg_match('/^1[3-9]\d{9}$/', $phone);
$valid = $valid && filter_var($email, FILTER_VALIDATE_EMAIL);
$valid = $valid && preg_match('/^[A-Za-z0-9]{6,}$/', $username);
$valid = $valid && preg_match('/^[A-Za-z0-9]{6,}$/', $password);

if (($email_verified !== '1') || ($phone_verified !== '1')) {
    header('Location: Register.php?error=verify');
    exit();
}

if (!$valid) {
    header('Location: Register.php?error=invalid');
    exit();
}

$check = $conn->prepare('SELECT seller_id FROM sellers WHERE username = ? OR email = ? OR phone = ? LIMIT 1');
$check->bind_param('sss', $username, $email, $phone);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    $check->close();
    header('Location: Register.php?error=duplicate');
    exit();
}
$check->close();

$password_hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare('INSERT INTO sellers (name, address, phone, email, username, password_hash) VALUES (?, ?, ?, ?, ?, ?)');
$stmt->bind_param('ssssss', $name, $address, $phone, $email, $username, $password_hash);

if ($stmt->execute()) {
    $stmt->close();
    header('Location: Login.php?registered=1');
    exit();
}

$stmt->close();
header('Location: Register.php?error=server');
exit();
?>
