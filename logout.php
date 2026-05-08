<?php
session_start();
session_unset();
session_destroy();
header('Location: Login.php?logout=1');
exit();
?>
