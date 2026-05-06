<?php
//First login commit placeholder.
//Session authentication is implemented in the second login commit.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Login.php');
    exit();
}

echo 'Login form received. Password authentication will be added in the next commit.';
?>
