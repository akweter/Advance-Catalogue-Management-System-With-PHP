<?php
    error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    session_start();
    include_once("../database/config.php");

    $admin_signup =  $_SESSION['admin_sign_up'];
    $admin_login = $_SESSION['admin_login'];
    $admin_username = $_SESSION['admin_username'];
    $status = $_SESSION['admin'];

    if (empty($admin_login) || empty($admin_signup)) {
        header('location: ./auth/login.php');
    }

    // QUERY DATABSE FOR SEARCH PRODUCT
    $search_product_name = mysqli_query($PDO, "SELECT * FROM `products` ");
        while($Val = mysqli_fetch_array($search_product_name)){
            $product_name = $Val['P_name'];
        }

        // COUNT USERS FROM CUSTOMERS DB
        $total_customers = "SELECT * FROM `customers` ORDER BY C_id ASC";
        $fetch_arrays = mysqli_query($PDO, $total_customers);
        $customers = mysqli_num_rows($fetch_arrays);

        // TOTAL PRODUCT QTY 
        $orders = "SELECT * FROM `orders` ";
        $fetch = mysqli_query($PDO, $orders);
        $process_order_qty = mysqli_num_rows($fetch);
        
        // TOTAL PRODUCT QTY
        $_cat = "SELECT P_name FROM `products` ";
        $fetch = mysqli_query($PDO, $_cat);
        $all_products = mysqli_num_rows($fetch);
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Supermarket Management Software">
        <meta name="author" content="James Akweter">
        <meta name="generator" content="Angel Dev Team">
        <link rel="icon" sizes="180x180" href="../public/img/glass.webp">
        <link rel="apple-touch-icon" sizes="180x180" href="../public/img/glass.webp">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            .card-title,.card-text{color:red;cursor: pointer;}.fa{color:lightgreen;}
        </style>
    </head>
    <body>

        <!-- Header admin_username-->
        <header>
            <div class="px-3 py-2 bg-info">
                <div class="container">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                        <k href="./" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                            <img src="../public/img/wheat.jpg" width="50" height="50" alt="logo">
                            <h1 style="margin-left:50px;">Welcome <?php if (isset($admin_username)) {echo($admin_username);}?></h1>
                        </k>
                        <ul class="nav p-3 col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                            <li>
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle border">
                                <span data-feather="calendar" class="align-text-bottom"></span>This week
                            </button>
                            </li>
                            <li>
                                <button type="button" class="btn btn-sm btn-light btn-light border">Share</button>
                            </li>
                            <li>
                                <button type="button" class="btn btn-sm btn-light btn-light border">Export</button>
                            </li>
                            <li class="">
                                <a href="./auth/logout.php"><button type="button" class="btn btn-sm btn-danger">Log Out</button></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="bg-light px-3 py-2 border-bottom mb-3">
                <div class="container d-flex flex-wrap justify-content-center">
                    <form style="width:60%;" action="./search/index.php?product=<?=$product_name?>" method="POST" class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
                        <input type="search" name="product" class="form-control" placeholder="I am looking for..." aria-label="Search">
                    </form>

                    <div class="btn-toolbar mb-2 mb-md-0">
                        <h1>Admin Dashboard</h1>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3 sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <button class="nav-link btn btn-toggle d-inline-flex align-items-center rounded border-0">Dashboard</button>  
                            </li>
                            <li class="nav-item">
                                <a href="./stock" class="text-decoration-none"><button class="nav-link btn btn-toggle d-inline-flex align-items-center rounded border-0">Stock</button></a>
                            </li>
                            <li class="nav-item">
                                <a href="./product" class="text-decoration-none"><button class="nav-link btn btn-toggle d-inline-flex align-items-center rounded border-0">Products</button></a>
                            </li>
                            <li class="nav-item">
                                <a href="./orders" class="text-decoration-none"><button class="nav-link btn btn-toggle d-inline-flex align-items-center rounded border-0">Orders</button></a>
                            </li>
                            <li class="nav-item">
                                <a href="./user" class="text-decoration-none"><button class="nav-link btn btn-toggle d-inline-flex align-items-center rounded border-0">Users</button></a>
                            </li>
                        </ul>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                            <span>Account</span>
                            <a class="link-secondary" href="#" aria-label="Add a new report">
                                <span data-feather="plus-circle" class="align-text-bottom"></span>
                            </a>
                        </h6>
                        <ul class="nav flex-column mb-2">
                            <li class="nav-item">
                            <img src="../public/img/wheat.jpg" width="50" height="50" alt="Avatar">
                            </li>
                            
                        </ul>
                    </div>
                </nav>

                <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
                    <div class="album">
                        <div class="album mb-4">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                                <div class="col">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <i class="fa fa-user fa-4x p-3"></i>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <p class="card-text">Active Users</p>
                                                    <h5 class="card-title"><?=$customers?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <i class="fa fa-th-list fa-4x p-3"></i>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <p class="card-text">All Categories</p>
                                                    <h5 class="card-title">9</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <i class="fa fa-shopping-cart fa-4x p-3"></i>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <p class="card-text">Total Products</p>
                                                    <h5 class="card-title"><?=$all_products?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <i class="fa fa-money fa-4x p-3"></i>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <p class="card-text">Total Orders</p>
                                                    <h5 class="card-title"><?=$process_order_qty?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="album">
                            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-3 g-3">
                                <div class="col col-md-7">
                                <h4>Order History <a href="./orders">**</a></h4>
                                    <table class=" table table-hover">
                                        <thead class="thead">
                                            <tr class="table-primary">
                                                <td>#</td><td>Product Name</td><td>User Name</td><td>Date</td><td>Status</td><td>Total Sale</td>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody">
                                            <?php
                                                $Fetch = mysqli_query($PDO, "SELECT * FROM `orders` ORDER BY o_date ASC") or die("Error fetching products");
                                                $count = 1; 
                                                
                                                if (mysqli_num_rows($Fetch)> 0) {
                                                    foreach ($Fetch as $query) {
                                                        $oid = $query['o_orderID'];
                                                        $o_user = $query['o_username'];
                                                        $o_pid = $query['o_product_id'];
                                                        $oDate = $query['o_date'];
                                                        $oStatus = $query['status'];
                                                        $oSales = $query['o_total_payment'];?>

                                                        <?php 
                                                        $product_fetch = "SELECT * FROM `products` WHERE pid = '$o_pid'";
                                                        $fetch_arrays = mysqli_query($PDO, $product_fetch);
                                                        while($Val = mysqli_fetch_array($fetch_arrays)){
                                                            $product_name = $Val['P_name'];
                                                            $prodct_id = $Val['pid'];
                                                        }?>
                                            <tr>
                                                <td><?=$count++?></td>
                                                <td><a style="text-decoration:none;" href='./product/action.php?more=<?=$prodct_id;?>'><?=$product_name?></a></td>
                                                <td><?=$o_user?></td>
                                                <td><?=$oDate?></td>
                                                <td><?=$oStatus?></td>
                                                <td>¢<?=$oSales?>.00</td>
                                            </tr>
                                                    <?php }
                                                }

                                                ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col col-md-5">
                                    <h4 class="">Pending Orders</h4>
                                    <table class=" table table-striped">
                                        <thead class="thead">
                                            <tr class="table-danger">
                                                <td>#</td><td>Product Name</td><td>Date</td><!--<td>Status</td>--><td>Total Sale</td>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody">
                                            <?php
                                                $Fetch = mysqli_query($PDO, "SELECT * FROM `orders` WHERE status = 'Pending' ") or die("Error fetching products");
                                                $count = 1; 
                                                
                                                if (mysqli_num_rows($Fetch)> 0) {
                                                    foreach ($Fetch as $query) {
                                                        $oid = $query['o_orderID'];
                                                        $o_pid = $query['o_product_id'];
                                                        $oDate = $query['o_date'];
                                                        $oStatus = $query['status'];
                                                        $oSales = $query['o_total_payment'];?>

                                                        <?php 
                                                        $product_fetch = "SELECT * FROM `products` WHERE pid = '$o_pid'";
                                                        $fetch_arrays = mysqli_query($PDO, $product_fetch);
                                                        while($Val = mysqli_fetch_array($fetch_arrays)){
                                                            $product_name = $Val['P_name'];
                                                            $prodct_id = $Val['pid'];
                                                        }?>
                                            <tr>
                                                <td><?=$count++?></td>
                                                <td><a style="text-decoration:none;" href='./product/action.php?more=<?=$prodct_id;?>'><?=$product_name?></a></td>
                                                <td><?=$oDate?></td>
                                                <!-- <td><?=$oStatus?></td> -->
                                                <td>¢<?=$oSales?>.00</td>
                                            </tr>
                                                    <?php }
                                                }

                                                ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-info">
            <footer class="py-4 container">
                <div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top"><p>&copy; <?php echo(date("Y")); ?> Angel Dev Team. All rights reserved.</p>
                </div>
            </footer>
        </div>
        <script src="../node_modules/bootstrap/bootstrap.min.js"></script>
       </body>
</html>
