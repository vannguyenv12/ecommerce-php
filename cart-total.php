<?php
require_once './config/database.php';
session_start();

$db = new Database();

$user_id = $_SESSION['user']->id;
$cartList = $db->customQuery("SELECT * FROM carts WHERE user_id = ?", [$user_id]);

$total = 0;

foreach ($cartList as $cart) {
    $total += $cart->price;
}
echo json_encode($total);
