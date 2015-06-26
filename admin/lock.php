<?php
session_name("Autentification");
session_start();

if (!isset($_SESSION['user_pass']) || !isset($_SESSION['user_id']))
{
    session_destroy();
    Header ("Location: in.php?errorLogin=5");
    exit;
}
else {
    $user_login = $_SESSION['user_login'];
    $user_id = $_SESSION['user_id'];
}
?>