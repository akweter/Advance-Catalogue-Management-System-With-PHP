<?php
    error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    session_start();

    include_once("../../database/config.php");
    
    $admin_signup =  $_SESSION['admin_sign_up'];
    $admin_login = $_SESSION['admin_login'];
    $admin_username = $_SESSION['admin_username'];
    $status = $_SESSION['admin'];

    if (empty($admin_login) || empty($admin_signup)) {
        header('location: ../auth/login.php');
    }

    // QUERY DATABSE FOR SEARCH PRODUCT
    $search_product_name = mysqli_query($PDO, "SELECT * FROM `products` ");
    while($Val = mysqli_fetch_array($search_product_name)){
        $product_name = $Val['P_name'];
    } $stock_details = $Val['P_name'];

        $cement_cat = "SELECT SUM(P_qty) FROM `products` WHERE P_category = 'Reebok'";
        $fetch_arrays = mysqli_query($PDO, $cement_cat);
        while($Val = mysqli_fetch_array($fetch_arrays)){
            $reebok_stock = $Val['SUM(P_qty)'];
        }

        $Rope_cat = "SELECT SUM(P_qty) FROM `products` WHERE P_category = 'Adidas'";
        $fetch_arrays = mysqli_query($PDO, $Rope_cat);
        while($Val = mysqli_fetch_array($fetch_arrays)){
            $adida_stock = $Val['SUM(P_qty)'];
        }

        $Insulation_cat = "SELECT SUM(P_qty) FROM `products` WHERE P_category = 'New Ballance'";
        $fetch_arrays = mysqli_query($PDO, $Insulation_cat);
        while($Val = mysqli_fetch_array($fetch_arrays)){
            $New_Ballance_stock = $Val['SUM(P_qty)'];
        }

        $Armaflex_cat = "SELECT SUM(P_qty) FROM `products` WHERE P_category = 'Air Force'";
        $fetch_arrays = mysqli_query($PDO, $Armaflex_cat);
        while($Val = mysqli_fetch_array($fetch_arrays)){
            $Air_Force = $Val['SUM(P_qty)'];
        }

        $Roofing_cat = "SELECT SUM(P_qty) FROM `products` WHERE P_category = 'Nike'";
        $fetch_arrays = mysqli_query($PDO, $Roofing_cat);
        while($Val = mysqli_fetch_array($fetch_arrays)){
            $Nike = $Val['SUM(P_qty)'];
        }

        $Expandable_cat = "SELECT SUM(P_qty) FROM `products` WHERE P_category = 'Louis Vuiton'";
        $fetch_arrays = mysqli_query($PDO, $Expandable_cat);
        while($Val = mysqli_fetch_array($fetch_arrays)){
            $Louis_Vuiton = $Val['SUM(P_qty)'];
        }

        $Donwproofing_cat = "SELECT SUM(P_qty) FROM `products` WHERE P_category = 'All Stars'";
        $fetch_arrays = mysqli_query($PDO, $Donwproofing_cat);
        while($Val = mysqli_fetch_array($fetch_arrays)){
            $All_Stars = $Val['SUM(P_qty)'];
        }

        $Wooden_cat = "SELECT SUM(P_qty) FROM `products` WHERE P_category = 'MC Queen'";
        $fetch_arrays = mysqli_query($PDO, $Wooden_cat);
        while($Val = mysqli_fetch_array($fetch_arrays)){
            $MC_Queen = $Val['SUM(P_qty)'];
        }

        $Plumbing_cat = "SELECT SUM(P_qty) FROM `products` WHERE P_category = 'Puma'";
        $fetch_arrays = mysqli_query($PDO, $Plumbing_cat);
        while($Val = mysqli_fetch_array($fetch_arrays)){
            $Puma = $Val['SUM(P_qty)'];
        }   
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
        <link rel="icon" sizes="180x180" href="../../public/img/glass.webp">
        <link rel="apple-touch-icon" sizes="180x180" href="../../public/img/glass.webp">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>

        <!-- Header -->
        <header>
            <div class="px-3 py-2 text-bg-info">
                <div class="container">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="./" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                            <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><img src="../../public/img/wheat.jpg" width="50" height="50" alt="logo" srcset=""></svg><h1 style="margin-left:50px;">Welcome <?php if (isset($admin_username)) {echo($admin_username);}?> <i class="badge bg-danger"><?php if (isset($status)) {echo($status);} ?></i></h1>
                        </a>
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
                                <a href="../auth/logout.php"><button type="button" class="btn btn-sm btn-danger">Log Out</button></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="px-3 py-2 bg-light border-bottom mb-3">
                <div class="container d-flex flex-wrap justify-content-center">
                    <form style="width:60%;" action="../search/index.php?product=<?=$product_name?>" method="POST" class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
                        <input type="search" name="product" class="form-control" placeholder="I am looking for..." aria-label="Search">
                    </form>

                    <div class="btn-toolbar mb-2 mb-md-0">
                        <h1>Available Stock</h1>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3 sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="../dashboard.php" class="text-decoration-none"><button class="nav-link btn btn-toggle d-inline-flex align-items-center rounded border-0">Dashboard</button></a>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">Stock</button>                                   <div class="collapse show" id="home-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <!-- <li><a href="#" class="nav-link text-danger d-inline-flex text-decoration-none rounded">St 1</a></li>
                                    <li><a href="#" class="nav-link text-danger d-inline-flex text-decoration-none rounded">St 2</a></li>
                                    <li><a href="#" class="nav-link text-danger d-inline-flex text-decoration-none rounded">St 3</a></li> -->
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="../product" class="text-decoration-none nav-link btn btn-toggle d-inline-flex align-items-center rounded border-0">Product</a>
                            </li>
                            <li class="nav-item">
                                <li><a href="../orders" class="nav-link btn btn-toggle d-inline-flex align-items-center rounded border-0">Orders</a></li>
                            </li>
                            <li class="mb-1">
                                <li><a href="../user" class="nav-link d-inline-flex text-decoration-none rounded">Users</a></li>
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
                            <img src="../../public/img/wheat.jpg" width="52" alt="Avatar">
                            </li>
                            
                        </ul>
                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="col px-4 pb-3">
                                    <table class=" table table-striped">
                                        <thead class="thead">
                                            <tr class="table-dark">
                                                <td><h3>AVAILABLE SHOES</h3></td><td><H3>QUANTITIES</H3></td>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody">
                                            <tr><td>Reebok</td><td><?=$reebok_stock?></td></tr>
                                            <tr><td>Adidas</td><td><?=$adida_stock?></td></tr>
                                            <tr><td>New Ballance</td><td><?=$New_Ballance_stock?></td></tr>
                                            <tr><td>Roofing</td><td><?=$Nike?></td></tr>
                                            <tr><td>Air Force</td><td><?=$Air_Force?></td></tr>
                                            <tr><td>Nike</td><td><?=$Nike?></td></tr>
                                            <tr><td>Louis Vuiton</td><td><?=$Louis_Vuiton?></td></tr>
                                            <tr><td>All Stars</td><td><?=$All_Stars?></td></tr>
                                            <tr><td>MC Queen</td><td><?=$MC_Queen?></td></tr>
                                            <tr><td>Puma</td><td><?=$Puma?></td></tr>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                </main>
                
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-info">
                <footer class="py-4 container">
                    <div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
                        <p>&copy; <?php echo(date("Y")); ?> Angel Dev Team. All rights reserved.</p>
                    </div>
                </footer>
            </div>
        </div>
        <script src="../../node_modules/bootstrap/bootstrap.min.js"></script>
    </body>
</html>
