<?php require_once "./include/header.php";

$db->update("orders", ['order_status'], [$_POST['status']], "id", $_POST['order_id']);
