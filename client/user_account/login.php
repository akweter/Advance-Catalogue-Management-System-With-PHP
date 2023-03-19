
<?php
    session_start();
    error_reporting(E_WARNING || E_NOTICE || E_ERROR);

        include_once("../../database/config.php");

        if(isset($_POST['signin'])){
            $cus_input_pass = $_POST['passd'];
            $customer_email = $_POST['email'];

            // Fetch all users from the database
            $Fetch = mysqli_query($PDO, "SELECT * FROM `customers` WHERE email_Add = '$customer_email'") or die("Error fetching email and password");

            while($query = mysqli_fetch_array($Fetch)){
                $cust_username = $query['Username'];
                $passWD = $query['PassWD'];
                $status = $query['Status'];
            }

            // VERIFY HASH PASSWORD IN THE DATABASE
            if (password_verify($cus_input_pass, $passWD)) {
                # REHASHING PASSWORD FOR USER/
                // if (password_needs_rehash($passWD, PASSWORD_DEFAULT)) {
                //     $new_pass_hash = password_hash($cus_input_pass, PASSWORD_DEFAULT);
                // }
                $_SESSION['cust_username'] = $cust_username;
                $_SESSION['status'] = $status;
                $_SESSION['cust_sign_up'] = 'true';
                $_SESSION['cust_login'] = 'true';
                header('location: ../');
            }
            else {
                $message = '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Wrong Password</strong>
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
        <title>Login</title>
        <link rel="stylesheet" href="../../../node_modules/bootstrap.min.css">
        <link rel="stylesheet" href="../../../node_modules/fontawesome.min.css">
        <style>
            html,
            body {
                height: 100%;
            }

            main{width: 60%;;}

            body {
                display: flex;
                align-items: center;
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #b9bfc0;;
            }

            .form-signin {
                max-width: 330px;
                padding: 15px;
                border-radius: 5% 10% 0 15%;
            }

            .form-signin .form-floating:focus-within {
                z-index: 2;
            }

            .form-signin input[type="email"] {
                margin-bottom: -1px;
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
            }

            .form-signin input[type="password"] {
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
        </style>
    </head>
    <body class="text-center">
        <main class="form-signin m-auto bg-light">
            <form method="post">
                <img class="mb-4" src="../../public/img/wheat.jpg" alt="" width="72" height="57">
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
                <?php if (isset($message)) { echo($message); } ?>
                <?php if (isset($login_success)) {echo($login_success); } ?>
                <div class="form-floating">
                    <input type="email" class="form-control" required id="floatingInput" name="email" placeholder="someone@domain.com">
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating">
                    <input type="password" required class="form-control" name="passd" id="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>
                <!-- <div class="form-floating">
                    <input type="password" required class="form-control" name="passd" id="password" placeholder="Confirm Password">
                    <label for="password">Confirm Password</label>
                </div> -->
                <div class="">
                    <a class="text-decoration-none" href="#">Forget Password</a>
                </div>            
                <div class="checkbox mb-3">
                    <label><input type="checkbox" value="remember-me"> Remember me</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" name="signin" type="submit">Sign in</button>
                <a href="./signup.php" class="btn btn-sm btn-warning mt-2">Sign up</a>
                <p class="mt-5 mb-3 text-muted">&copy; <?php echo date("Y");?> - #1 Largest Online Market</p>
            </form>
        </main>
        <script src="../../../node_modules/bootstrap.min.js"></script>
    </body>
</html>

