<?php
require_once './config/database.php';
session_start();

$db = new Database();

$cart = $db->query("carts", 'id', $_POST['cart_id']);

$db->delete("carts", "id", $_POST['cart_id']);

$user_id = $_SESSION['user']->id;
$cartList = $db->customQuery("SELECT * FROM carts WHERE user_id = ?", [$user_id]);

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
        <td class="align-middle"><button class="btn btn-sm btn-danger remove_cart" data-cart-id="<?= $cart->id ?>"><i class="fa fa-times"></i></button></td>
    </tr>
<?php
}
