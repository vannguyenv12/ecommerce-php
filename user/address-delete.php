<?php require_once "./include/header.php";

$db->delete("user_addresses", 'id', $_POST['addressId']);
