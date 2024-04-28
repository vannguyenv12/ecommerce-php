<?php
require "./include/header.php";
require "./include/topbar.php";
require "./include/navbar.php";
?>

<?php
$cartList = $db->queryAll("carts");

?>



<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Shop</a>
                <span class="breadcrumb-item active">Shopping Cart</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->


<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Products</th>
                        <th>Product Price</th>
                        <th>Variant Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <?php
                    foreach ($cartList as $cart) {
                        $product = $db->query("products", 'id', $cart->product_id);
                    ?>
                        <tr>
                            <td class="align-middle"><img src="./uploads/<?= $product->thumb_image ?>" alt="" style="width: 100px !important; height: 70px !important;"> <?= $cart->product_name ?></td>
                            <td class="align-middle">$<span class="product_price"><?= $product->price ?></span></td>
                            <td class="align-middle">$<span class="variant_price"><?= $cart->variant_total ?></span></td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus decrement">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center qty" name="qty" value="<?= $cart->qty ?>" data-id="<?= $cart->id ?>">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus increment">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">$<span class="total_price"><?= $cart->price ?></span></td>
                            <td class="align-middle"><button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
                        </tr>
                    <?php
                    }

                    ?>


                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <form class="mb-30" action="">
                <div class="input-group">
                    <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                    <div class="input-group-append">
                        <button class="btn btn-primary">Apply Coupon</button>
                    </div>
                </div>
            </form>
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6>$150</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium">$10</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5>$160</h5>
                    </div>
                    <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->


<?php require "./include/footer.php" ?>

<script>
    $(document).ready(function() {
        $('.increment').on('click', function() {
            updateQuantity();
        })

        $('.decrement').on('click', function() {
            updateQuantity();
        })

        function updateQuantity() {
            const productQty = $('.qty').val();
            const cartId = $('.qty').data("id");

            // call ajax
            $.ajax({
                method: 'POST',
                url: './cart-update-quantity.php',
                data: {
                    qty: productQty,
                    cart_id: cartId,
                },
                success(response) {
                    const productPrice = parseInt($('.product_price').text());
                    const variantPrice = parseInt($('.variant_price').text());
                    const qty = parseInt($('.qty').val());

                    const total = (productPrice + variantPrice) * qty;
                    console.log(total);
                    $('.total_price').text(total);
                }
            })
        }
    })
</script>