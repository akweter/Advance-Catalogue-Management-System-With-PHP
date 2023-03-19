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
        <link rel="apple-touch-icon" sizes="180x180" href="../public/img/glass.webp">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>

        <!-- Header -->
        <header>
            <div class="px-3 py-2 bg-info">
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
            <div class="px-3 bg-light py-2 border-bottom mb-3">
                <div class="container d-flex flex-wrap justify-content-center">
                    <form style="width:60%;" action="../search/index.php?product=<?=$product_name?>" method="POST" class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
                        <input type="search" name="product" class="form-control" placeholder="I am looking for..." aria-label="Search">
                    </form>

                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group">
                            <h1>Orders</h1>
                        </div>
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
                                <a href="../dashboard.php" class="text-decoration-none nav-link">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a href="../stock" class="text-decoration-none nav-link">Stock</a>
                            </li>
                            <li class="nav-item">
                                <a href="../product" class="text-decoration-none nav-link">Products</a>
                            </li>
                            <li class="mb-1">
                                <button class="nav-link btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">Orders</button>
                                <div class="collapse" id="dashboard-collapse">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <li><a href="#" class="nav-link text-danger d-inline-flex text-decoration-none rounded">Pending</a></li>
                                        <li><a href="#" class="nav-link text-danger d-inline-flex text-decoration-none rounded">Completed</a></li>
                                        <li><a href="#" class="nav-link text-danger d-inline-flex text-decoration-none rounded">On-Hold</a></li>
                                        <li><a href="#" class="nav-link text-danger d-inline-flex text-decoration-none rounded">Cancel</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="../user" class="text-decoration-none nav-link">Users</a>
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
                            <img src="./" alt="Avatar">
                            </li>
                            
                        </ul>
                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <table class="table table-hover">
                        <thead>
                            <tr class="table-dark">
                                <th scope="col">#</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Product ID</th>
                                <th scope="col">QTY</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Payment Mode</th>
                                <th scope="col">Order Time</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                            <?php
                                $Fetch = mysqli_query($PDO, "SELECT * FROM `orders` ORDER BY o_date ASC") or die("Error fetching products");
                                $num = 1;
                                while($query = mysqli_fetch_array($Fetch)){ ?>
                        <tbody>
                            <tr>
                                <td><?=$num++ ?></td>
                                <td><?=$query['o_orderID'] ?></td>
                                <td><?=$query['o_username'] ?></td>
                                <td><a href='../product/action.php?more=<?=$query['o_product_id'];?>'><?=$query['o_product_id'] ?></a></td>
                                <td><?=$query['o_qty']?></td>
                                <td>¢<?=$query['o_subtotal']?></td>
                                <td>¢<?=$query['o_total_payment'] ?></td>
                                <td><?=$query['o_paymentMode'] ?></td>
                                <td><?=$query['o_time']?></td>
                                <td><?=$query['o_date']?></td>
                                <td><?=$query['status']?></td>
                                <td class="text-danger"><a href="./edit_order.php?editOrder=<?=$query['o_orderID'];?>"><i class="fa fa-edit fa-lg"></i>Edit</a> | <a onclick="return confirm('This operation is risky. Are you sure to delete?');" href="./order_crud.php?eraseUser=<?=$query['o_orderID'];?>"><i class="fa fa-times fa-lg"></i>Delete</a></td>
                            </tr>
                        </tbody>
                            <?php } ?>
                    </table>
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
        <script src="../../node_modules\fontawesome\js\fontawesome.min.js"></script>
    </body>
</html>
