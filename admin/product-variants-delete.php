<?php require_once "./include/header.php";

$db->delete("product_variants", 'id', $_POST['id']);
