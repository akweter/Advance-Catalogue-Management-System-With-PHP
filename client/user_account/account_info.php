<?php
    // error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    session_start();

    if (empty($_SESSION['cust_login'])) {
        header("location: ./login.php");
    }
    else {
        if (isset($_SESSION['cartValue'])) { $customer_cart_value = $_SESSION['cartValue']; }
        include_once("../../database/config.php");

        // FETCH USER INFORMATION TO COMPLETE THE CHECOUT
        if (! empty(isset($_SESSION['cust_username']))) {
            $cus_username = $_SESSION['cust_username'];

            // FETCH USER DETAILS PER THE USERNAME
            $customer_username = mysqli_query($PDO, "SELECT * FROM `customers` WHERE Username = '$cus_username'");
            while($Val = mysqli_fetch_array($customer_username)){
            $cus_fname = $Val['C_fn'];
            $cus_lname = $Val['C_ln']; 
            $cus_country = $Val['C_country'];
            $cus_city = $Val['C_city'];
            $cus_town = $Val['C_town'];
            $cus_gps = $Val['C_GPS'];
            $cus_image = $Val['C_image'];
            $cus_email = $Val['email_Add'];
            $cus_phone = $Val['Telephone'];
            $cus_status = $Val['Status'];
            $user_name = $Val['Username'];
            $user_region = $Val['P_region'];
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
        <title>Checkout | Online Market</title>
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
                            <span class="fa fa-bars   fa-2x color-light"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="header-nav-bar">
                            <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                                <li>
                                    <a href="../" class="nav-link text-secondary"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-home fa-lg" ></i> </p>Mart</a>
                                </li>
                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#cart_modal" class="nav-link text-white"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-heart fa-lg"></i></p>Wishlist</a></li>
                                <li>
                                    <form action="" method="get">
                                        <input type="hidden" value="<?=$pid?>" name="get_wishlist_value">
                                        <a type="submit" data-bs-toggle="modal" data-bs-target="#wishlist_modal" class="nav-link text-white">
                                            <big class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-cart-plus"></i> <?php if (isset($_SESSION['cartValue'])) { echo($customer_cart_value); };?></big>Cart
                                        </a>
                                    </form>
                                </li>
                                <li><a href="./index.php" class="nav-link text-white"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-user-plus fa-lg" ></i></p>Account</a></li>

                                <li><a href="#" class="nav-link text-white"><p data-bs-toggle="modal" data-bs-target="#contact_modal" class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-phone fa-lg" ></i></p>Contact</a></li>
                                <li>
                                  <a href="./logout.php" class="nav-link text-white">
                                    <p class="bi d-block mx-auto" width="24" height="24"><i class="fa fa-sign-out fa-2x" ></i></p>
                                  </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-3 pb-2 border-bottom bg-dark">
                <div class="container">
                  <form action="../search/index.php" method="post">
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
<!-- align-items-center justify-content-center -->
        <main>
            <div class="container mt-2 mb-5">
                <div class="row">
                    <div class="col-sm-12 col-md-6 mb-4">
                        <table class="table table-hover">
                            <tbody>
                                <tr style="text-align:center;" class="table-dark"><td colspan="2"><h2>User Account</h2></td></tr>
                                <tr><td>Username</td><td> <?php if(empty($user_name)){echo("<div>Edit here</div>");} else{echo($user_name);}?></td></tr>
                                <tr><td>First Name</td><td> <?php if(empty($cus_fname)){echo("<div>First name missing</div>");} else{echo($cus_fname);}?></td></tr>
                                <tr><td>Last Name</td><td> <?php if(empty($cus_lname)){echo("<div>Last name missing</div>");} else{echo($cus_lname);}?></td></tr>
                                <tr><td>Telephone</td><td> <?php if(empty($cus_phone)){echo("<div>Telephone number missing</div>");} else{echo("0".$cus_phone);}?></td></tr>
                                <tr><td>Email</td><td> <?php if(empty($cus_email)){echo("<div>Email missing</div>");} else{echo($cus_email);}?></td></tr>
                                <tr><td>Country</td><td> <?php if(empty($cus_country)){echo("<div>Country missing</div>");} else{echo($cus_country);}?></td></tr>
                                <tr><td>Region</td><td><?php if(empty($user_region)){echo("<div>Region missing</div>");} else{echo($user_region);}?></td></tr>
                                <tr><td>City</td><td><?php if(empty($cus_city)){echo("<div>City missing</div>");} else{echo($cus_city);}?></td></tr>
                                <tr><td>Town</td><td><?php if(empty($cus_town)){echo("<div>Town missing</div>");} else{echo($cus_town);}?></td></tr>
                                <tr><td>Area Code</td><td><?php if(empty($cus_gps)){echo("<div>Zip Code missing</div>");} else{echo($cus_gps);}?></td></tr>
                                <!-- <tr><td>Password</td><td><?=$c_Password?></td></tr> -->
                            </tbody>
                        </table>
                        <a href="./edit_customer.php?editCustomer=<?=$pid?>" class="btn btn-outline-primary btn-lg form-control">Edit My Account</a>
                    </div>

                    <div class="col-sm-12 col-md-6 mt-0">
                        <table class="table table-hover">
                            <tbody>
                                <tr style="text-align:center;" class="table-dark"><td colspan="6"><h2>Order History</h2></td></tr>
                                <tr class="table-secondary fw-bold"><td>Order ID</td><td>Date</td><td>Product</td><td>Status<td><td>Action</td></tr>
                                <?php
                                    // FETCH ORDER DETAILS PER THE USERNAME
                                    $view_order = mysqli_query($PDO, "SELECT * FROM `orders` WHERE o_username = '$cus_username' ");
                                    while($Val = mysqli_fetch_array($view_order)){
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

                                    $fetch_product = mysqli_query($PDO, "SELECT * FROM `products` WHERE pid = '$o_product_id'");
                                    while($Val = mysqli_fetch_array($fetch_product)){
                                        $product_name = $Val['P_name'];
                                    }
                                ?>
                                <tr>
                                    <td><?php if(! empty($o_orderID)){echo("WG".$o_orderID."h");}else{echo("");} ?></td>
                                    <td><?php if(! empty($o_date)){echo($o_date);}else{echo("");} ?></td>
                                    <td><a href="../shop/view.php?view=<?=$o_product_id?>" class="text-decoration-none"><?php if(! empty($product_name)){echo($product_name);}else{echo("");} ?></a></td>
                                    <td><?php if(! empty($status)){echo($status);}else{echo("");} ?><td>
                                    <td><a href="#" class="btn btn-outline-info btn-sm"><i class="fa fa-eye fa-lg"></i></a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        
        <!-- CART MODAL -->
        <div class="modal fade" id="cart_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cart_modalLabel" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="cart_modalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"><p>I will not close if you click outside me. Don't even try to press escape key.</p></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Understood</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- WISHLIST MODAL -->
        <div class="modal fade" id="wishlist_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="wishlist_modalLabel" >
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
                    <li class="ms-3"><a class="link-light fa twitter" href="#"><i class="fa fa-linkedin-square fa-2x" ></i></a></li>
                    <li class="ms-3"><a class="link-light" href="#"><p class="bi" width="24" height="24"><i class="fa fa-youtube-square fa-2x" ></i></p></a></li>
                    <li class="ms-3"><a class="link-light fa twitter" href="#"><i class="fa fa-twitter-square fa-2x" ></i></a></li>
                    <li class="ms-3"><a class="link-light" href="#"><p class="bi" width="24" height="24"><i class="fa fa-instagram fa-2x" ></i></p></a></li>
                    <li class="ms-3"><a class="link-light" href="#"><p class="bi" width="24" height="24"><i class="fa fa-facebook-official fa-2x" ></i></p></a></li>
                    <li class="ms-3"><a class="link-light" href="#"><p class="bi" width="24" height="24"><i class="fa fa-envelope fa-2x"></i></p></a></li>
                </ul>
                </div>
            </footer>
        </div>

    <script src="../../../node_modules/bootstrap.min.js"></script>
    </body>
</html>

<?php } ?>