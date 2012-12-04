<?php
session_start();
$_SESSION['isAuthenticated'] =  false;
unset($_SESSION['email']);

header('Location: /ai/');

?>
