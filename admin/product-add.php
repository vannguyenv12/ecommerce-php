<?php require_once "./include/header.php"; ?>
<?php require_once "./include/navbar.php"; ?>
<?php require_once "./include/sidebar.php"; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDirectory = '../uploads';

    if ($_FILES['image'] && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadedFileName = uploadImage($_FILES['image'], $uploadDirectory);
        if ($uploadedFileName !== false) {
            // echo 'Hình ảnh đã được tải lên thành công với tên: ' . $uploadedFileName;
        } else {
            echo $error;
        }
    } else {
        echo $error;
        exit;
    }

    $db->insert(
        'products',
        [
            "name",
            "price",
            "offer_price",
            "qty",
            "category_id",
            "brand_id",
            "short_description",
            "long_description",
            "status",
            "thumb_image"
        ],
        [
            $_POST["name"],
            $_POST["price"],
            $_POST["offer_price"],
            $_POST["qty"],
            $_POST["category_id"],
            $_POST["brand_id"],
            $_POST["short_description"],
            $_POST["long_description"],
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
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Price</label>
                                            <input type="number" class="form-control" name="price" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Offer Price</label>
                                            <input type="number" class="form-control" name="offer_price" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Quantity</label>
                                            <input type="number" class="form-control" name="qty" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Category</label>
                                    <select class="form_control select2" name="category_id">
                                        <option value=""></option>
                                        <?php
                                        $categoryList = $db->customQuery("SELECT * FROM categories", []);
                                        foreach ($categoryList as $category) {
                                        ?>
                                            <option value="<?= $category->id ?>"><?= $category->name ?></option>

                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Brand</label>
                                    <select class="form_control select2" name="brand_id">
                                        <option value=""></option>
                                        <?php
                                        $brandList = $db->customQuery("SELECT * FROM brands", []);
                                        foreach ($brandList as $brand) {
                                        ?>
                                            <option value="<?= $brand->id ?>"><?= $brand->name ?></option>

                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>



                                <div class="form-group mb-3">
                                    <label>Short Description</label>
                                    <textarea name="short_description" class="form-control editor" cols="30" rows="10"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Long Description</label>
                                    <textarea name="long_description" class="form-control h_100" cols="30" rows="10"></textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Status</label>
                                    <select class="form_control select2" name="status">
                                        <option value="1">Enabled</option>
                                        <option value="0">Disabled</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Image</label>
                                    <div>
                                        <input type="file" name="image">
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