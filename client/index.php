<?php
    error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    session_start();

    include_once("../database/config.php");

    // ADD TO CART
    if (isset($_GET['add_to_cart_btn'])) {
        $ID = $_GET['central_product_ID'];

        $_SESSION['cartValue'] = '1';

        header("location: ./shop/checkout/index.php?checkoutID=$ID");
    }

    // QUCIK VIEW
    if (isset($_GET['quick_view_btn'])) {
        $ID = $_GET['central_product_ID'];
        header("location: ./shop/view.php?view=$ID");
    }

    // WISHLIST
    if (isset($_GET['wishlist_btn'])) {
        $wishlist_product_id = $_GET['central_product_ID'];
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
            // WISHLIST MODAL
            $new_username = $_SESSION['cust_username'];
            $fetch_username_from_wishlist_db = mysqli_query($PDO, "SELECT * FROM `wishlist` WHERE w_username = '$new_username'");
            while($data = mysqli_fetch_array($fetch_username_from_wishlist_db)){
                $modal_p_name = $data['w_name'];
                $modal_p_price = $data['w_price'];
                $modal_p_category = $data['w_category'];
                $modal_p_image = $data['w_image'];
                $model_product_ID = $data['wid'];
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
                $wp_name = $Val['w_name'];
                $wp_price = $Val['w_price'];
                $wp_category = $Val['w_category'];
                $wp_image = $Val['w_image'];
                $wp_ID = $Val['wid'];
                $wp_username = $Val['w_username'];
            }
        }
    }

    // CHECKOUT CART
    if (isset($_POST['modal_submit_btn'])) {
        $_SESSION['cartValue'] = '1';
        $wishlist_product_name = mysqli_query($PDO, "SELECT * FROM `wishlist` ORDER BY wid ");
            while($Values = mysqli_fetch_array($wishlist_product_name)){
                $new_name = $Values['w_name'];
            }

        $compare_product_name = mysqli_query($PDO, "SELECT * FROM `products` WHERE P_name = '$new_name'");
        while($Values = mysqli_fetch_array($compare_product_name)){
            $new_id = $Values['pid'];
        }
        
        header("location: ./shop/checkout/index.php?checkoutID=$new_id");
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
        <title>#1 Online Market | Persol</title>
        <link rel="stylesheet" href="../../node_modules/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            html{
                padding: 0;
                margin: 0;
            }

            body, .options{
                backgroun: #f7f3de;
            }

            p#jumbotrom_text{
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
                text-align: center;
            }

            .fs-3{text-align:center;color:red;text-transform: capitalize;text-decoration: 3px solid #3bd8ec overline;margin-bottom: 20px;}

            .try-body{
                text-align: center;
                border: 10px solid green;;
                width: 50%;
                margin: 0 0%;
                background: lightgray;
            }

            #first-one{
                text-align: center;
                background-color: red;
                height: 60px;
                width: 200px;
                border: 3px solid blue;
                margin: 15px;
                z-index: 50px;
                position: sticky;
            }

            #second-one{
                text-align: start;
                background-color: yellow;
                height: 60px;
                width: 200px;
                border: 3px solid salmon;
                margin-left: 30px;
                margin-top: -45px;
                z-index: 51px;
                position: sticky;
            }

            #second-of-second{
                text-align: end;
                background-color: lightblue;
                width: 80px;
                height: 30px;
                position: absolute;
                top: 0px;
                right: 0px;
                z-index: 300px;
            }

            #third-one{
                background-color: blue;
                height: 60px;
                width: 200px;
                border: 3px solid rebeccapurple;
                margin-left: 0;
                margin-top: -30px;
                position: relative;
            }

            #fourth-one{
                background-color: violet;
                height: 60px;
                width: 200px;
                border: 5px solid black;
                margin-left: 30px;
                padding: 10% 0;
                margin-top: -30px;
                zoom: 100%;
            }

            #fifth-one{
                background-color: gray;
                height: 60px;
                width: 200px;
                border: 3px solid ghostwhite;
                margin-left: 14%;
                margin-top: -30px;
            }
            h3.amazing_deals{
                text-align: center;
                font-style: oblique;
                font-size: 150%;
                font-weight: lighter;
            }
            a#view_product{
                margin-right: 5%;
                margin-left: 5%;
            }
            h4{
                text-align: center;
            }
            /* div.shop_now{
                text-align: center;
                align-items: center;
            } */
        </style>
    </head>
    <body>
        <header class="fixe-top">
            <div class="pb-0 pt-2 text-bg-dark">
                <div class="">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                        <a href="./" class="container d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                            <p class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><img style="border-radius:30%;" src="../public/img/logo.jpg" alt="logo" width="100" height="50"/></p>
                        </a>
                        <button class="navbar-toggler btn btn-outline-light btn-lg" type="button" data-bs-toggle="collapse" data-bs-target="#header-nav-bar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fa fa-bars fa-lg fa-2x color-light p-3"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="header-nav-bar">
                            <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                                <li><a href="./" class="nav-link text-secondary"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-home fa-lg" aria-hidden="true"></i> </p>Mart</a></li>
                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#cart_modal" class="nav-link text-white"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-heart fa-lg"></i></p>Wishlist</a></li>
                                <li>
                                    <form action="" method="get">
                                        <input type="hidden" value="<?=$pid?>" name="get_wishlist_value">
                                        <a type="submit" data-bs-toggle="modal" data-bs-target="#wishlist_modal" class="nav-link text-white">
                                            <big class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-cart-plus fa-lg"></i> <?php if (isset($_SESSION['cartValue'])) { echo($_SESSION['cartValue']); };?></big>Cart
                                        </a>
                                    </form>
                                </li>
                                <li><a href="./user_account/account_info.php" class="nav-link text-white"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-user-plus fa-lg" aria-hidden="true"></i></p>Account</a></li>
                                <li><a href="#" class="nav-link text-white"><p data-bs-toggle="modal" data-bs-target="#contact_modal" class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-phone fa-lg" aria-hidden="true"></i></p>Contact</a></li>
                                <li><a href="./user_account/logout.php" class="nav-link text-white"><p class="bi d-block mx-auto" width="24" height="24"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></p></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-3 pb-3 border-bottom bg-dark">
                <div class="row">
                    <form action="./search/index.php" method="post">
                        <div style="display:flex;flex-direction:row;">
                            <div style="width:95%; margin-right:1%;">
                                <input type="search" class="form-control" name="q" placeholder="Search..." aria-label="Search">
                            </div>
                            <div>
                                <a type="submit" href=""><button class="btn btn-outline-light btn-warning" type="submit"><i class="fa  fa-search fa-lg"></i></button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </header>
        <main>
            <!-- block one -->
            <div id="jumbotrom bg-light" class="mb-5" style="background: linear-gradient(black, gray, white);">
                <div  style="padding: 15% 0 ;" class="row justify-content-around">
                    <h3 class="col col-md-6 amazing_deals fw-bold fs-1 bg-success text-white">👠Your Shoes Are Here👢</h3>
                </div>
            </div>
            <div class="container">
                <?php if (isset($user_signIn)) { echo($user_signIn); } if (isset($wishlist_added)) {echo($wishlist_added); } if (isset($wishlist_added_already)) {echo($wishlist_added_already);} ?>
            </div>
            <!-- block two -->
            <div class="content">
                    <div class="d-flex bg-light mb-5 justify-content-between align-items-center">
                        <div class="options col d-flex justify-content-center">
                            <i class="bi text-muted flex-shrink-0 me-1"><i class="fa fa-truck fa-2x"></i></i>
                            <div><strong>Delivery In Accra.</strong></div>
                        </div>
                        <div class="options col d-flex justify-content-center px-3">
                            <i class="bi text-muted flex-shrink-0 me-1"><i class="fa fa-money fa-2x"></i></i>
                            <div><strong>Cash On Delivery.</strong></div>
                        </div>
                        <div class="options col d-flex d-none d-sm-block">
                            <i class="bi text-muted flex-shrink-0 me-1"><i class="fa fa-headphones fa-2x"></i></i>
                            <div class="d-inline"><strong><big>24/7 Customer Support.</big></strong></div>
                        </div>
                    </div>

                    <!-- block three -->
                <div class="container">
                    <h1 class="fs-3">The Amazing Collections</h1>
                    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-4 row-cols-lg-4 align-items-stretch mb-5 p-0">

                        <div class="col mb-4">
                            <a href="./shop/view_one.php?product=Nike" class="text-decoration-none">
                                <div class="card align-items-center justify-content-center shadow-lg">
                                    <div class="bg-danger d-flex flex-column text-shadow-1">
                                        <!-- <h4>Nike</h4> -->
                                        <img style="height:70%;width:100%;padding:5px;" src="../public/img/s1.jpg" alt="Nike" class=" rounded-4">
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col mb-4">
                            <a href="./shop/view_one.php?product=Reebok" class="text-decoration-none">
                                <div class="card rounded-4 align-items-center justify-content-center shadow-lg">
                                    <div class="bg-warning d-flex flex-column text-shadow-1">
                                        <!-- <h4>Reebok</h4> -->
                                        <img style="height:70%;width:100%;padding:5px;" src="../public/img/s5.jpg" alt="Reebok" class=" rounded-4">
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col">
                            <a href="./shop/view_one.php?product=New" class="text-decoration-none">
                                <div class="card rounded-4 align-items-center justify-content-center shadow-lg">
                                    <div class="bg-success d-flex flex-column text-shadow-1">
                                        <!-- <h4>Plumbing Deals</h4> -->
                                        <!-- <img style="height:210px;" src="../public/img/plastic materials.webp" alt="img" class="img fluid img-fluid rounded-4"> -->
                                        <img style="height:70%;width:100%;padding:5px;" src="../public/img/s6.jpg" alt="Reebok" class=" rounded-4">
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col">
                            <a href="./shop/view_one.php?product=MC Queen" class="text-decoration-none">
                                <div class="card rounded-4 align-items-center justify-content-center shadow-lg">
                                    <div class="bg-primary d-flex flex-column text-shadow-1">
                                        <!-- <h4>Expandable Products</h4> -->
                                        <!-- <img style="height:210px;" src="../public/img/45-liter-EPS-doos--scaled.webp" alt="img" class="img fluid img-fluid rounded-4"> -->
                                        <img style="height:70%;width:100%;padding:5px;" src="../public/img/s7.jpg" alt="Reebok" class=" rounded-4">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- block four -->
                    <div class="mb-5 p-0">
                        <div id="perfect_deals" class="row">
                            <h3 class="fs-3" style="text-align:center;">GiveAway Deals</h3>
                            <div class="row row-cols-2 p-0 row-cols-sm-2 row-cols-md-4">
                            <?php
                                $Fetch = mysqli_query($PDO, "SELECT * FROM `products` ORDER BY `P_name` ASC") or die("Error fetching products");
                                while($query = mysqli_fetch_array($Fetch)){ 
                                    $pid = $query['pid'];
                                    $p_name = $query['P_name'];
                                    $p_SKU = $query['P_Sku'];
                                    $p_price = $query['P_price'];
                                    $p_category = $query['P_category'];
                                    $p_image = $query['P_image'];
                                    $p_details = $query['P_detail'];
                                    $p_unit = $query['P_unit'];
                                    $p_stock = $query['P_qty'];
                                    ?>
                                    <div class="col mb-4">
                                        <div class="card shadow-sm">
                                            <a href="./shop/view.php?view=<?=$pid?>"><img class="bd-placeholder-img card-img-top" src="../public/img/<?=$p_image?>" width="300" height="230" alt="<?=$p_image?>"></a>
                                            <div class="card-body">
                                                <p class="card-text"><strong><?=$p_name?>
                                                    <i class="badge bg-danger">¢<?=$p_price?></i></strong></p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="btn-group">
                                                        <form action="" method="get">
                                                            <button type="submit" name="quick_view_btn" title="Quick View" class="btn btn-light btn-sm btn-outline-success"><i class="fa fa-eye fa-lg"></i></button>
                                                            <button type="submit" name="add_to_cart_btn" title="Add to cart" class="btn btn-light btn-sm btn-outline-warning" id="view_product"><i class="fa fa-cart-plus"></i></button>
                                                            <button type="submit" name="wishlist_btn" title="Add to wishlist" class="btn btn-light btn-sm btn-outline-danger"><i class="fa fa-heart fa-lg"></i></button>
                                                            <input type="hidden" name="central_product_ID" value="<?=$pid?>">
                                                        </form>
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
        </main>

        <!-- CART MODAL -->
        <div class="modal fade" id="wishlist_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cart_modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="wishlist_modalLabel">Cart</h1>
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
        <div class="modal fade" id="cart_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="wishlist_modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="" method="post">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="cart_modalLabel">Wishlists</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4"><img src="../public/img/<?=$modal_p_image?>" width="100" height="100" class="fluid img-fluid" alt="image"></div>
                                    <div class="col col-md-8">
                                        <strong>Product Name: </strong><i class="card-text"><?=$modal_p_name?></i><br/>
                                        <strong>Category: </strong><i class="text-danger"><?=$modal_p_category?></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="modal_submit_btn" class="btn btn-outline-secondary" data-bs-dismiss="modal">Checkout</button>
                            <!-- <button type="button" class="btn btn-primary">Understood</button> -->
                        </div>
                    </form>
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


        <!-- Footer -->
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
                    <h5>Connect With <a class="text-decoration-none text-warning" href="https://jamesakweter.online" target="_blank">James</a></h5>
                        <div class="col col-md-6">
                            <div class="jumbotrom_page-two">
                                <div class="try-body">
                                    <div id="first-one"></div>
                                    <div id="second-one">
                                        <div id="second-of-second"></div>
                                    </div>
                                    <div id="third-one"><a class=" text-light btn btn-info btn-outline-danger btn-lg mt-1" href="https://jamesakweter.online/projects" target="_balnk">My Projects</a></div>
                                    <div id="fourth-one"></div>
                                    <div id="fifth-one"><a class="btn btn-warning btn-outline-dark btn-lg mt-1" href="mailto:jamesakweter@gmail.com">Contact Me</a></div>
                                </div>
                            </div>
                        </div>
                        <!-- <form>
                        <h5>Subscribe to our newsletter</h5>
                        <p>Monthly digest of what's new and exciting from us.</p>
                        <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                            <label for="newsletter1" class="visually-hidden">Email address</label>
                            <input id="newsletter1" type="text" class="form-control" placeholder="Email address">
                            <button class="btn btn-primary" type="button">Subscribe</button>
                        </div>
                        </form> -->
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

        <script src="../../node_modules/bootstrap.min.js"></script>
    </body>
</html>
