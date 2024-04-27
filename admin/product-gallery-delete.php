<?php require_once "./include/header.php";

$db->delete("product_image_galleries", 'id', $_POST['id']);
