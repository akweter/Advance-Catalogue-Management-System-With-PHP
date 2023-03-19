<?php
    error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    session_start();
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
        <title>Search | #1 Online Market</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- <link rel="stylesheet" href="../../node_modules/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    </head>
    <body>
        <header class="fixe-top">
            <div class="px-3 pt-2 text-bg-dark">
                <div class="">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                        <a href="../" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                            <p class="container bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><img style="border-radius:30%;" src="../../public/img/logo.jpg" alt="logo" width="80" height="50"/></p>
                        </a>
                        <button class="navbar-toggler btn btn-outline-light btn-lg" type="button" data-bs-toggle="collapse" data-bs-target="#header-nav-bar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fa fa-bars fa-lg fa-2x color-light"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="header-nav-bar">
                            <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                                <li><a href="../" class="nav-link text-secondary"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-home fa-2x" aria-hidden="true"></i> </p>Mart</a></li>
                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#cart_modal" class="nav-link text-white"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-cart-plus fa-2x"></i></p>Cart</a></li>
                                <li>
                                    <form action="" method="get">
                                        <input type="hidden" value="<?=$pid?>" name="get_wishlist_value">
                                        <a type="submit" data-bs-toggle="modal" data-bs-target="#wishlist_modal" class="nav-link text-white">
                                            <p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-heart fa-2x"></i></p>Wishlist
                                        </a>
                                    </form>
                                </li>
                                <li><a href="../user_account/account_info.php" class="nav-link text-white"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i></p>Account</a></li>
                                <li><a href="#" class="nav-link text-white"><p data-bs-toggle="modal" data-bs-target="#contact_modal" class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-phone fa-2x" aria-hidden="true"></i></p>Contact</a></li>
                                <li><a href="../user_account/logout.php" class="nav-link text-white"><p class="bi d-block mx-auto" width="24" height="24"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></p></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-3 pb-3 border-bottom bg-dark">
                <div class="row">
                    <form action="./index.php" method="post">
                        <div style="display:flex;flex-direction:row;">
                            <div style="width:95%; margin-right:1%;">
                                <input type="search" class="form-control" name="q" placeholder="<?php if (isset($search_term)) {echo($search_term);}else{echo("I am looking for...");} ?>" aria-label="Search">
                            </div>
                            <div>
                                <a type="submit" href=""><button class="btn btn-outline-light btn-warning" type="submit"><i class="fa  fa-search fa-lg"></i></button></a>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </header>

    <main class="mt-5 mb-5 container">
    <?php
        include_once("../../database/config.php");

        if (! empty($_POST['q'])) {
            $search_term = $_POST['q'];

            if (! empty($search_term)) {
                $search = mysqli_query($PDO,"SELECT * FROM `products` WHERE CONCAT(P_name,P_detail) LIKE '%$search_term%' ORDER BY P_name ASC");
                
                if(mysqli_num_rows($search) > 0){
                    foreach($search as $data){
                        $new_name = $data['P_name'];
                        $pid = $data['pid'];
                        $new_image = $data['P_image'];
                        $new_category = $data['P_category'];?>
                        
                        <div class="list-group mt-2">
                            <a href="../shop/view.php?view=<?=$pid?>" class="list-group-item-action d-flex gap-3 text-decoration-none" aria-current="true">
                                <img src="../../public/img/<?=$new_image?>" alt="<?=$new_name?>" width="32" height="32" class="flex-shrink-0">
                                <div class="d-flex justify-content-between align-item-center">
                                    <p class="mb-0"><?=$new_name?> | <?=$new_category?></p>
                                </div>
                            </a>
                        </div> <?php
                    } 
                }
                else{
                    echo('<tr" colspan="6"><td colspan="6"><h2>No records found!</h2></td></tr><p></p><a href="../" class="btn btn-lg btn-warning">Vist shop</a></p> ');
                }
            }
            else {
                header('location: ../');
            } }
        // else {
        //     header('location: ../');
        // }
    ?>
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
                    <h5>Section</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Home</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Features</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Pricing</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">FAQs</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">About</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-2 mb-3">
                    <h5>Section</h5>
                    <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Home</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Features</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Pricing</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">FAQs</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">About</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-2 mb-3 d-none d-sm-block">
                    <h5>Section</h5>
                    <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Home</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Features</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Pricing</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">FAQs</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">About</a></li>
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
