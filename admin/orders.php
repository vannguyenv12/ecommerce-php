<?php require_once "./include/header.php"; ?>
<?php require_once "./include/navbar.php"; ?>
<?php require_once "./include/sidebar.php"; ?>


<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Orders</h1>
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
                                            <th>Invoice ID</th>
                                            <th>User</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $orderList = $db->customQuery("SELECT * FROM orders", []);
                                        foreach ($orderList as $order) {
                                            $user = $db->query("users", "id", $order->user_id);
                                        ?>
                                            <tr>
                                                <td><?= $order->invoice_id ?></td>
                                                <td><?= $user->name ?></td>
                                                <td><?= $order->amount ?></td>
                                                <td>
                                                    <select class="form-control order_status" data-order-id="<?= $order->id ?>" name="order_status">
                                                        <option <?= $order->order_status == 'pending' ? 'selected' : '' ?> value="pending">Pending</option>
                                                        <option <?= $order->order_status == 'delivered' ? 'selected' : '' ?> value="delivered">Delivered</option>
                                                    </select>
                                                </td>
                                                <td class="pt_10 pb_10">
                                                    <a href="./order-detail.php?invoiceId=<?= $order->invoice_id ?>" class="btn btn-warning"><i class="fas fa-eye"></i></a>
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
        $('.order_status').change(function() {
            const orderId = $(this).data('order-id');
            const status = $(this).val();

            $.ajax({
                method: 'POST',
                url: './order-status-change.php',
                data: {
                    order_id: orderId,
                    status
                },
                success(response) {
                    Toastify({
                        text: "Updated Status Successfully",
                        duration: 4000,
                        gravity: "top", // `top` or `bottom`
                        position: "center", // `left`, `center` or `right`
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                    }).showToast();
                }
            })
        });
    })
</script>

</body>

</html>