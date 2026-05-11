<?php
// Database connection used by all server-side pages.
// This project uses MAMP on Mac, so the default MySQL port is usually 8889.
$host = 'localhost';
$port = '8889';
$user = 'root';
$password = 'root';
$database = 'car_database';

$conn = new mysqli($host, $user, $password, $database, (int)$port);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');

// Keep PHP/MySQL verification-code time consistent for China/Singapore time.
// This avoids the 8-hour difference between created_at and expires_at on MAMP.
$conn->query("SET time_zone = '+08:00'");
?>
