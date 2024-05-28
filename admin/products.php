<?php require_once "./include/header.php"; ?>
<?php require_once "./include/navbar.php"; ?>
<?php require_once "./include/sidebar.php"; ?>


<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Products</h1>
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
                                            <th>Price</th>
                                            <th>Offer Price</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $productList = $db->customQuery("SELECT * FROM products", []);
                                        foreach ($productList as $product) {
                                        ?>
                                            <tr>
                                                <td><?= $product->id ?></td>
                                                <td><?= $product->name ?></td>
                                                <td>$<?= $product->price ?></td>
                                                <td>$<?= $product->offer_price ?></td>
                                                <td><?= $product->status ?></td>
                                                <td class="pt_10 pb_10">
                                                    <a href="./product-variants.php?id=<?= $product->id ?>" class="btn btn-warning"><i class="fas fa-eye"></i></a>
                                                    <a href="./product-gallery.php?id=<?= $product->id ?>" class="btn btn-secondary"><i class="fas fa-image"></i></a>
                                                    <a href="./product-edit.php?id=<?= $product->id; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                    <a href="" class="btn btn-danger delete" data-id="<?= $product->id; ?>"><i class="fas fa-trash"></i></a>
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



</div>
</div>

<?php require_once "./include/modal.php"; ?>


<script src="dist/js/scripts.js"></script>
<script src="dist/js/custom.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.delete', function(e) {
            console.log('delete click')
            e.preventDefault();
            $('#myModal').modal('show');
            const productId = $(this).attr("data-id");

            $('.confirm').click(function() {
                $.ajax({
                    type: 'POST',
                    url: 'product-delete.php',
                    data: {
                        productId: productId
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

</body>

</html>