<?php
    error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    session_start();
    include_once("../../database/config.php");

    // FETCH USER DETAILS AND DISPLAY IT
    if (! empty($_GET['editOrder'])) {
        $cus_id = $_GET['editOrder'];
        
        $edit_order = mysqli_query($PDO, "SELECT * FROM `orders` WHERE o_orderID = $cus_id");
        while($Val = mysqli_fetch_array($edit_order)){
          $o_username = $Val['o_username'];
          $o_orderID = $Val['o_orderID']; 
          $o_subtotal = $Val['o_subtotal'];
          $o_total_payment = $Val['o_total_payment'];
          $o_product_id = $Val['o_product_id'];
          $o_qty = $Val['o_qty'];
          $o_paymentMode = $Val['o_paymentMode'];
          $status = $Val['status'];
          $o_time = $Val['o_time'];
          $o_date = $Val['o_date'];
        }

        $fetch_product = mysqli_query($PDO, "SELECT * FROM `products` WHERE pid = '$o_product_id'");
        while($Val = mysqli_fetch_array($fetch_product)){
            $new_pid = $Val['pid'];
            $o_product_name = $Val['P_name'];
        }

        $pname = $_POST['pname'];
        $get_product_id = mysqli_query($PDO, "SELECT * FROM `products` WHERE P_name = '$pname'");
        while($Val = mysqli_fetch_array($get_product_id)){
            $new_product_pid = $Val['pid'];
        }
      }
      else {
        header("location: ./"); 
      }

    // UPDATE PRODUCT IN THE DATABASE
    if (isset($_POST['update_product'])) {

        $new_id = filter_var($_POST['o_id'], FILTER_SANITIZE_STRING);;
        $new_o_username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $new_o_subtotal = filter_var($_POST['subtotal'], FILTER_SANITIZE_STRING);
        $new_o_total_payment = filter_var($_POST['tpayment'], FILTER_SANITIZE_STRING);
        $new_o_qty = filter_var($_POST['qty'], FILTER_SANITIZE_STRING);
        $new_o_paymentMode = filter_var($_POST['pmode'], FILTER_SANITIZE_STRING);
        $new_status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
        $new_o_time = filter_var($_POST['order_time'], FILTER_SANITIZE_STRING);
        $new_o_date = filter_var($_POST['order_date'], FILTER_SANITIZE_STRING);

        $update = mysqli_query($PDO, "UPDATE `orders` SET `o_username`='$new_o_username',`o_subtotal`='$new_o_subtotal',`o_total_payment`='$new_o_total_payment',`o_product_id`='$new_product_pid',`o_qty`='$new_o_qty',`o_paymentMode`='$new_o_paymentMode',`status`='$new_status',`o_time`='$new_o_time',`o_date`='$new_o_date' WHERE o_orderID=$new_id;");

        if (isset($update)) {
            $customer_update = '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Order updated successfully!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';

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
        <title>Edit Order | Online Market</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <!-- HEADER PAGE -->
        <header class="fixe-top">
            <div class="px-3 pt-2 text-bg-dark">
                <div class="container">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                        <a href="../" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                            <p class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><img style="border-radius:30%;" src="../../../public/img/logo.jpg" alt="logo" width="100" height="50"/></p>
                        </a>
                        <button class="navbar-toggler btn btn-outline-light btn-lg" type="button" data-bs-toggle="collapse" data-bs-target="#header-nav-bar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fa fa-bars fa-lg fa-2x color-light"></span>b
                        </button>
                        <div class="collapse navbar-collapse" id="header-nav-bar">
                            <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                                <li>
                                    <a href="../" class="nav-link text-secondary"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-home fa-2x" aria-hidden="true"></i> </p>Mart</a>
                                </li>
                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#cart_modal" class="nav-link text-white"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-cart-heart fa-lg"></i></p>Wishlist</a></li>
                                <li>
                                    <form action="" method="get">
                                        <input type="hidden" value="<?=$pid?>" name="get_wishlist_value">
                                        <a type="submit" data-bs-toggle="modal" data-bs-target="#wishlist_modal" class="nav-link text-white">
                                            <big class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-cart-plus fa-lg"></i> <?php if (isset($_SESSION['cartValue'])) { echo($customer_cart_value); };?></big>Cart
                                        </a>
                                    </form>
                                </li>
                                <li><a href="../../user_account/index.php" class="nav-link text-white"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i></p>Account</a></li>
                                <li><a href="#" class="nav-link text-white"><p data-bs-toggle="modal" data-bs-target="#contact_modal" class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-phone fa-2x" aria-hidden="true"></i></p>Contact</a></li>
                                <li>
                                  <a href="../../user_account/logout.php" class="nav-link text-white">
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
                  <form action="../../search/index.php" method="post">
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

        <!-- Main Content -->
        <main class="container mt-4 mb-5">
                    <a class="btn btn-warning mb-4" href="./">Go back</a>
                    <?php if(isset($customer_update)){echo($customer_update);} ?>
                    <form method="post">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="username" name="username" value="<?=$o_username?>" readonly>
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input value="<?=$o_subtotal?>" type="text" class="form-control rounded-3" id="email" name="subtotal">
                            <label for="email">Subtotal</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="fname" name="tpayment"  value="<?=$o_total_payment?>">
                            <label for="fname">Total Payment</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="pname" class="form-select" id="pname">
                                <option ><?php if (isset($o_product_name)){echo($o_product_name);}?></option>
                                <?php $loop_products = mysqli_query($PDO, "SELECT * FROM `products` ORDER BY P_name ASC");
                                while($Val = mysqli_fetch_array($loop_products)){
                                    $new_name = $Val['P_name'];?>
                                    <option value="<?=$new_name?>"><?=$new_name?></option>
                                <?php } ?>
                            </select>
                            <label for="pname">Product Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input  value="<?=$o_qty?>" type="text" class="form-control rounded-3" id="qty" name="qty" >
                            <label for="qty">Quantity</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input readonly value="<?=$o_paymentMode?>" type="text" class="form-control rounded-3" id="pmode" name="pmode" >
                            <label for="pmode">Payment Mode</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="status" class="form-select" id="status">
                                <option ><?php if (isset($status)){echo($status);}?></option>
                                <option value="Pending">Pending</option>
                                <option value="Cancelled">Cancelled</option>
                                <option value="Processing">Processing</option>
                                <option value="Delivered">Delivered</option>
                                <option value="On Hold">On Hold</option>
                            </select>
                            <label for="phone">Order Status</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input  value="<?=$o_time?>" type="text" class="form-control rounded-3" id="order_time" name="order_time" readonly>
                            <label for="order_time">Time</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="order_date" name="order_date"  value="<?=$o_date?>" readonly>
                            <label for="order_date">Date</label>
                        </div>
                        <div><input type="hidden" name="o_id" value="<?=$o_orderID?>"></div>
                        <hr>
                        <div>
                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" name="update_product" type="submit">Update Product</button>
                            <small class="text-muted">By clicking Sign up, you agree to our <a href="#">terms</a> and <a href="#">conditions</a></small>
                        <div>
                    </form>
                </div>
        </main>

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
        <script src="../../node_modules/bootstrap.min.js"></script>
    </body>
</html>
