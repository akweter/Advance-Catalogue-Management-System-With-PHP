<?php
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
        <title>Order Received</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
      <!-- HEADER PAGE -->
      <header>
        <div class="px-3 pt-2 text-bg-dark">
          <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
              <a href="../" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                <img style="border-radius:30%;" src="../../../public/img/logo.jpg" alt="logo" width="50" height="45"/>
              </a>
              <button class="navbar-toggler btn btn-outline-light btn-lg" type="button" data-bs-toggle="collapse" data-bs-target="#header-nav-bar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars fa-lg fa-2x color-light"></span>.
              </button>
              <div class="collapse navbar-collapse" id="header-nav-bar">
                <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                  <li><a href="../" class="nav-link text-secondary"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-home fa-2x" ></i> </p>Mart</a></li>
                  <li><a href="#" data-bs-toggle="modal" data-bs-target="#cart_modal" class="nav-link text-white"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-cart-heart fa-lg"></i></p>Wishlist</a></li>
                  <li>
                    <form action="" method="get">
                      <input type="hidden" value="<?=$pid?>" name="get_wishlist_value">
                      <a type="submit" data-bs-toggle="modal" data-bs-target="#wishlist_modal" class="nav-link text-white">
                        <big class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-cart-plus fa-lg"></i> <?php if (isset($_SESSION['cartValue'])) { echo($customer_cart_value); };?></big>Cart
                      </a>
                    </form>
                  </li>
                  <li><a href="../../user_account/account_info.php" class="nav-link text-white"><p class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-user-plus fa-2x" ></i></p>Account</a></li>
                  <li><a href="#" class="nav-link text-white"><p data-bs-toggle="modal" data-bs-target="#contact_modal" class="bi d-block mx-auto mb-1" width="24" height="24"><i class="fa fa-phone fa-2x" ></i></p>Contact</a></li>
                  <li>
                    <a href="../../user_account/logout.php" class="nav-link text-white">
                      <p class="bi d-block mx-auto" width="24" height="24"><i class="fa fa-sign-out fa-2x" ></i></p>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="px-3 pb-2 border-bottom bg-dark">
            <form action="../../search/index.php" method="post">
              <div style="display:flex;flex-direction:row;">
                <div style="width:95%; margin-right:1%;"><input type="search" class="form-control" name="q" placeholder="Search..." aria-label="Search"></div>
              <div>
              <a type="submit" href=""><button class="btn btn-outline-light btn-warning" type="submit"><i class="fa  fa-search fa-lg"></i></button></a>
            </form>
        </div>
      </header>

      <main class="container pt-5 pb-5">
        <h3>Order Received</h3>
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6">Account Details</div>
          <div class="col-12 col-sm-12 col-md-6">Order Details</div>
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

      <script src="../../../../node_modules/bootstrap.min.js"></script>
    </body>
  </html>
