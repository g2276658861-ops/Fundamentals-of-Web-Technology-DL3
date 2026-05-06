<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Register.php');
    exit();
}

echo 'Registration form received. Database insert will be added in the next commit.';
?>
