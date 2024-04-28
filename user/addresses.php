<?php require_once "./include/header.php"; ?>
<?php require_once "./include/navbar.php"; ?>
<?php require_once "./include/sidebar.php"; ?>


<div class="main-content">
    <section class="section">
        <div class="section-header flex" style="justify-content: space-between;">
            <h1>Addresses</h1>
            <a href="./address-add.php" class="btn btn-primary">Add address</a>
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
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $addressList = $db->customQuery("SELECT * FROM user_addresses WHERE user_id = ?", [$_SESSION['user']->id]);
                                        foreach ($addressList as $address) {
                                        ?>
                                            <tr>
                                                <td><?= $address->name ?></td>
                                                <td><?= $address->email ?></td>
                                                <td><?= $address->phone ?></td>
                                                <td><?= $address->address ?></td>
                                                <td class="pt_10 pb_10">
                                                    <a href="" class="btn btn-danger delete" data-id="<?= $address->id; ?>"><i class="fas fa-trash"></i></a>
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
        $('.delete').click(function(e) {
            e.preventDefault();
            $('#myModal').modal('show');
            const addressId = $(this).attr("data-id");

            $('.confirm').click(function() {
                $.ajax({
                    type: 'POST',
                    url: 'address-delete.php',
                    data: {
                        addressId: addressId
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