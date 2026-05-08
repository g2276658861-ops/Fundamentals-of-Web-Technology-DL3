<?php
session_start();

if (!isset($_SESSION['seller_id'])) {
    header('Location: Login.php?error=need_login');
    exit();
}
?>
