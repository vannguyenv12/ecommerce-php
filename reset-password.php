<?php
require_once './config/database.php';
require_once './helpers.php';
require_once './services/index.php';
require_once './services/Auth.php';
require_once './services/email.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $user = Auth::findUserByToken($_POST['token']);

    print_r($user);

    if (isset($user)) {
        if ($_POST['password'] !== $_POST['confirm_password']) {
            echo "<script>
                sessionStorage.setItem('isPasswordInvalid', 'true');
                window.location.href = './reset-password.php?token=$token';</script>
                ";
        } else {
            $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $db->update(
                "users",
                ["password", "reset_password_token"],
                [$hashedPassword, null],
                "reset_password_token",
                $_POST['token']
            );
            echo "<script>
                sessionStorage.setItem('isPasswordValid', 'true');
                window.location.href = './reset-password.php?token=$token';</script>
                ";
        }
    } else {

        echo "<script>
        sessionStorage.setItem('isTokenInvalid', 'true');
        window.location.href = './reset-password.php?token=$token';</script>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <link rel="icon" type="image/png" href="uploads/favicon.png">

    <title>Admin Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="user/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="user/dist/css/font_awesome_5_free.min.css">
    <link rel="stylesheet" href="user/dist/css/select2.min.css">
    <link rel="stylesheet" href="user/dist/css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="user/dist/css/duotone-dark.css">
    <link rel="stylesheet" href="user/dist/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="user/dist/css/iziToast.min.css">
    <link rel="stylesheet" href="user/dist/css/fontawesome-iconpicker.min.css">
    <link rel="stylesheet" href="user/dist/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="user/dist/css/style.css">
    <link rel="stylesheet" href="user/dist/css/components.css">
    <link rel="stylesheet" href="user/dist/css/air-datepicker.min.css">
    <link rel="stylesheet" href="user/dist/css/spacing.css">
    <link rel="stylesheet" href="user/dist/css/custom.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">


    <script src="user/dist/js/jquery-3.7.0.min.js"></script>
    <script src="user/dist/js/bootstrap.bundle.min.js"></script>
    <script src="user/dist/js/popper.min.js"></script>
    <script src="user/dist/js/tooltip.js"></script>
    <script src="user/dist/js/jquery.nicescroll.min.js"></script>
    <script src="user/dist/js/moment.min.js"></script>
    <script src="user/dist/js/stisla.js"></script>
    <script src="user/dist/js/jscolor.js"></script>
    <script src="user/dist/js/bootstrap-tagsinput.min.js"></script>
    <script src="user/dist/js/select2.full.min.js"></script>
    <script src="user/dist/js/jquery.dataTables.min.js"></script>
    <script src="user/dist/js/dataTables.bootstrap4.min.js"></script>
    <script src="user/dist/js/iziToast.min.js"></script>
    <script src="user/dist/js/fontawesome-iconpicker.js"></script>
    <script src="user/dist/js/air-datepicker.min.js"></script>
    <script src="user/dist/tinymce/tinymce.min.js"></script>
    <script src="user/dist/js/bootstrap4-toggle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <section class="section">
                <div class="container container-login">
                    <div class="row">
                        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                            <div class="card card-primary border-box">
                                <div class="card-header card-header-auth">
                                    <h4 class="text-center">Reset Password</h4>
                                </div>
                                <div class="card-body card-body-auth">
                                    <form method="POST" action="">
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password" placeholder="Password" value="" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="confirm_password" placeholder="Retype Password" value="">
                                        </div>
                                        <input type="hidden" name="token" value="<?= $_GET['token'] ?>" />
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-lg w_100_p">
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="dist/js/scripts.js"></script>
    <script src="dist/js/custom.js"></script>

    <script>
        $(document).ready(function() {
            window.onload = showMessage();

            function showMessage() {
                var reloadingFailEmail = sessionStorage.getItem("isTokenInvalid");
                if (reloadingFailEmail) {
                    sessionStorage.removeItem("isTokenInvalid");
                    Toastify({
                        text: "The reset token is invalid!",
                        duration: 4000,
                        gravity: "top", // `top` or `bottom`
                        position: "center", // `left`, `center` or `right`
                        style: {
                            background: "red",
                        },
                    }).showToast();
                }

                var reloadingSentEmailError = sessionStorage.getItem("isPasswordInvalid");
                if (reloadingSentEmailError) {
                    sessionStorage.removeItem("isPasswordInvalid");
                    Toastify({
                        text: "Passwords are not same, try again!",
                        duration: 4000,
                        gravity: "top", // `top` or `bottom`
                        position: "center", // `left`, `center` or `right`
                        style: {
                            background: "red",
                        },
                    }).showToast();
                }

                var reloadingSentEmailSuccess = sessionStorage.getItem("isPasswordValid");
                if (reloadingSentEmailSuccess) {
                    sessionStorage.removeItem("isPasswordValid");
                    Toastify({
                        text: "Reset password successfully!",
                        duration: 4000,
                        gravity: "top", // `top` or `bottom`
                        position: "center", // `left`, `center` or `right`
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                    }).showToast();
                }

            }


        });
    </script>
    </script>

</body>

</html>