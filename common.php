<?php

    require_once('./_user.php');

    use MyUsers\User as User;

    session_start(); // Necessary to start or resume a session
    if (!isset($_SESSION['UserLogged'])) {
        $_SESSION['UserLogged'] = false;
    }

    if(!isset($_SESSION['user'])){
        $_SESSION['user'] = new User();
    }

    $UserLogged = &$_SESSION['UserLogged'];
    $user = &$_SESSION['user'];
?>
