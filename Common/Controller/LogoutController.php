<?php

session_start();

// clear session data
$_SESSION = [];

// clear the remembered-username cookie set at login
if(isset($_COOKIE["username"]))
{
    setcookie("username", "", time() - 3600, "/");
}

// destroy the session completely
session_destroy();

header("Location: ../View/login.php");
exit();

?>
