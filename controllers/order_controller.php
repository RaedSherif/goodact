<?php
session_start();
require_once '../models/Order.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderModel = new Order();
    $buyer_id = $_SESSION['user_id'];
    $action = $_POST['action'];

    if ($action == "buy") {
        $notes = isset($_POST['order_notes']) ? trim($_POST['order_notes']) : '';
        $orderModel->placeOrder($buyer_id, $_POST['listing_id'], $notes);
    } 
    elseif ($action == "update_note") {
        $orderModel->updateOrderNote($_POST['order_id'], $buyer_id, $_POST['order_notes']);
    } 
    elseif ($action == "cancel") {
        $orderModel->cancelOrder($_POST['order_id'], $buyer_id);
    }

    header("Location: ../views/orders.php");
    exit();
}
?>