<?php require_once "./include/header.php"; ?>
<?php require_once "./include/navbar.php"; ?>
<?php require_once "./include/sidebar.php"; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db->insert(
        "user_addresses",
        ['user_id', 'name', 'email', 'phone', 'address'],
        [$_SESSION['user']->id, $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address']]
    );

    echo $success;
}

?>


<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Form</h1>
            <div class="ml-auto">
                <a href="./addresses.php" class="btn btn-primary"><i class="fas fa-minus"></i> Back</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Mobile Phone</label>
                                            <input type="text" class="form-control" name="phone" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Address</label>
                                            <input type="email" class="form-control" name="address" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>