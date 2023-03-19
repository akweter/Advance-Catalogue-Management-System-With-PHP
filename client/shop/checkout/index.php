
  <?php
    // error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    
    session_start();
    include_once("../../../database/config.php");

    // GRAB CHECKOUT VALUE FROM THE SESSION
    if (! empty($_SESSION['cartValue'])) {
      $customer_cart_value = $_SESSION['cartValue'];

      $promo_notice = '
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Use promo Code <kbd>AKWETER23</kbd> for 5% discount!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    else {
      header("location: ../");
    }

    // COMPARE CHECKOUT ID TO THE ONE IN DATABASE
    if (! empty($_GET['checkoutID'])) {
      $checkout_id = $_GET['checkoutID'];
      
      $fetch_arrays = mysqli_query($PDO, "SELECT * FROM `products` WHERE pid = '$checkout_id'");
      while($Val = mysqli_fetch_array($fetch_arrays)){
        $new_pid = $Val['pid'];
        $new_name = $Val['P_name'];
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

    // FETCH USER INFORMATION TO COMPLETE THE CHECOUT
      if (! empty(isset($_SESSION['cust_username']))) {
        $cus_username = $_SESSION['cust_username'];

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

    // DELETE CHECKOUT PRODUCT
    if(isset($_POST['delete_checkout_product'])){
      unset($_SESSION['cartValue']);
      header("header: ../"); // customer_cart_value
    }

    // UPDATE BASKET
    if (isset($_POST['checkout_qty'])) {
      $new_cart_value = $_POST['checkout_qty'];
      $_SESSION['cartValue'] = $new_cart_value;
      $customer_cart_value = $new_cart_value;
    }

    // COMPUTE CART VALUE
    $cart_price_value = $customer_cart_value*$new_price;

    // APPLY COUPON
    if ((isset($_POST['coupon_redeem'])) && (! empty($_POST['coupon_redeem']))) {
      $coupon_value = $_POST['coupon_redeem'];
      if ($coupon_value == 'AKWETER23') {
        $discount = 0.95;
        $disount_given = $cart_price_value*$discount;
      }
      else { echo('<script>alert("Wrong Code - Try Again!");</script>');}
    }

    // FINAL CHECKOUT
    if (isset($_POST['final_checkout'])) {
      
      // CUSTOMER INFORMATION TO CUSTOMERS DB
      $c_id = '';
      $c_fn = filter_var($_POST['C_fn'], FILTER_SANITIZE_STRING);
      $c_ln = filter_var($_POST['C_ln'], FILTER_SANITIZE_STRING);
      $c_email = filter_var($_POST['email_Add'], FILTER_SANITIZE_STRING);
      $c_username = filter_var($_POST['Username'], FILTER_SANITIZE_STRING);
      $c_city = filter_var($_POST['C_city'], FILTER_SANITIZE_STRING);
      $c_town = filter_var($_POST['C_town'], FILTER_SANITIZE_STRING);
      $c_country = 'Ghana';
      $c_status = 'Customer';
      $PassWd = htmlspecialchars($_POST['pass1']);
      $c_passwd = password_hash($PassWd, PASSWORD_DEFAULT);
      $c_phone = filter_var($_POST['Telephone'], FILTER_SANITIZE_STRING);
      $c_region = filter_var($_POST['P_region'], FILTER_SANITIZE_STRING);
      $c_zip_code = filter_var($_POST['C_GPS'], FILTER_SANITIZE_STRING);

      $Query = mysqli_query($PDO, "SELECT * FROM `customers` WHERE Username = '$c_username'") or die("Error fetching email and password");

      if(mysqli_num_rows($Query) > 0){

        // GET USER ID FROM DB
        while($query = mysqli_fetch_array($Query)){
          $cust_id = $query['C_id'];
          $db_pass = $query['PassWD'];
        }
        // UPDATE USER INFO
        $update_customer = mysqli_query($PDO, "UPDATE `customers` SET `C_fn`='$c_fn',`C_ln`='$c_ln',`C_country`='$c_country',`C_city`='$c_city',`C_town`='$c_town',`C_GPS`='$c_zip_code',`C_image`='image',`email_Add`='$c_email',`Username`='$user_name',`Telephone`='$c_phone',`Status`='$c_status',`PassWD`='$db_pass',`P_region`='$c_region' WHERE C_id='$cust_id'");
      }
      else{
        // ADD NEW USER TO DB
        $add_new_customer = mysqli_query($PDO, "INSERT INTO `customers`(`C_id`, `C_fn`, `C_ln`, `C_country`, `C_city`, `C_town`, `C_GPS`, `C_image`, `email_Add`, `Username`, `Telephone`, `Status`, `PassWD`, `P_region`) VALUES ('$c_id','$c_fn','$c_ln','$c_country','$c_city','$c_town','$c_zip_code','','$c_email','$c_username','$c_phone','$c_status','$c_passwd','$c_region');");
        
        $_SESSION['cust_username'] = $c_username;
        $_SESSION['cust_sign_up'] = 'true';
        $_SESSION['cust_login'] = 'true';
      }
      
      // TO ORDER DB $name = filter_var($_POST['P_Name'], FILTER_SANITIZE_STRING);
      $o_username = filter_var($_POST['Username'], FILTER_SANITIZE_STRING);
      $o_orderID = '';
      $o_subtotal = $cart_price_value;
      $o_total_payment = $_POST['disount_given'];
      $o_product_id = $new_pid;
      $o_qty = $customer_cart_value;
      $o_paymentMode = $_POST['paymentMode'];
      $o_time = date("h:i:sa");
      $o_date = date("y/m/d");
      
      $add_new_order = mysqli_query($PDO, "INSERT INTO `orders`(`o_username`, `o_orderID`, `o_subtotal`, `o_total_payment`, `o_product_id`, `o_qty`, `o_paymentMode`, `status`, `o_time`, `o_date`) VALUES ('$o_username','$o_orderID','$o_subtotal','$o_total_payment','$o_product_id','$o_qty','$o_paymentMode', 'Processing', '$o_time','$o_date');");

      unset($_SESSION['cartValue']);
      
      if (isset($add_new_order)) {
        header("location: ./payment.php");
      }
      else {
        $order_error = '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Something is wrong with the your order!</strong>
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
                            <span class="fa fa-bars fa-lg fa-2x color-light"></span>.
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
                                <li><a href="../../user_account/account_info.php" class="nav-link text-white"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i></p>Account</a></li>
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

      <div class="container">
        <main>
          <?php if (isset($promo_notice)) { echo($promo_notice); } if (isset($cart_null_message)) { echo($cart_null_message); } if (isset($order_error)) { echo($order_error); }?>
          
          <div class="">
            <table class="table table-hover">
              <thead>
                <tr class="table-dark">
                  <th scope="col" colspan="3">Product</th>
                  <th scope="col">Price GH¢</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Subtotal</th>
                </tr>
              </thead>
              <form action="" method="post">
                <tbody>
                    <tr>
                      <td><button type="submit" name="delete_checkout_product" class="btn btn-outline-danger">X</button></td>
                      <td><img width="40" height="40" src="../../../public/img/<?=$new_image?>" alt="<?=$new_name?>"></td>
                      <td><a href="../view.php?view=<?=$new_pid?>"><?=$new_name?></a></td>
                      <td>¢ <?=$new_price?>.00</td>
                      <td><input type="text" name="checkout_qty" class="form-control" value="<?=$customer_cart_value?>"></td>
                      <td>¢ <?=$cart_price_value; ?>.00</td>
                    </tr>
                </tbody>
                <div class="row border">
                  <td colspan="2"><input type="text" name="coupon_redeem" placeholder="<?php if(isset($discount)){echo('AKWETER23');}else{echo('Coupon Code');} ?>" class="form-control"></td>
                  <td><button type="submit" class="btn btn-outline-warning btn-success form-control">Apply Coupon</button></td>
                  <td></td>
                  <td><button type="submit" class="btn btn-primary form-control"> Update Basket</button></td>
                  <td><h5>¢ <?=$cart_price_value;?>.00</h5></td>
                </div>
              </form>
            </table>
          </div>

          <div class="row g-5">
            <div class="col-md-5 col-lg-4 order-md-last">
              <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Your cart</span><span class="badge bg-primary rounded-pill">1 item</span>
              </h4>
                <li class="list-group-item d-flex justify-content-between bg-light">
                  <div class="text-success">
                    <h6 class="my-0"><?php if(isset($discount)){echo('DISCOUNT GIVEN');}else{echo("<div class='text-danger'>You Have No Discount</div>");} ?></h6>
                    <h6><?php if(isset($discount)){echo('CODE USED');}else{echo("");} ?></h6>
                  </div>
                  <div class="text-success">
                    <small><?php if(isset($discount)){echo('5%');}else{echo('0');} ?></small><br/>
                    <small class="my-0"><?php if(isset($discount)){echo('AKWETER23');}else{echo('');} ?></small>
                  </div>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <span class="fw-bold fs-5">Total (GHS)</span>
                  <strong><input class="form-control fs-4 fw-bold" name="disount_given" value="<?php if(isset($discount)){echo($disount_given);}else{echo($cart_price_value);} ?>" readonly/></strong>
                </li>
              </ul>
            </div>
            <div class="col-md-7 col-lg-8">
              <h4 class="mb-3">Billing address</h4>
              <form method="post" action="">
                <div class="row g-3">
                  <div class="col-sm-6">
                    <label for="firstName" class="form-label">First name</label>
                    <input type="text" class="form-control" name="C_fn" id="firstName" value="<?php if (isset($cus_fname)){echo($cus_fname);}?>" placeholder="" value="First Name" required>
                    <div class="invalid-feedback">Valid first name is required.</div>
                  </div>

                  <div class="col-sm-6">
                    <label for="lastName" class="form-label">Last name</label>
                    <input type="text" name="C_ln" class="form-control" id="lastName" placeholder="" value="<?php if (isset($cus_lname)){echo($cus_lname);}?>" required>
                    <div class="invalid-feedback">Valid last name is required.</div>
                  </div>

                  <div class="col-12">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text">@</span>
                      <input type="text" name="Username" class="form-control" id="username" value="<?php if (isset($user_name)){echo($user_name);}?>" placeholder="Username" required>
                      <div class="invalid-feedback">Your username is required.</div>
                    </div>
                  </div>

                  <div class="col-6">
                    <label for="address2" class="form-label">Password <span class="text-danger"> Required!</span></label>
                    <input type="text" name="pass1" class="form-control" id="password" placeholder="Strong Password">
                  </div>

                  <div class="col-6">
                    <label for="address2" class="form-label">Comfirm Password <span class="text-danger"> Required!</span></label>
                    <input type="text" name="pass2" class="form-control" id="password" placeholder="Strong Password">
                  </div>

                  <div class="col-12">
                    <label for="email" class="form-label">Email <span class="text-danger">Required!</span></label>
                    <input type="email" name="email_Add" class="form-control" id="email" placeholder="someone@domain.com" value="<?php if (isset($cus_email)){echo($cus_email);}?>">
                    <div class="invalid-feedback">Please enter a valid email address for shipping updates.</div>
                  </div>

                  <div class="col-12">
                    <label for="email" class="form-label">Telephone <span class="text-danger">Required!</span></label>
                    <input type="tel" name="Telephone" class="form-control" id="phone" placeholder="0540544760" value="<?php if (isset($cus_phone)){echo('0'.$cus_phone);}?>">
                    <div class="invalid-feedback">Please enter your number without the country code.</div>
                  </div>

                  <div class="col-12">
                    <label for="address" class="form-label">City</label>
                    <input type="text" name="C_city" class="form-control" id="city" value="<?php if (isset($cus_city)){echo($cus_city);}?>" placeholder="Accra" required>
                    <div class="invalid-feedback">Please enter your shipping address.</div>
                  </div>

                  <div class="col-12">
                    <label for="address2" class="form-label">Town</label>
                    <input type="text" name="C_town" class="form-control" id="town" value="<?php if (isset($cus_town)){echo($cus_town);}?>" placeholder="Lapaz">
                  </div>

                  <div class="col-md-5">
                    <label for="country" class="form-label">Country</label>
                    <select value="<?php if (isset($cus_country)){echo($cus_country);}?>" name="country" class="form-select" id="country" required>
                      <option disabled value="">Country</option>
                      <option value="Ghana">Ghana</option>
                    </select>
                    <div class="invalid-feedback">Shipping within Ghana only.</div>
                  </div>
                  
                  <div class="col-md-4">
                      <label for="region" class="form-label">Region</label>
                      <select name="P_region" class="form-select" id="region" required>
                        <option><?php if (isset($user_region)){echo($user_region);}?></option>
                        <option value="Ahafo">Ahafo</option>
                        <option value="Ashanti">Ashanti</option>
                        <option value="Bono East">Bono East</option>
                        <option value="Brong Ahafo">Brong Ahafo</option>
                        <option value="Central">Central</option>
                        <option value="Eastern">Eastern</option>
                        <option value="Greater Accra">Greater Accra</option>
                        <option value="North East">North East</option>
                        <option value="Northen">Northen</option>
                        <option value="Oti">Oti</option>
                        <option value="Savannah">Savannah</option>
                        <option value="Upper West">Upper West</option>
                        <option value="Upper East">Upper East</option>
                        <option value="Volta">Volta</option>
                        <option value="Western">Western</option>
                        <option value="Western North">Western North</option>
                      </select>
                      <div class="invalid-feedback">Shippling within these regions only.</div>
                  </div>

                  <div class="col-md-3">
                    <label for="zip" class="form-label">Zip <span class="text-success">Optional</span></label>
                    <input type="text" name="C_GPS" class="form-control" id="zip" value="<?php if (isset($cus_gps)){echo($cus_gps);}?>" class="form-select" placeholder="GC-3214-23">
                    <div class="invalid-feedback">Zip code.</div>
                  </div>
                </div>

                <hr class="my-4">

                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="same-address">
                  <label class="form-check-label" for="same-address" data-bs-toggle="dropdown">Shipping address different from billing address?</label>
                  <!-- <div class="dropdown" id="dropdown">
                    <ul class="dropdown-menu">
                      <li><h6 class="dropdown-header">Dropdown header</h6></li>
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Separated link</a></li>
                    </ul>
                  </div> -->
                </div>
                <!-- 
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="save-info">
                  <label class="form-check-label" for="save-info">Save this information for next time</label>
                </div> -->

                <hr class="my-4">

                <h4 class="mb-3">Payment</h4>

                <div class="my-3">
                  <div class="form-check">
                    <input id="creditiCard" name="paymentMode" value="Credit Card" type="radio" class="form-check-input" checked>
                    <label class="form-check-label" for="creditiCard">Credit card</label>
                    <!-- <div class="dropdown" id="dropdown">
                      <ul class="dropdown-menu">
                        <div class="row gy-3">
                          
                          <div class="col-md-6">
                            <label for="cc-name" class="form-label">Name on card</label>
                            <input type="text" class="form-control" id="cc-name" placeholder="" required>
                            <small class="text-muted">Full name as displayed on card</small>
                            <div class="invalid-feedback">Name on card is required</div>
                          </div>

                          <div class="col-md-6">
                            <label for="cc-number" class="form-label">Credit card number</label>
                            <input type="text" class="form-control" id="cc-number" placeholder="" required>
                            <div class="invalid-feedback">Credit card number is required</div>
                          </div>

                          <div class="col-md-3">
                            <label for="cc-expiration" class="form-label">Expiration</label>
                            <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                            <div class="invalid-feedback">Expiration date required</div>
                          </div>

                          <div class="col-md-3">
                            <label for="cc-cvv" class="form-label">CVV</label>
                            <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                            <div class="invalid-feedback">Security code required</div>
                          </div>

                        </div>
                      </ul>
                    </div> -->
                  </div>
                    <div class="form-check">
                      <input id="mobileMoney" value="Mobile Money" name="paymentMode" type="radio" class="form-check-input">
                      <label class="form-check-label" for="mobileMoney">Mobile Money</label>
                    </div>
                    <div class="form-check">
                      <input id="payOnDelivery" value="Pay On Delivery" name="paymentMode" type="radio" class="form-check-input">
                      <label class="form-check-label" for="payOnDelivery">Pay On Delivery</label>
                    </div>
                    <div class="form-check">
                      <input id="bank" value="Bank Payment" name="paymentMode" type="radio" class="form-check-input">
                      <label class="form-check-label" for="bank">Bank Payment</label>
                    </div>
                  </div>

                <hr class="my-4">
                <button class="w-100 btn btn-outline-primary btn-light btn-lg" name="final_checkout" type="submit">Continue to checkout</button>
                <hr class="my-4 mb-5">
              </form>
            </div>
          </div>
        </main>
      </div>

      <!-- CART MODAL -->
      <div class="modal fade" id="cart_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cart_modalLabel" aria-hidden="true">
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

      <script src="../../../../node_modules/bootstrap.min.js"></script>
    </body>
</html>
