<?php
    session_start();
    error_reporting(E_WARNING || E_NOTICE || E_ERROR);

    include_once("../../database/config.php");

    // DISPLAY PRODUCT DATA VIA ID
    if (! empty($_GET['view']) || $_POST['view']) {
        $product_ID = $_GET['view'];
        $fetch_arrays = mysqli_query($PDO, "SELECT * FROM `products` WHERE pid = '$product_ID'");
        while($Val = mysqli_fetch_array($fetch_arrays)){
            $pid = $Val['pid'];
            $new_name = $Val['P_name'];
            $page_title = $Val['P_name'];
            $new_SKU = $Val['P_Sku'];
            $new_price = $Val['P_price'];
            $new_category = $Val['P_category'];
            $new_image = $Val['P_image'];
            $new_details = $Val['P_detail'];
            $new_unit = $Val['P_unit'];
            $new_stock = $Val['P_qty'];
        }        
    }
    else {
        header("location: ../");
    }

    //  INCREASE CART VALUE
    if (isset($_POST['add_cart'])) { $_SESSION['cartValue']++; }

    //  REDUCE CART VALUE
    if (isset($_POST['reduce_cart'])) {
        $reduce_cart = $_SESSION['cartValue']--;
        if ($reduce_cart <= 0) {
            $null_cart = '
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Empty basket not allowed!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            unset($_SESSION['cartValue']);
        }
    }
    
    // TO CHECKOUT PAGE
    if (isset($_POST['add_to_basket'])){
        if (empty($_POST['user_cart_selection'])) {
            $message = '
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Basket cannot be empty!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        else {
            $cart_session_value = $_POST['user_cart_selection'];
            $_SESSION['cartValue'] = $cart_session_value;
            header("location: ./checkout/index.php?checkoutID=$product_ID");
        }
    }

    // WISHLIST
    if (isset($_GET['wishlist_btn'])) {
        $wishlist_product_id = $_GET['wishlist_form_id'];
        $customer_username =  $_SESSION['cust_username'];

        // ALERT CUSTOMER TO SIGN IN BEFORE ADDING WISHLIST
        if (empty($_SESSION['cust_login']) || (empty($customer_username))) {
            $user_signIn = '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Kindly Login to add wishlist!</strong> <a href="./user_account/login.php" class="btn btn-outline-primary">login</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        else {
            // FETCH PRODUCT NAME  FROM THE PRODUCT DATABASE
            $fetch_product_name = mysqli_query($PDO, "SELECT * FROM `products` WHERE pid = '$wishlist_product_id'");
            while($Val = mysqli_fetch_array($fetch_product_name)){
                $product_name = $Val['P_name'];
                $product_price = $Val['P_price'];
                $product_category = $Val['P_category'];
                $product_image = $Val['P_image'];
                $product_ID = $Val['pid'];
                $product_sku = $Val['P_Sku'];
            }
            
            // QUERY WISHLIST DATABASE TO SEE IF THE PRODUCT NAME EXIST IN THE WISHLIST DATABBASE
            $fetch_cart_name = mysqli_query($PDO, "SELECT * FROM `wishlist` WHERE w_name = '$product_name'");
            if(mysqli_num_rows($fetch_cart_name) > 0){
                $wishlist_added_already = '
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">Wishlist already added! <a style="float:right;" class="btn btn-success btn-outline-light" href="./"  aria-label="Close">Okay</a>
                    </div>
                ';
            }
            else {
                $insert_products = mysqli_query($PDO, "INSERT INTO `wishlist`(`wid`, `w_name`, `w_price`, `w_category`, `w_image`, `w_username`) VALUES ('','$product_name','$product_price','$product_category','$product_image','$customer_username')");
                $wishlist_added = '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">Wishlist added! <a style="float:right;" class="btn btn-warning btn-outline-light" href="./"  aria-label="Close">Okay</a>
                    </div>
                ';
            }
        }
    }

    // DISPLAY WISHLIST DATA IN MODAL
    if (isset($_GET['get_wishlist_value'])) {
        $wishlist_get_username = $_SESSION['cust_username'];

        if (empty($wishlist_get_username)) {
            $username_not_found = '
                <div class="alert alert-success alert-dismissible fade show" role="alert">Please log In! <a style="float:right;" class="btn btn-warning btn-outline-light" href="./user_account/login.php"  aria-label="Close">Login</a>
                </div>';
        }
        else {
            $fetch_username = mysqli_query($PDO, "SELECT * FROM `wishlist` WHERE w_username = '$wishlist_get_username'");
            while($Val = mysqli_fetch_array($fetch_product_name)){
                $wp_name = $Val['P_name'];
                $wp_price = $Val['P_price'];
                $wp_category = $Val['P_category'];
                $wp_image = $Val['P_image'];
                $wp_ID = $Val['pid'];
                $wp_sku = $Val['P_Sku'];
            }
        }
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
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <title><?=$page_title?> | #1 Online Market</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- <link rel="stylesheet" href="../../node_modules/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
        <style>
            body{
                background: #f8fafc;
            }
            .modal-dialog{
                background: white;
            }
        </style>
    </head>
    <body>
        <!-- HEADER PAGE -->
        <header class="fixe-top">
            <div class="px-3 pt-2 text-bg-dark">
                <div class="container">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                        <a href="../" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                            <p class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><img style="border-radius:30%;" src="../../public/img/logo.jpg" alt="logo" width="100" height="50"/></p>
                        </a>
                        <button class="navbar-toggler btn btn-outline-light btn-lg" type="button" data-bs-toggle="collapse" data-bs-target="#header-nav-bar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fa fa-bars fa-lg fa-2x color-light"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="header-nav-bar">
                            <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                                <li>
                                    <a href="../" class="nav-link text-secondary"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-home fa-2x" aria-hidden="true"></i> </p>Mart</a>
                                </li>
                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#cart_modal" class="nav-link text-white"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-heart fa-2x"></i></p>Wishlist</a></li>
                                <li>
                                    <form action="" method="get">
                                        <input type="hidden" value="<?=$pid?>" name="get_wishlist_value">
                                        <a type="submit" data-bs-toggle="modal" data-bs-target="#wishlist_modal" class="nav-link text-white">
                                            <big class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-cart-plus fa-lg"></i> <?php if (isset($_SESSION['cartValue'])) { echo($_SESSION['cartValue']); };?></big>Cart
                                        </a>
                                    </form>
                                </li>
                                <li><a href="../user_account/account_info.php" class="nav-link text-white"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i></p>Account</a></li>
                                <li><a href="#" class="nav-link text-white"><p data-bs-toggle="modal" data-bs-target="#contact_modal" class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-phone fa-2x" aria-hidden="true"></i></p>Contact</a></li>
                                <li>
                                    <a href="../user_account/logout.php" class="nav-link text-white">
                                        <p class="bi d-block mx-auto" width="24" height="24"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-3 pb-2 border-bottom bg-dark">
                <div class="container">
                    <div class="row">
                        <form action="../search/index.php" method="post">
                            <div style="display:flex;flex-direction:row;">
                                <div style="width:95%; margin-right:1%;">
                                    <input type="search" class="form-control" name="q" placeholder="I am looking for..." aria-label="Search">
                                </div>
                                <div>
                                    <a type="submit" href=""><button class="btn btn-outline-light btn-warning" type="submit"><i class="fa  fa-search fa-lg"></i></button></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- MAIN PAGE -->
        <main>
            <div class="container">
                <?php if (isset($message)) {echo($message);} if (isset($null_cart)) {echo($null_cart);} ?>
                <div class="row mt-2 mb-5">
                    <div class="col">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content rounded-4 shadow">
                                <div class="modal-body p-5 pt-0">
                                    <div class="card mb-4 rounded-3 shadow-sm">
                                        <div class="card-header py-3">
                                            <h1 class="my-0 fw-normal "><?=$new_name?><i class="badge p-2 m-1 bg-danger">¢<?=$new_price-0.1?>9</i></h1>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4">
                                                    <img src="../../public/img/<?=$new_image?>" class="fluid img-fluid" alt="image">
                                                </div>
                                                <div class="col col-md-8">
                                                    <h3> Description</h3>
                                                    <form action="" method="post">
                                                        <p class="card-text"><?=$new_details?>.</p>
                                                        <p><strong>Category:</strong><a class="text-decoration-none" href="./view_one.php?product=<?=$new_category?>"> <i class="text-danger"><?=$new_category?></i></a> <strong>Product SKU:</strong>  <a href="./view.php?view=<?=$product_ID?>" class="text-danger text-decoration-none"><?=$new_SKU?></a></p>
                                                        <div style="display:flex;flex-direction:row;" class="row">
                                                            <div class="row">
                                                                <button type="submit" name="add_cart" style="width:15%;" class="btn btn-success"><i class="fa fa-plus-circle fa-lg"></i></button>
                                                                <input value="<?php if(! empty($_SESSION['cartValue'])){echo($_SESSION['cartValue']);}?>" style="margin-right:10px;margin-left:10px;width:20%;text-align:center;border:1px solid skyblue;" placeholder="QTY" class="form-control" type="text" name="user_cart_selection">
                                                                <button type="submit" name="reduce_cart" style="width:15%;margin-right:10px;" class="btn btn-danger"><i class="fa fa-minus-circle fa-lg"></i></button>
                                                                <button type="submit" style="width:30%;" name="add_to_basket" class="text-decoration-none btn btn-sm btn-light btn-outline-primary">Add To Basket</button></form>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <h2>Related Products</h2>
                                    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5">
                                    <?php
                                        $Fetch = mysqli_query($PDO, "SELECT * FROM `products` LIMIT 5") or die("Error fetching products bd-placeholder-img card-img-top fluid img-fluid");
                                        while($query = mysqli_fetch_array($Fetch)){ ?>
                                            <div class="col mt-4">
                                                <div class="card shadow-sm">
                                                    <a href="./view.php?view=<?=$query['pid'];?>"><img width="200" height="200" src="../../public/img/<?=$query['P_image'] ?>" alt="<?php echo $query['P_name'] ?>"></a>
                                                    <div class="card-body">
                                                        <p class="card-text"><strong><?=$query['P_name'] ?></strong> <i class="badge bg-danger">¢<?=$query['P_price'] ?></i></p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="btn-group">
                                                                <a class="text-decoration-none" href="./view.php?view=<?=$query['pid'];?>"><button type="button" class="btn btn-light btn-outline-success"><i class="fa fa-eye fa-lg"></i></button></a>
                                                                <a href="./checkout/index.php?checkoutID=<?=$query['pid'];?>" id="view_product"><button type="button" class="btn btn-light btn-outline-primary"><i class="fa fa-cart-plus" aria-hidden="true"></i></button></a>
                                                                <form action="" method="get"><button type="submit" name="wishlist_btn" title="Add to wishlist" class="btn btn-light btn-sm btn-outline-danger"><i class="fa fa-heart fa-lg"></i></button></a>
                                                                <input type="hidden" name="wishlist_form_id" value="<?=$query['pid'];?>"></form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- CART MODAL -->
        <div class="modal fade" id="cart_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cart_modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cart_modalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>I will not close if you click outside me. Don't even try to press escape key.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
                </div>
            </div>
        </div>

        <!-- WISHLIST MODAL -->
        <div class="modal fade" id="wishlist_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="wishlist_modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="wishlist_modalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>I will not close if you click outside me. Don't even try to press escape key.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Understood</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTACT MODAL -->
        <div class="modal fade" id="contact_modal" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-4" id="contact_modal">Connect With <a href="https://jamesakweter.online" target="_blank"><kbd>Akweter</kbd></a></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-stripped">
                            <thead>
                                <tr><td>Email</td> <td><a href="mailto:jamesakweter@gmail.com" target="_blank">Email</a></td></tr>
                                <tr><td>Instagram</td><td><a href="https://instagram.com/jamesakweter" target="_blank">Instagram</a></td></tr>
                                <tr><td>Projects</td><td><a href="https://jamesakweter.online/projects" target="_blank">Projects</a></td></tr>
                                <tr><td>Github</td><td><a href="https://github.com/JOHNBAPTIS" target="_blank">Github</a></td></tr>
                                <tr><td>LinkedIn</td><td><a href="https://linkedin.com/a/jamesakweter" target="_blank">LinkedIn</a></td></tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- FOOTER PAGE -->
        <div class="bg-dark text-white">
            <footer class="p-5 pb-0 container">
                <div class="row">
                    <div class="col-6 col-md-2 mb-3">
                        <h5>Company</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">History</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Mission</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Values</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Investors Feed</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Philanthophy</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-md-2 mb-3">
                        <h5>Assistance</h5>
                        <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Conatact us</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Testimonals</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Blog</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">FAQs</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Chat with Agent</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-md-2 mb-3 d-none d-sm-block">
                        <h5>Terms</h5>
                        <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Return Policy</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Terms And Condition</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Cookie Terms</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Sell With us</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Conflict Resolution</a></li>
                        </ul>
                    </div>

                    <div class="col-md-5 offset-md-1 mb-3">
                        <form>
                        <h5>Subscribe to our newsletter</h5>
                        <p>Monthly digest of what's new and exciting from us.</p>
                        <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                            <label for="newsletter1" class="visually-hidden">Email address</label>
                            <input id="newsletter1" type="text" class="form-control" placeholder="Email address">
                            <button class="btn btn-primary" type="button">Subscribe</button>
                        </div>
                        </form>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
                <p>&copy; <?php echo( date("Y"));?> ( Akweter James) All rights reserved.</p>
                <ul class="list-unstyled d-flex">
                    <li class="ms-3"><a class="link-light fa twitter" href="#"><i class="fa fa-linkedin-square fa-2x" aria-hidden="true"></i></a></li>
                    <li class="ms-3"><a class="link-light" href="#"><p class="bi" width="24" height="24"><i class="fa fa-youtube-square fa-2x" aria-hidden="true"></i></p></a></li>
                    <li class="ms-3"><a class="link-light fa twitter" href="#"><i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i></a></li>
                    <li class="ms-3"><a class="link-light" href="#"><p class="bi" width="24" height="24"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></p></a></li>
                    <li class="ms-3"><a class="link-light" href="#"><p class="bi" width="24" height="24"><i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i></p></a></li>
                    <li class="ms-3"><a class="link-light" href="#"><p class="bi" width="24" height="24"><i class="fa fa-envelope fa-2x"></i></p></a></li>
                </ul>
                </div>
            </footer>
        </div>

        <script src="../../../node_modules/bootstrap.min.js"></script>
    </body>
</html>
