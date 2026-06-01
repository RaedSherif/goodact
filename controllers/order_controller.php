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
        if (empty($_POST['listing_id']) || !is_numeric($_POST['listing_id'])) {
            echo "Invalid listing.";
            exit();
        }

        $notes = '';
        if (isset($_POST['order_notes'])) {
            $notes = trim($_POST['order_notes']);
        }

        $orderModel->placeOrder($buyer_id, $_POST['listing_id'], $notes);
    }
    elseif ($action == "update_note") {
        if (strlen($_POST['order_notes']) > 255) {
            echo "Note cannot exceed 255 characters.";
            exit();
        }

        $orderModel->updateOrderNote($_POST['order_id'], $buyer_id, $_POST['order_notes']);
    } 
    elseif ($action == "cancel") {
        $orderModel->cancelOrder($_POST['order_id'], $buyer_id);
    }

    header("Location: ../views/orders.php");
    exit();
}
?>