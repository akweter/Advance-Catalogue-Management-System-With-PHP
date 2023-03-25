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
    $search_product_name = mysqli_query($PDO, "SELECT * FROM `customers` ");
        while($Val = mysqli_fetch_array($search_product_name)){
            $user_name = $Val['Username'];
    }

    // POST ADMIN DATA TO THE ADMIN DB
    if(isset($_POST['Signup'])){
        if( empty($_POST['username']) || empty($_POST['email']) || empty($_POST['pass1']) ) {
            $fields_required = '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4>All fields are required!</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        elseif (($_POST['pass1']) != ($_POST['pass2'])) {
            $wrong_input = '
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h4>Passwords do not match</h4
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        else {
            $eAddress = htmlspecialchars($_POST['email']);
            $Username = htmlspecialchars($_POST['username']);
            $PassWd = htmlspecialchars($_POST['pass1']);
            $hash_admin_pass = password_hash($PassWd, PASSWORD_DEFAULT);
            $status = htmlspecialchars($_POST['admin_status']);
            $avatar = htmlspecialchars($_POST['avatar']);
            $admin_tel = htmlspecialchars($_POST['telephone']);

            // Comaparing user info to the one in the database
            $Data = "SELECT * FROM `customers` WHERE Username = '$Username' OR email_Add = '$eAddress' AND Status = 'Admin' ";
            $Query = mysqli_query($PDO, $Data) or die("Error fetching email and password");

            if(mysqli_num_rows($Query) > 0){
                $user_exists = '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h4>Username or Email not available!</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
            else{
                mysqli_query($PDO, "INSERT INTO `customers`(`C_id`, `C_fn`, `C_ln`, `C_country`, `C_city`, `C_town`, `C_GPS`, `C_image`, `email_Add`, `Username`, `Telephone`, `Status`, `PassWD`, `P_region`) VALUES ('', '', '', '', '', '', '', '$avatar', '$eAddress', '$Username', '$admin_tel', 'Admin', '$hash_admin_pass', '')");
                $user_added = '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4>New admin added sucessfully</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
        }
    }

    // POST CUSTOMER DATA TO THE DATABASE
    if(isset($_POST['add_new_customer_btn'])){
        if( empty($_POST['new_username']) || empty($_POST['new_email']) || empty($_POST['new_pass']) ) {
            $fields_required = '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4>All fields are required!</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        elseif (($_POST['new_pass']) != ($_POST['pass2'])) {
            $wrong_input = '
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h4>Passwords do not match</h4
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        else {
            $new_email = htmlspecialchars($_POST['new_email']);
            $new_username = htmlspecialchars($_POST['new_username']);
            $new_pass = htmlspecialchars($_POST['new_pass']);
            $hash_cus_pass = password_hash($new_pass, PASSWORD_DEFAULT);
            $avatar = htmlspecialchars($_POST['avatar']);
            $new_fname = htmlspecialchars($_POST['new_fname']);
            $new_lname = htmlspecialchars($_POST['new_lname']);
            $new_phone = htmlspecialchars($_POST['new_phone']);
            $new_town = htmlspecialchars($_POST['new_town']);
            $new_city = htmlspecialchars($_POST['new_city']);
            $new_region = htmlspecialchars($_POST['new_region']);
            $new_country = htmlspecialchars($_POST['new_country']);
            $new_gps = htmlspecialchars($_POST['new_gps']);

            // Comaparing user info to the one in the database
            $Data = "SELECT * FROM `customers` WHERE Username = '$new_username' OR email_Add = '$new_email' ";
            $Query = mysqli_query($PDO, $Data) or die("Error fetching email and password");

            if(mysqli_num_rows($Query) > 0){
                $user_exists = '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h4>Username or Email exists!</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
            else{
                mysqli_query($PDO, "INSERT INTO `customers`(`C_id`, `C_fn`, `C_ln`, `C_country`, `C_city`, `C_town`, `C_GPS`, `C_image`, `email_Add`, `Username`, `Telephone`, `Status`, `PassWD`, `P_region`) VALUES ('', '$new_fname', '$new_lname', '$new_country', '$new_city', '$new_town', '$new_gps', '$avatar', '$new_email', '$new_username', '$new_phone', 'Customer', '$hash_cus_pass', '$new_region')");

                $user_added = '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4>New Customer added sucessfully</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
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
        <link rel="icon" sizes="180x180" href="../../public/img/glass.webp">
        <link rel="apple-touch-icon" sizes="180x180" href="../../public/img/glass.webp">
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
                            <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><img src="../../public/img/wheat.jpg" width="50" height="50" alt="logo"></svg><h1 style="margin-left:50px;">Welcome <?php if (isset($admin_username)) {echo($admin_username);}?></i></h1>
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
                <form style="width:60%;" action="../search/index.php?user=<?=$user_name?>" method="POST" class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
                        <input type="search" name="product" class="form-control" placeholder="I am looking for..." aria-label="Search">
                    </form>

                    <div class="btn-toolbar mb-2 mb-md-0">
                        <h1>Users</h1>
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
                                <a href="../dashboard.php" class="nav-link text-decoration-none">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a href="../stock" class="nav-link text-decoration-none">Stock</a>
                            </li>
                            <li class="nav-item">
                                <a href="../product" class="nav-link text-decoration-none">Products</a>
                            </li>
                            <li class="nav-item">
                                <a href="../orders" class="nav-link text-decoration-none">Orders</a>
                            </li>
                            <li class="mb-1">
                                <div><button  class="nav-link btn btn-toggle d-inline-flex align-items-center rounded border-0">Users</button></div>
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
                            <img src="../../public/img/wheat.jpg" width="50" alt="Avatar">
                            </li>
                            
                        </ul>
                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <?php if (isset($user_added)) {echo($user_added);} if (isset($user_exists)) {echo($user_exists);} if (isset($wrong_input)) {echo($wrong_input);} if (isset($fields_required)) {echo($fields_required);} ?>

                    <div id="user_carousel" class="carousel slide">
                        <div class="carousel-inner">

                            <!-- ITEM ONE -->
                            <div class="carousel-item active">
                            <button data-bs-toggle="modal" data-bs-target="#add_customer_modal" class="btn btn-warning m-2">Add new customer</button>
                            <button data-bs-toggle="modal" data-bs-target="#add_new_admin_modal" class="btn btn-primary m-2">Add new admin</button>
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="table-dark">
                                            <th scope="col">#</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Email</th>
                                            <!-- <th scope="col">First Name</th> -->
                                            <th scope="col">Telephone</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                        <?php
                                        $Fetch = mysqli_query($PDO, "SELECT * FROM `customers` ORDER BY Status DESC") or die("Error fetching products");
                                        $num = 1;
                                                    
                                        while($query = mysqli_fetch_array($Fetch)){
                                            $username = $query['Username'];
                                            $user_id = $query['C_id'];
                                            $user_email = $query['email_Add'];
                                            $user_status = $query['Status'];
                                            $telephone = $query['Telephone'];
                                            $user_LName = $query['C_ln'];
                                        ?>
                                    <tbody>
                                        <tr>
                                            <td><?=$num++ ?></td>
                                            <td><?php if ($user_status == 'Admin') { echo("<div class=' fs-6'>$username</div>");}else { echo('<a href="./user_action.php?customerDetails='.$user_id.'" class="text-decoration-none">'.$username.'</a>');}?></td>
                                            <td><?php if ($user_status == 'Admin') { echo("<div class=' fs-6'>$user_email</div>");}else { echo($user_email);}?></td> 
                                            <!-- <td><?=$user_FName?></td> -->
                                            <td><?php if ($user_status == 'Admin') { echo("<div class=' fs-6'>0$telephone</div>");}else { echo('0'.$telephone);}?></td>
                                            <td><?php if ($user_status == 'Admin') { echo("<div class=' fs-6'>$user_status</div>");}else { echo($user_status);}?></td>
                                            <td><?php if ($user_status == 'Admin') { echo("<div class='text-danger fs-6'>Not Allowed</div>");}else { echo "
                                                <a onclick='return confirm('This operation is risky. Are you sure to delete?');' href='./user_action.php?eraseCustomer=$user_id' class='text-decoration-none'>Delete</a>
                                                <a href='./edit_customer.php?editCustomer=$user_id' class='text-decoration-none'>Edit</a>"; }?>
                                            </td>
                                        </tr>
                                    </tbody>
                                        <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
  
        <!-- ADD NEW CUSTOMER MODAL -->
        <div class="modal fade" id="add_customer_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="add_new_customer_modal">A New Customer Details</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input required type="text" class="form-control rounded-3" id="new_username" name="new_username" placeholder="Akweter5">
                                <label for="new_username">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input required type="email" class="form-control rounded-3" id="new_email" name="new_email" placeholder="john.doe@domain.com">
                                <label for="new_email">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input required type="text" class="form-control rounded-3" id="new_fname" name="new_fname" placeholder="Sena">
                                <label for="new_fname">First Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input required type="text" class="form-control rounded-3" id="email" name="new_lname" placeholder="Doe">
                                <label for="new_lname">Last Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input required type="tel" name="new_phone" class="form-control rounded-3" id="new_phone" placeholder="0549544632">
                                <label for="new_phone">Telephone</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input required type="text" name="new_city" class="form-control rounded-3" id="new_city" placeholder="Tamale">
                                <label for="new_city">City</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input required type="text" name="new_town" class="form-control rounded-3" id="new_town" placeholder="Tamale">
                                <label for="new_city">Town</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input required type="text" name="new_region" class="form-control rounded-3" id="new_region" placeholder="Northen Region">
                                <label for="new_region">Region</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input required type="text" name="new_country" class="form-control rounded-3" id="new_country" placeholder="Ghana">
                                <label for="new_city">Country</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input required type="text" name="new_gps" class="form-control rounded-3" id="new_gps" placeholder="A30W7">
                                <label for="new_gps">Zip Code</label>
                            </div>
                            <div class="form-floating mb-3">
                                <label for="avatar"></label>
                                <input type="file" name="avatar" class="form-control form-control-lg" id="avatar">
                            </div>
                            <div class="form-floating mb-3">
                                <input required type="password" name="new_pass" class="form-control rounded-3" id="new_pass" placeholder="Strong Password">
                                <label for="new_pass">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input required type="password" name="pass2" class="form-control rounded-3" id="pass2" placeholder="Confirm Password">
                                <label for="pass2">Confirm Password</label>
                            </div>
                            <div>
                                <input type="hidden" name="admin_status" value="customer">
                            </div>
                        </div>
                        <hr>
                        <div>
                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" name="add_new_customer_btn" type="submit" >Add New Customer</button>
                            <small class="text-muted">By clicking Sign up, you agree to our <a href="#">terms</a> and <a href="#">conditions</a></small>
                        </div>
                    </form>
                </div>
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

        <!-- ADD NEW ADMIN MODAL -->
        <div class="modal fade" id="add_new_admin_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add_new_admin_modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="add_new_admin_modalLabel">Add New Administrator</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <input required type="text" class="form-control rounded-3" id="username" name="username" placeholder="John1">
                                    <label for="username">Username</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input required type="email" class="form-control rounded-3" id="email" name="email" placeholder="john.doe@domain.com">
                                    <label for="email">Email</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input required type="tel" class="form-control rounded-3" id="telephone" name="telephone" placeholder="0540544760">
                                    <label for="telephone">Telephone</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input required type="password" name="pass1" class="form-control rounded-3" id="pass1" placeholder="Password">
                                    <label for="pass1">Password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input required type="password" name="pass2" class="form-control rounded-3" id="pass2" placeholder="Comfirm Password">
                                    <label for="pass2">Comfirm Password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="avatar"></label>
                                    <input type="file" name="avatar" class="form-control form-control-lg" id="avatar">
                                </div>
                                <div>
                                    <input type="hidden" name="admin_status" value="admin">
                                </div>
                        </div>
                        <div>
                            <hr>
                            <div>
                                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" data-bs-dismiss="modal" name="Signup" type="submit">Add New Admin</button>
                                <small class="text-muted">By clicking Sign up, you agree to our <a href="#">terms</a> and <a href="#">conditions</a></small>
                            <div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="../../../node_modules/bootstrap.min.js"></script>
    </body>
</html>
