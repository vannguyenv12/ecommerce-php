<?php require_once "./include/header.php"; ?>
<?php require_once "./include/navbar.php"; ?>
<?php require_once "./include/sidebar.php"; ?>

<?php
$order = $db->query("orders", "invoice_id", $_GET["invoiceId"]);

?>

<div class="main-content">
    <section class="section">
        <div class="section-header flex" style="justify-content: space-between;">
            <h1>Order Detail</h1>
            <a class="btn btn-primary" href="./orders.php">Back</a>
        </div>
        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Invoice</h2>
                                <div class="invoice-number">Order #<?= $_GET['invoiceId'] ?></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Invoice To</strong><br>
                                        <?= $order->order_address ?>
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Invoice Date</strong><br>
                                        <?= formatDate($order->created_at) ?>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Order Details</div>
                            <hr class="invoice-above-table">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th>ID</th>
                                        <th>Item Name</th>
                                        <th class="text-center">Variant Total</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-right">Subtotal</th>
                                    </tr>
                                    <?php
                                    $orderProducts = $db->queryAll("order_products", "invoice_id", $_GET['invoiceId']);
                                    foreach ($orderProducts as $item) {
                                    ?>
                                        <tr>
                                            <td><?= $item->id ?></td>
                                            <td><?= $item->product_name ?></td>
                                            <td class="text-center">$<?= $item->variant_total ?></td>
                                            <td class="text-center"><?= $item->qty ?></td>
                                            <td class="text-right">$<?= $item->price ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-12 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">$<?= $order->amount ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="about-print-button">
                <div class="text-md-right">
                    <a href="javascript:window.print();" class="btn btn-warning btn-icon icon-left text-white print-invoice-button"><i class="fas fa-print"></i> Print</a>
                </div>
            </div>
        </div>
    </section>
</div>

</div>
</div>

<script src="dist/js/scripts.js"></script>
<script src="dist/js/custom.js"></script>

</body>

</html>