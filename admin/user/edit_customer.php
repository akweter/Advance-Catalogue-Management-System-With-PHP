<?php
    session_start();
    // error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    include_once("../../database/config.php");

    $admin_signup =  $_SESSION['admin_sign_up'];
    $admin_login = $_SESSION['admin_login'];
    $admin_username = $_SESSION['admin_username'];
    $status = $_SESSION['admin'];

    if (empty($admin_login) || empty($admin_signup)) {
        header('location: ./auth/login.php');
    }

    if (isset($_GET['editCustomer'])) {
        $centralID = $_GET['editCustomer'];
    }

    // FETCH USER DETAILS AND DISPLAY IT
    if (! empty($_GET['editCustomer'])) {
        $cus_id = $_GET['editCustomer'];

        $customer_id = mysqli_query($PDO, "SELECT * FROM `customers` WHERE C_id = '$cus_id'");
        while($Val = mysqli_fetch_array($customer_id)){
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
          $user_password = $Val['PassWD'];
          $user_region = $Val['P_region'];
        }
      }
      else {
        header("location: ./");
      }

    //   POST CUSTOMER DATA TO THE CUSTOMER DB
    if (isset($_POST['update_customer'])) {
        $c_id = filter_var($_POST['cid'], FILTER_SANITIZE_STRING);;
        $c_fn = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
        $c_ln = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
        $c_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $c_username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $c_city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
        $c_town = filter_var($_POST['town'], FILTER_SANITIZE_STRING);
        $c_country = 'Ghana';
        $c_status = 'customer';
        $c_passwd = filter_var($_POST['passwd'], FILTER_SANITIZE_STRING);
        $c_phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
        $c_region = filter_var($_POST['region'], FILTER_SANITIZE_STRING);
        $c_zip_code = filter_var($_POST['gps'], FILTER_SANITIZE_STRING);
        $c_avatar = filter_var($_POST['avatar']);
  
        
        $update = mysqli_query($PDO, "UPDATE `customers` SET `C_fn`='$c_fn',`C_ln`='$c_ln',`C_country`='$c_country',`C_city`='$c_city',`C_town`='$c_town',`C_GPS`='$c_zip_code',`C_image`='$c_avatar',`email_Add`='$c_email',`Username`='$c_username',`Telephone`='$c_phone',`Status`='$c_status',`PassWD`='$c_passwd',`P_region`='$c_region' WHERE C_id=$centralID");

        if (isset($update)) {
            $customer_update = '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Customer details updated successfully!</strong>
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
        <link rel="icon" sizes="180x180" href="../../public/img/glass.webp">
        <link rel="apple-touch-icon" sizes="180x180" href="../../public/img/glass.webp">
        <title>Editing <?=$cus_fname?> <?=$cus_lname?> $Usename</title>
        <link rel="stylesheet" href="../../node_modules/bootstrap/bootstrap.min.css">
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
        </header>

        <!-- Main Content -->
        <main class="container mt-4 mb-5">
            <a class="btn btn-warning mb-4" href="./">Go back</a>
            <?php if(isset($customer_update)){echo($customer_update);} ?>
            <form method="post">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" id="username" name="username" value="<?=$user_name?>">
                                    <label for="username">Username</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input  value="<?=$cus_email?>" type="email" class="form-control rounded-3" id="email" name="email">
                                    <label for="email">Email</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" id="fname" name="fname"  value="<?=$cus_fname?>">
                                    <label for="fname">First Name</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input  value="<?=$cus_lname?>" type="text" class="form-control rounded-3" id="lname" name="lname" >
                                    <label for="lname">Last Name</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="tel" class="form-control rounded-3" id="phone" name="phone"  value="0<?=$cus_phone?>">
                                    <label for="phone">Telephone</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input  value="<?=$cus_email?>" type="text" class="form-control rounded-3" id="city" name="city" >
                                    <label for="city">City</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" id="town" name="town"  value="<?=$cus_town?>">
                                    <label for="town">Town</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" id="country" name="country"  value="<?=$cus_country?>">
                                    <label for="country">Country</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" id="region" name="region"  value="<?=$user_region?>">
                                    <label for="region">Region</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" id="GPS" name="gps"  value="<?=$cus_gps?>">
                                    <label for="gps">Zip Code</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="hidden" class="form-control rounded-3" id="passwd" name="passwd"  value="<?=$user_password?>">
                                    <label for="passwd">New Password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="avatar"></label>
                                    <input type="file" name="avatar" class="form-control form-control-lg" id="avatar">
                                </div>
                                <div>
                                    <input type="hidden" name="cid" value="<?php echo $centralID?>">
                                </div>
                            <hr>
                            <div>
                                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" data-bs-dismiss="modal" name="update_customer" type="submit">Update <?=$cus_fname?> <?=$cus_lname?></button>
                                <small class="text-muted">By clicking Sign up, you agree to our <a href="#">terms</a> and <a href="#">conditions</a></small>
                            <div>
            </form>
        </main>

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