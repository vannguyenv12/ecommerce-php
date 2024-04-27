<?php require_once "./include/header.php"; ?>
<?php require_once "./include/navbar.php"; ?>
<?php require_once "./include/sidebar.php"; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDirectory = '../uploads/brands';

    if ($_FILES['logo'] && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $uploadedFileName = uploadImage($_FILES['logo'], $uploadDirectory);
        if ($uploadedFileName !== false) {
            // echo 'Hình ảnh đã được tải lên thành công với tên: ' . $uploadedFileName;
        } else {
            echo $error;
            exit;
        }
    } else {
        echo $error;
        exit;
    }

    $db->insert(
        'brands',
        [
            "name",
            "status",
            "logo"
        ],
        [
            $_POST["name"],
            $_POST["status"],
            $uploadedFileName

        ]
    );

    echo $success;
}

?>


<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Form</h1>
            <div class="ml-auto">
                <a href="" class="btn btn-primary"><i class="fas fa-plus"></i> Button</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Status</label>
                                    <select class="form_control select2" name="status">
                                        <option value="1">Enabled</option>
                                        <option value="0">Disabled</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Logo</label>
                                    <div>
                                        <input type="file" name="logo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>