<?php
ob_start();
require "./include/header.php";
require "./include/topbar.php";
require "./include/navbar.php";

require_once "vendor/autoload.php";

use Omnipay\Omnipay;
?>

<?php

if (!isset($_SESSION['user'])) {
    header('Location: ./signin.php');
}

$user_id = $_SESSION['user']->id;
$cartList = $db->customQuery("SELECT * FROM carts WHERE user_id = ?", [$user_id]);

$addressList = $db->customQuery("SELECT * FROM user_addresses WHERE user_id = ?", [$user_id]);

if (count($addressList) > 0) {
    $address = $addressList[0];
} else {
    $address = "";
}

// $gateway = Omnipay::create('PayPal_Rest');

// $gateway->setClientId('AaPMKYRpZiPE5ZQ0IsTKq25yR46CwUib74X12Z2g_9Htk1TGfTwOlS1twS4J-nf-vwIpsyd8j5b_v2eu');
// $gateway->setSecret('ELURv5NZMBUO6aiPF7T-sa2c3mFon39HbO6Cw29ruCYkbn9hlVaVZrLYBpq8f7fgBjUgeA4aRKkzMV6F');
// $gateway->setTestMode(true);

// if (isset($_POST['form_paypal'])) {
//     try {

//         $response = $gateway->purchase(array(
//             'amount' => calculateTotalCartPrice($cartList),
//             'currency' => 'USD',
//             'returnUrl' => './paypal-success.php',
//             'cancelUrl' => './paypal-cancel.php'
//         ))->send();

//         if ($response->isRedirect()) {
//             $response->redirect();
//         } else {
//             return $response->getMessage();
//         }
//     } catch (\Throwable $th) {
//         return $th->getMessage();
//     }
// }

if (isset($_POST['form_paypal'])) {
    $invoiceId = generateRandomNumber();
    $cartList = $db->customQuery("SELECT * FROM carts WHERE user_id = ?", [$_SESSION['user']->id]);


    // Create Order
    $db->insert(
        "orders",
        [
            "invoice_id", "user_id", "amount", "product_qty",
            "payment_method", "payment_status", "order_address",
            "order_status"
        ],
        [
            $invoiceId, $_SESSION['user']->id, calculateTotalCartPrice($cartList), count($cartList),
            'paypal', 1, $address->address, 'pending'
        ]
    );

    // Find order
    $order = $db->query("orders", "invoice_id", $invoiceId);

    // Cart

    foreach ($cartList as $cart) {
        $db->insert(
            "order_products",
            [
                "order_id", "product_id", "product_name", "variants", "variant_total",
                "price", "qty"
            ],
            [
                $order->id, $cart->product_id, $cart->product_name, $cart->variants, $cart->variant_total,
                $cart->price, $cart->qty
            ]
        );
    }

    // Remove All Cart
    $db->delete("carts", "user_id", $_SESSION['user']->id);
}


?>



<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Shop</a>
                <span class="breadcrumb-item active">Checkout</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->


<!-- Checkout Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="row">
                    <?php
                    if (count($addressList) > 0) {
                        $address = $addressList[0];

                    ?>
                        <div class="col-md-6 form-group">
                            <label>Name</label>
                            <input readonly class="form-control" type="text" placeholder="John" value="<?= $address->name ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input readonly class="form-control" type="text" placeholder="John@gmail.com" value="<?= $address->email ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile Phone</label>
                            <input readonly class="form-control" type="text" placeholder="+123 456 789" value="<?= $address->phone ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address</label>
                            <input readonly class="form-control" type="text" placeholder="123 Street" value="<?= $address->address ?>">
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <h4>Please go to the link below to add your address</h4>
                                <a class="btn btn-primary mt-2" target="_blank" href="./user/address-add.php">Add address</a>
                            </div>
                        </div>
                    <?php
                    }

                    ?>

                </div>
            </div>
            <div class="collapse mb-5" id="shipping-address">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Shipping Address</span></h5>
                <div class="bg-light p-30">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" placeholder="John">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" placeholder="Doe">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="text" placeholder="example@email.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" placeholder="+123 456 789">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input class="form-control" type="text" placeholder="123 Street">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 2</label>
                            <input class="form-control" type="text" placeholder="123 Street">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <select class="custom-select">
                                <option selected>United States</option>
                                <option>Afghanistan</option>
                                <option>Albania</option>
                                <option>Algeria</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input class="form-control" type="text" placeholder="New York">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <input class="form-control" type="text" placeholder="New York">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input class="form-control" type="text" placeholder="123">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom">

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
                </div>
            </div>
            <div class="mb-5">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Payment</span></h5>
                <form method="POST" action="">

                    <div class="bg-light p-30">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="paypal">
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>

                        <button class="btn btn-block btn-primary font-weight-bold py-3" name="form_paypal">Place Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Checkout End -->


<?php require "./include/footer.php" ?>