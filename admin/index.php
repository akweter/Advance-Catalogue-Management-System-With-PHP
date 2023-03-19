<?php
    session_start();

    if (! isset($_SESSION['admin_sign_up']) || (! isset($_SESSION['admin_login']))){
        header('location: ./auth/login.php');
    }
    else{
        header('location: ./dashboard.php');
    }
?>