<?php
    error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    session_start();
    include_once("../../database/config.php");
    
    $admin_signup =  $_SESSION['admin_sign_up'];
    $admin_login = $_SESSION['admin_login'];
    $admin_username = $_SESSION['admin_username'];
    $status = $_SESSION['admin'];

    if (empty($admin_login) || empty($admin_signup)) {
        header('location: ./auth/login.php');
    }

    // DELETE CUSTOMER
    if(isset($_GET['eraseCustomer'])){
        $delete_customer = $_GET['eraseCustomer'];
        $Erase = mysqli_query($PDO, "DELETE FROM `customers` WHERE C_id = $delete_customer");
        header("location: ./");
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
        <link rel="icon" sizes="180x180" href="../../public/img/wheat.jpg">
        <link rel="apple-touch-icon" sizes="180x180" href="../../public/img/wheat.jpg">
        <title>User Details</title>
        <link rel="stylesheet" href="../../node_modules/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <!-- Header admin_username -->
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
        </header>

        <nav style="float:right;margin:1% 10% 1% 0 ">
            <a href="./" class="btn btn-outline-secondary btn-warning ">Go Back</a>
        </nav>

         <!-- Main Content -->
        <main class="container mb-5">
            <?php
            // DISPLAY CUSTOMER DATA VIA ID
            if (isset($_GET['customerDetails']) || $_POST['customerDetails']) {
                $customer_id = $_GET['customerDetails'];
                $fetch_arrays = mysqli_query($PDO, "SELECT * FROM `customers` WHERE C_id = '$customer_id' ");

                while($Val = mysqli_fetch_array($fetch_arrays)){
                    $cid = $Val['C_id'];
                    $c_Fname = $Val['C_fn'];
                    $c_Lname = $Val['C_ln'];
                    $c_Email = $Val['email_Add'];
                    $c_Username = $Val['Username'];
                    $c_Phone = $Val['Telephone'];
                    $c_GPS = $Val['C_GPS'];
                    $c_Country = $Val['C_country'];
                    $c_City = $Val['C_city'];
                    $c_Town = $Val['C_town'];
                    $c_Image = $Val['C_image'];
                    $c_Region = $Val['P_region'];
                    // $c_Password = $Val['PassWD'];
                    $c_Status = $Val['Status']; ?>

                    <table class="table table-hover">
                        <tbody>
                            <tr class="table-dark"><td><big>CUSTOMER</big></td><td><big>DETAILS</big></td></tr>
                            <tr><td>Username</td><td><?=$c_Fname?></td></tr>
                            <tr><td>First Name</td><td><?=$c_Fname?></td></tr>
                            <tr><td>Last Name</td><td><?=$c_Lname?></td></tr>
                            <tr><td>Telephone</td><td>0<?=$c_Phone?></td></tr>
                            <tr><td>Email</td><td><?=$c_Email?></td></tr>
                            <tr><td>Country</td><td><?=$c_Country?></td></tr>
                            <tr><td>Region</td><td><?=$c_Region?></td></tr>
                            <tr><td>City</td><td><?=$c_City?></td></tr>
                            <tr><td>Town</td><td><?=$c_Town?></td></tr>
                            <tr><td>Area Code</td><td><?=$c_GPS?></td></tr>
                            <!-- <tr><td>Password</td><td><?=$c_Password?></td></tr> -->
                        </tbody>
                    </table><?php
                }
            }

            // DISPLAY ADMIN DATA VIA ID
            if (isset($_GET['adminDetails']) || $_POST['adminDetails']) {
                $admin_id = $_GET['adminDetails'];
                $fetch_arrays = mysqli_query($PDO, "SELECT * FROM `customers` WHERE C_id = '$admin_id' ");

                while($Val = mysqli_fetch_array($fetch_arrays)){
                    $aid = $Val['Admin_id'];
                    $a_Email = $Val['email_Add'];
                    $a_Username = $Val['Username'];
                    $c_Image = $Val['Logo'];
                    $c_Password = $Val['PassWD'];
                    $c_Status = $Val['Status'];?>

                    <table class="table table-hover">
                        <tbody>
                            <tr class="table-dark"><td><big>ADMIN</big></td><td><big>DETAILS</big></td></tr>
                            <tr><td>Username</td><td><?=$a_Username?></td></tr>
                            <tr><td>Email</td><td><?=$a_Email?></td></tr>
                            <tr><td>Avatar</td><td><img src="<?=$c_Image?>" alt="<?=$a_Username?>"></td></tr>
                        </tbody>
                    </table><?php
                }        
            }
            ?>
            <a href="./edit_customer.php?editCustomer=<?php if(isset($customer_id)){echo($cid);} if(isset($admin_id)){echo($aid);}?>" class="btn btn-outline-light btn-primary">Edit <?php if(isset($customer_id)){echo($c_Fname. " ". $c_Lname);} if(isset($admin_id)){echo($a_Username);}?></a>
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