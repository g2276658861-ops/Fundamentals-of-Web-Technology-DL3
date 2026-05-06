<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: add-car.php');
    exit();
}

echo 'Add car form received. Database insert will be added in the next commit.';
?>
