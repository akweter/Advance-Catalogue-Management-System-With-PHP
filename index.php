<?php
    session_start();

    if (! empty($_SESSION['admin'])) {
        header("location: ./admin");
    } else {
        header("location: ./client");
    }
    
?>
