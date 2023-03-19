<?php
    error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    session_start();
    include_once("../../database/config.php");

    if (! empty($_GET['eraseUser'])) {
        $order_id = $_GET['eraseUser'];
        $delete_order = mysqli_query($PDO, "DELETE FROM `orders` WHERE o_orderID = $order_id");
        header("location: ./");
    }
?>
