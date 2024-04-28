<?php
require "./include/header.php";

$cart = $db->query("carts", 'id', $_POST['cart_id']);
$productByCart = $db->query("products", "id", $cart->product_id);

$productPrice = $productByCart->price;
$variantPrice = $cart->variant_total;

$total = ($productPrice + $variantPrice) * (int)$_POST['qty'];

$db->update("carts", ['qty', 'price'], [$_POST['qty'], $total], "id", $_POST['cart_id']);
