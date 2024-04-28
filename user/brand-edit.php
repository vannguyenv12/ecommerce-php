<?php require_once "./include/header.php"; ?>
<?php require_once "./include/navbar.php"; ?>
<?php require_once "./include/sidebar.php"; ?>

<?php
$brand = $db->query("brands", "id", $_GET['id']);

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
        $uploadedFileName = $brand->logo;
    }

    $db->update(
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

        ],
        "id",
        $_GET['id']
    );

    $brandId =  $_GET['id'];
    echo "<script>
    sessionStorage.setItem('reloadingUpdate', 'true');
    window.location.href = 'brand-edit.php?id=$brandId';</script>
    ";
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
                                            <input type="text" class="form-control" name="name" value="<?= $brand->name ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Status</label>
                                    <select class="form_control select2" name="status">
                                        <option <?= $brand->status == 1 ? 'selected' : '' ?> value="1">Enabled</option>
                                        <option <?= $brand->status == 0 ? 'selected' : '' ?> value="0">Disabled</option>
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

<script>
    $(document).ready(function() {
        window.onload = showMessage();

        function showMessage() {
            var reloading = sessionStorage.getItem("reloadingUpdate");
            if (reloading) {
                sessionStorage.removeItem("reloadingUpdate");
                Toastify({
                    text: "Updated Successfully",
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