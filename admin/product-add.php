<?php require_once "./include/header.php"; ?>
<?php require_once "./include/navbar.php"; ?>
<?php require_once "./include/sidebar.php"; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $validateFields = [
        'name' => 'Name is required',
        'price' => 'Price must be number',
        "offer_price" => 'Offer Price must be number',
        "qty" => 'Quantity must be number',
        "category_id" => 'Category must selected',
        "brand_id" => 'Brand must selected',
        "short_description" => 'Short description is required',
        "long_description" => 'Long description is required',
        "status" => 'Status is required',
    ];

    $errorMessages = [];

    foreach ($validateFields as $key => $field) {
        if (empty($_POST[$key])) {
            $errorMessages[$key] = $field;
        }
    }

    if (empty($_FILES['image']['name'])) {
        $errorMessages['image'] = 'Image is required';
    }

    if (count($errorMessages) <= 0) {
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
            // exit;
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
                                            <span class="text-danger"><?= $errorMessages['name'] ?? ''; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Price</label>
                                            <input type="number" class="form-control" name="price" value="">
                                            <span class="text-danger"><?= $errorMessages['price'] ?? ''; ?></span>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Offer Price</label>
                                            <input type="number" class="form-control" name="offer_price" value="">
                                            <span class="text-danger"><?= $errorMessages['offer_price'] ?? ''; ?></span>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Quantity</label>
                                            <input type="number" class="form-control" name="qty" value="">
                                            <span class="text-danger"><?= $errorMessages['qty'] ?? ''; ?></span>

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
                                    <span class="text-danger"><?= $errorMessages['category_id'] ?? ''; ?></span>

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
                                    <span class="text-danger"><?= $errorMessages['brand_id'] ?? ''; ?></span>

                                </div>



                                <div class="form-group mb-3">
                                    <label>Short Description</label>
                                    <textarea name="short_description" class="form-control editor" cols="30" rows="10"></textarea>
                                    <span class="text-danger"><?= $errorMessages['short_description'] ?? ''; ?></span>

                                </div>
                                <div class="form-group mb-3">
                                    <label>Long Description</label>
                                    <textarea name="long_description" class="form-control h_100" cols="30" rows="10"></textarea>
                                    <span class="text-danger"><?= $errorMessages['long_description'] ?? ''; ?></span>

                                </div>

                                <div class="form-group mb-3">
                                    <label>Status</label>
                                    <select class="form_control select2" name="status">
                                        <option value="1">Enabled</option>
                                        <option value="0">Disabled</option>
                                    </select>
                                    <span class="text-danger"><?= $errorMessages['status'] ?? ''; ?></span>

                                </div>

                                <div class="form-group mb-3">
                                    <label>Image</label>
                                    <div>
                                        <input type="file" name="image">

                                    </div>
                                    <span class="text-danger"><?= $errorMessages['image'] ?? ''; ?></span>
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