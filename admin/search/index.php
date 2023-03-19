<?php
    session_start();
    // error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    include_once("../../database/config.php");

    $admin_signup =  $_SESSION['admin_sign_up'];
    $admin_login = $_SESSION['admin_login'];
    $admin_username = $_SESSION['admin_username'];
    $status = $_SESSION['admin'];

    if (empty($admin_login) || empty($admin_signup)) {
        header('location: ../auth/login.php');
    }

    // $search_product_name = mysqli_query($PDO, "SELECT * FROM `products` WHERE P_name = '' ");
    //     while($Val = mysqli_fetch_array($search_product_name)){
    //         $product_name = $Val['P_name'];
    //     }    
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
            <title>Search result | Shop</title>
            <link rel="stylesheet" href="../../node_modules/bootstrap/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        </head>
    <body>

        <!-- Header -->
        <header>
            <div class="px-3 py-2 bg-info">
                <div class="container">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="../" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
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
                <form action="" method="POST" class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
                    <input type="search" name="product" class="form-control" placeholder="<?php if(isset($search_term)){echo($search_term);}else{echo("I am looking for...");}?>" aria-label="Search">
                </form>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="container mt-5 mb-5">
            <?php   
                if (! empty($_POST['product'])) {
                    $search_term = $_POST['product'];

                    if (! empty($search_term)) {
                        $search = mysqli_query($PDO,"SELECT * FROM `products` WHERE CONCAT(P_name,P_category) LIKE '%$search_term%' ORDER BY P_name ASC");
                        
                        if(mysqli_num_rows($search) > 0){
                            foreach($search as $data){
                                $new_name = $data['P_name'];
                                $pid = $data['pid'];
                                $new_image = $data['P_image'];
                                $new_category = $data['P_category'];?>
                                
                                <div class="list-group mb-2">
                                    <a href="../product/action.php?more=<?=$pid?>" class="list-group-item-action d-flex gap-3 text-decoration-none" aria-current="true">
                                        <img src="../../public/img/<?=$new_image?>" alt="<?=$new_name?>" width="32" height="32" class="flex-shrink-0">
                                        <div class="d-flex justify-content-between align-item-center">
                                            <p class="mb-0"><?=$new_name?> | <?=$new_category?></p>
                                        </div>
                                    </a>
                                </div>
                            <?php } 
                        }
                        else{
                            echo('<tr" colspan="6"><td colspan="6"><h2>No records found!</h2></td></tr><p></p><a href="../" class="btn btn-lg btn-warning">Vist Dashboard</a></p> ');
                        }
                    }
                    else {
                        header('location: ../');
                    }
                }
                // else {
                //     header('location: ../');
                // }
            ?>
        </main>

        <!-- Footer -->
        <div class="bg-info">
            <footer class="py-4 container">
                <div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
                    <p>&copy; <?php echo(date("Y")); ?> Angel Dev Team. All rights reserved.</p>
                </div>
            </footer>
        </div>

        <script src="../../node_modules/bootstrap/bootstrap.min.js"></script>
    </body>
</html>
