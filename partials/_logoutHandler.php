<?php
session_start();

session_destroy();
$_SESSION['loggedin'] = false;
header('location: /php-forum/index.php');

?>