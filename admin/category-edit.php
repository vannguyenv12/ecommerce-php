<?php require_once "./include/header.php"; ?>
<?php require_once "./include/navbar.php"; ?>
<?php require_once "./include/sidebar.php"; ?>

<?php
$category = $db->query("categories", "id", $_GET['id']);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDirectory = '../uploads/categories';

    if ($_FILES['image'] && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadedFileName = uploadImage($_FILES['image'], $uploadDirectory);
        if ($uploadedFileName !== false) {
            // echo 'Hình ảnh đã được tải lên thành công với tên: ' . $uploadedFileName;
        } else {
            echo $error;
        }
    } else {
        $uploadedFileName = $category->image;
    }

    $db->update(
        'categories',
        [
            "name",
            "status",
            "image"
        ],
        [
            $_POST["name"],
            $_POST["status"],
            $uploadedFileName

        ],
        'id',
        $_GET['id']
    );

    $categoryId =  $_GET['id'];
    echo "<script>
    sessionStorage.setItem('reloadingUpdate', 'true');
    window.location.href = 'category-edit.php?id=$categoryId';</script>
    ";
}

?>


<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Category</h1>
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
                                            <input type="text" class="form-control" name="name" value="<?= $category->name ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Status</label>
                                    <select class="form_control select2" name="status">
                                        <option <?= $category->status == 1 ? 'selected' : '' ?> value="1">Enabled</option>
                                        <option <?= $category->status == 0 ? 'selected' : '' ?> value="0">Disabled</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Image</label>
                                    <div>
                                        <input type="file" name="image">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update</button>
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