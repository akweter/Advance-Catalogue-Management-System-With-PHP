<?php
    session_start();
    error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    
    if (! empty($_SESSION['cust_login']) || ($_SESSION['cust_sign_up'])) {
        header("location: ./account_info.php");
    }
    else {
        header("location: ./login.php");
    }
?>
