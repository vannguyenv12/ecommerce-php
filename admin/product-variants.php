<?php require_once "./include/header.php"; ?>
<?php require_once "./include/navbar.php"; ?>
<?php require_once "./include/sidebar.php"; ?>
<?php

$product = $db->query("products", "id", $_GET['id']);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db->insert("product_variants", ['product_id', 'name', 'status'], [$_GET['id'], $_POST['name'], 1]);
    echo $success;
}

?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1><?= $product->name ?></h1>
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

    <section class="section">
        <div class="section-header">
            <h1>Product Variants</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $productVariants = $db->customQuery("SELECT * FROM product_variants WHERE product_id = ?", [$_GET['id']]);

                                        foreach ($productVariants as $variant) {
                                        ?>
                                            <tr>
                                                <td><?= $variant->id ?></td>
                                                <td><?= $variant->name ?></td>
                                                <td class="pt_10 pb_10">
                                                    <a href="./product-variant-items.php?id=<?= $variant->id ?>" class="btn btn-warning"><i class="fas fa-eye"></i></a>
                                                    <a href="" class="btn btn-danger delete" data-id="<?= $variant->id; ?>"><i class="fas fa-trash"></i></a>
                                                </td>
                                                <div class="modal fade" id="modal_1" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Detail</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                                    <div class="col-md-4"><label class="form-label">Item Name</label></div>
                                                                    <div class="col-md-8">Laptop</div>
                                                                </div>
                                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                                    <div class="col-md-4"><label class="form-label">Description</label></div>
                                                                    <div class="col-md-8">This is a very good product. This is a very good product. This is a very good product. This is a very good product. This is a very good product. This is a very good product. </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                        <?php
                                        }
                                        ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php require_once './include/modal.php'; ?>
<?php require_once './include/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('.delete').click(function(e) {
            e.preventDefault();

            $('#myModal').modal('show');
            const variantId = $(this).attr("data-id");

            $('.confirm').click(function() {
                $.ajax({
                    type: 'POST',
                    url: 'product-variants-delete.php',
                    data: {
                        id: variantId
                    },
                    success: function(response) {
                        sessionStorage.setItem("reloading", "true");
                        window.location.reload();
                    }
                });
            })


        });


        window.onload = showMessage();

        function showMessage() {
            var reloading = sessionStorage.getItem("reloading");
            if (reloading) {
                sessionStorage.removeItem("reloading");
                Toastify({
                    text: "Deleted Successfully",
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