<?php
require './helpers.php';
require basePath('config/database.php');
require basePath('services/Auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Auth($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirmPassword']);
    $auth->signUp();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    <title>FoodPark || Restaurant Template</title>
    <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="frontend-template/css/all.min.css">
    <link rel="stylesheet" href="frontend-template/css/bootstrap.min.css">
    <link rel="stylesheet" href="frontend-template/css/spacing.css">
    <link rel="stylesheet" href="frontend-template/css/slick.css">
    <link rel="stylesheet" href="frontend-template/css/nice-select.css">
    <link rel="stylesheet" href="frontend-template/css/venobox.min.css">
    <link rel="stylesheet" href="frontend-template/css/animate.css">
    <link rel="stylesheet" href="frontend-template/css/jquery.exzoom.css">

    <link rel="stylesheet" href="frontend-template/css/style.css">
    <link rel="stylesheet" href="frontend-template/css/responsive.css">
    <!-- <link rel="stylesheet" href="css/rtl.css"> -->
</head>

<body>



    <!--=========================
        SIGN UP START
    ==========================-->
    <section class="fp__signup" style="background: url(images/login_bg.jpg);">
        <div class="fp__signup_overlay pt_125 xs_pt_95 pb_100 xs_pb_70">
            <div class=" container">
                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-xxl-5 col-xl-6 col-md-9 col-lg-7 m-auto">
                        <div class="fp__login_area">
                            <h2>Welcome back!</h2>
                            <p>sign up to continue</p>
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>name</label>
                                            <input name="name" type="text" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>username</label>
                                            <input name="username" type="text" placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>email</label>
                                            <input name="email" type="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>password</label>
                                            <input name="password" type="password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>confirm password</label>
                                            <input name="confirmPassword" type="password" placeholder="Confirm Password">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <button type="submit" class="common_btn">Sign Up</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <p class="create_account">Alreadu have an account ? <a href="signin.php">login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=========================
        SIGN UP END
    ==========================-->




    <!--=============================
        SCROLL BUTTON START
    ==============================-->
    <div class="fp__scroll_btn">
        go to top
    </div>
    <!--=============================
        SCROLL BUTTON END 
    ==============================-->


    <!--jquery library js-->
    <script src="js/jquery-3.6.0.min.js"></script>
    <!--bootstrap js-->
    <script src="js/bootstrap.bundle.min.js"></script>
    <!--font-awesome js-->
    <script src="js/Font-Awesome.js"></script>
    <!-- slick slider -->
    <script src="js/slick.min.js"></script>
    <!-- isotop js -->
    <script src="js/isotope.pkgd.min.js"></script>
    <!-- simplyCountdownjs -->
    <script src="js/simplyCountdown.js"></script>
    <!-- counter up js -->
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.countup.min.js"></script>
    <!-- nice select js -->
    <script src="js/jquery.nice-select.min.js"></script>
    <!-- venobox js -->
    <script src="js/venobox.min.js"></script>
    <!-- sticky sidebar js -->
    <script src="js/sticky_sidebar.js"></script>
    <!-- wow js -->
    <script src="js/wow.min.js"></script>
    <!-- ex zoom js -->
    <script src="js/jquery.exzoom.js"></script>

    <!--main/custom js-->
    <script src="js/main.js"></script>

</body>

</html>