
<?php
    session_start();

    if ((! empty($_SESSION['login']) || (! empty($_SESSION['verify'])))) {
        header('location: ../index.php');
    }
    elseif ((! empty($_SESSION['login']) && (empty($_SESSION['verify'])))) {
        header('location: ./verify.php');
    }
    elseif (empty($_SESSION['signup'])){
        header('location: ./signup.php');
    }
    else {
        ?> 

<html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://pbs.twimg.com/profile_banners/1008452946/1355397074/1500x500">
    <link rel="icon" type="image/png" sizes="16x16" href="https://pbs.twimg.com/profile_banners/1008452946/1355397074/1500x500">
    <link rel="manifest" href="/site.webmanifest">
    <title>Verify</title>
    <link rel="stylesheet" href="../node_modules/bootstrap.min.css">
    <style>
        body{
            background: #6c757d!important;
        }
        h1{
            text-align: center;
            text-transform: capitalize;
            margin-bottom: 2%;
        }
        h5{
            text-align: center;
            color: red;
        }
        div.modal-content{
            border-radius: 20% 5% 20% 5%;
        }
        .info{
            width:100%;
            font-family:Verdana, Geneva, sans-serif; 
            font-size:11px; 
            padding:10px; 
            background:orange; 
            border:1px solid #F1F1F1;
            box-shadow: 0 0 20px #cbcbcb;
            -moz-box-shadow: 0 0 20px #cbcbcb;
            -webkit-box-shadow: 0 0 20px #cbcbcb;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px; 
            line-height:20px;
        }
    </style>
    </head>
        <body>

        <div class="py-5 modal-dialog">
                <div class="modal-content p-3 ">
                    <div class="modal-header pb-4 border-bottom-0">
                        <h1 class="fw-bold mb-0 fs-2 offset-2">Verify if you're human</h1>
                    </div>
                    <div class="modal-body rounded-3  pt-0">
                        <form method="post">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3" id="guess" name="guess" placeholder="Guess" required>
                                <label for="guess">Any random number</label>
                            </div>
                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-info" name="submit" type="submit">Okay</button>
                        </form>
                        <p>
                            <?php
                                if (! isset($_POST['guess'])) {
                                    echo('<p class="info"><big>Answer cannot be empty!</big></p>');
                                }
                                elseif (! is_numeric($_POST['guess'])) {
                                    echo('<p class="info"><big>Your value should be numeric</big></p>');
                                }
                                elseif (($_POST['guess']) > 33 || ($_POST['guess'] == 33) ) {
                                    echo('<p class="info"><big>Value should be less than 33</big></p>');
                                }
                                elseif (($_POST['guess'] < 31 ) || ($_POST['guess'] == 31) ) {
                                    echo('<p class="info"><big>Try answer greater than 31</big></p>');
                                }
                                else {
                                    if (isset($_POST['guess'])) {
                                        $_SESSION['login'] = 'true';
                                        $_SESSION['verify'] = 'verified';
                                        echo("<script type='text/javascript'>alert('Verified')</script>");
                                        header('location: ../index.php');
                                    }
                                    
                                    // ($_POST['guess'] == 32 )
                                }
                                // else {
                                //     echo('<h5>Try Again!</h5>');
                                // }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
    }
?>