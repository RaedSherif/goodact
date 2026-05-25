<?php
session_start();
require_once '../models/Order.php';

if ($_SESSION['role'] != 3) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderModel = new Order();
    
    $action = $_POST['action'];

    if ($action == "delete") {
        $orderModel->deleteOrderAdmin($_POST['order_id']);
    }

    header("Location: ../views/adminOrders.php");
    exit();
}
?>