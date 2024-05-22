<?php require_once "../helpers.php"; ?>
<?php require_once basePath('config/database.php'); ?>
<?php require_once basePath('services/index.php'); ?>
<?php session_start();
ob_start(); ?>
<?php $db = new Database();  ?>
<?php

if (!isset($_SESSION['user']) || $_SESSION['user']?->role !== 'admin') {
    header('location: ../index.php');
}

$success = '
    <script>
    Toastify({

        text: "Created Successfully",
        duration: 5000,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
        },

    }).showToast();
    </script>
    ';

$deleteSuccess = '
    <script>
    Toastify({

        text: "Deleted Successfully",
        duration: 5000,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
        },

    }).showToast();
    </script>
    ';

$updateSuccess = '
    <script>
    Toastify({

        text: "Updated Successfully",
        duration: 5000,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
        },

    }).showToast();
    </script>
    ';

$uploadSuccess = '
    <script>
    Toastify({

        text: "Uploaded Successfully",
        duration: 5000,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
        },

    }).showToast();
    </script>
    ';

$error = '
    <script>
    Toastify({

        text: "Error, Please Upload Image",
        duration: 5000,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        style: {
            background: "red",
        },

    }).showToast();
    </script>
    ';

function toastErrorMessage($message)
{
    $error = "
    <script>
    Toastify({

        text: '$message',
        duration: 5000,
        gravity: 'center',
        position: 'right',
        style: {
            background: 'red',
            height: '30px',
            padding: '5px 5px',
        },

    }).showToast();
    </script>
    ";

    return $error;
}

$error = '
    <script>
    Toastify({

        text: "Error, Please Upload Image",
        duration: 5000,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        style: {
            background: "red",
        },

    }).showToast();
    </script>
    ';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <link rel="icon" type="image/png" href="uploads/favicon.png">

    <title>Admin Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/font_awesome_5_free.min.css">
    <link rel="stylesheet" href="dist/css/select2.min.css">
    <link rel="stylesheet" href="dist/css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="dist/css/duotone-dark.css">
    <link rel="stylesheet" href="dist/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="dist/css/iziToast.min.css">
    <link rel="stylesheet" href="dist/css/fontawesome-iconpicker.min.css">
    <link rel="stylesheet" href="dist/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="dist/css/style.css">
    <link rel="stylesheet" href="dist/css/components.css">
    <link rel="stylesheet" href="dist/css/air-datepicker.min.css">
    <link rel="stylesheet" href="dist/css/spacing.css">
    <link rel="stylesheet" href="dist/css/custom.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- Bootstrap Icons -->
    <link href="dist/css/bootstrapicons-iconpicker.min.css" rel="stylesheet" />
    <link href="dist/css/bootstrapicons-iconpicker.css" rel="stylesheet" />


    <script src="dist/js/jquery-3.7.0.min.js"></script>
    <script src="dist/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/popper.min.js"></script>
    <script src="dist/js/tooltip.js"></script>
    <script src="dist/js/jquery.nicescroll.min.js"></script>
    <script src="dist/js/moment.min.js"></script>
    <script src="dist/js/stisla.js"></script>
    <script src="dist/js/jscolor.js"></script>
    <script src="dist/js/bootstrap-tagsinput.min.js"></script>
    <script src="dist/js/select2.full.min.js"></script>
    <script src="dist/js/jquery.dataTables.min.js"></script>
    <script src="dist/js/dataTables.bootstrap4.min.js"></script>
    <script src="dist/js/iziToast.min.js"></script>
    <script src="dist/js/fontawesome-iconpicker.js"></script>
    <script src="dist/js/air-datepicker.min.js"></script>
    <script src="dist/tinymce/tinymce.min.js"></script>
    <script src="dist/js/bootstrap4-toggle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="dist/js/bootstrapicon-iconpicker.js"></script>
    <script src="dist/js/bootstrapicon-iconpicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('.iconpicker').iconpicker();
        });
    </script>
</head>

<body>
    <div id="app">
        <div class="main-wrapper">