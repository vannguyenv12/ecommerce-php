<?php
ob_start();
require "./include/header.php";
require "./include/topbar.php";
require "./include/navbar.php";

if (!isset($_SESSION['user'])) {
    header('Location: ./signin.php');
}

?>

<?php
$user_id = $_SESSION['user']->id;
$cartList = $db->customQuery("SELECT * FROM carts WHERE user_id = ?", [$user_id]);

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
                <tbody class="align-middle cart_content">
                    <?php
                    foreach ($cartList as $cart) {
                        $product = $db->query("products", 'id', $cart->product_id);
                    ?>
                        <tr class="tr_product">
                            <td class="align-middle"><img src="./uploads/<?= $product->thumb_image ?>" alt="" style="width: 100px !important; height: 70px !important;"> <?= $cart->product_name ?></td>
                            <td class="align-middle">$<span class="product_price">
                                    <?php
                                    if (isset($product->offer_price)) {
                                    ?>
                                        <?= $product->offer_price ?>
                                    <?php
                                    } else {
                                    ?>
                                        <?= $product->price ?>
                                    <?php
                                    }
                                    ?>
                                </span></td>
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
                            <td class="align-middle">$<span class="total_price">
                                    <?= $cart->price ?>

                                </span></td>
                            <td class="align-middle"><button class="btn btn-sm btn-danger remove_cart" data-cart-id="<?= $cart->id ?>"><i class="fa fa-times"></i></button></td>
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
                        <h6>$
                            <span>
                                <?php
                                // echo calculateTotalCartPrice($cartList);
                                ?>
                            </span>
                        </h6>
                    </div>
                    <!-- <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium">$10</h6>
                    </div> -->
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5>$
                            <span class="total">
                                <?php
                                echo calculateTotalCartPrice($cartList);
                                ?>
                            </span>
                        </h5>
                    </div>
                    <a class="btn btn-block btn-primary font-weight-bold my-3 py-3" href="./checkout.php">Proceed To Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->


<?php require "./include/footer.php" ?>

<script>
    $(document).ready(function() {
        $(document).on('click', '.increment', function() {
            var parentElement = $(this).closest('.quantity');
            var inputElement = parentElement.find('input.qty');

            var productBody = $(this).closest('.tr_product');
            var productPrice = productBody.find('.product_price');
            var variantPrice = productBody.find('.variant_price');
            var totalPrice = productBody.find('.total_price');


            updateQuantity(inputElement, productPrice, variantPrice, totalPrice);
        })

        $(document).on('click', '.decrement', function() {
            var parentElement = $(this).closest('.quantity');
            var inputElement = parentElement.find('input.qty');

            var productBody = $(this).closest('.tr_product');
            var productPrice = productBody.find('.product_price');
            var variantPrice = productBody.find('.variant_price');
            var totalPrice = productBody.find('.total_price');

            const qtyNum = parseInt(inputElement.val());


            if (qtyNum <= 1) {
                inputElement.val(1);
            }


            updateQuantity(inputElement, productPrice, variantPrice, totalPrice);
        })

        function updateTotalPrice() {
            // call ajax
            $.ajax({
                method: 'GET',
                url: './cart-total.php',
                success(response) {
                    $('.total').text(response);
                }
            })
        }

        function updateQuantity(inputElement, productPriceEl, variantPriceEl, totalPriceEl) {
            const productQty = inputElement.val();
            const cartId = inputElement.data("id");

            // call ajax
            $.ajax({
                method: 'POST',
                url: './cart-update-quantity.php',
                data: {
                    qty: productQty,
                    cart_id: cartId,
                },
                success(response) {
                    const productPrice = parseInt(productPriceEl.text());
                    const variantPrice = parseInt(variantPriceEl.text());
                    const qty = parseInt(inputElement.val());


                    const total = (productPrice + variantPrice) * qty;
                    totalPriceEl.text(total);
                    updateTotalPrice();

                }
            })
        }

        $(document).on('click', '.remove_cart', function() {
            const cartId = $(this).data('cart-id');
            $.ajax({
                method: 'POST',
                url: './cart-delete.php',
                data: {
                    cart_id: cartId
                },
                success(response) {
                    $('.cart_content').html(response);

                    // decrease cart icon
                    const cartQty = $('.cart_qty_value').val();
                    $('.cart_qty').text(cartQty);

                    Toastify({
                        text: "Remove cart Successfully",
                        duration: 3000,
                        gravity: "top", // `top` or `bottom`
                        position: "center", // `left`, `center` or `right`
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                    }).showToast();

                    updateTotalPrice();

                }
            })
        })

    })
</script>