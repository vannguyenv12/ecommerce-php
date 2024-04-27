<?php require_once "./include/header.php";

$db->delete("products", 'id', $_POST['productId']);
