<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['role'] == 1) {
    header('Location: userDashboard.php');
    exit();
} elseif ($_SESSION['role'] == 3) {
    header('Location: adminDashboard.php');
    exit();
}

require_once '../models/Order.php';

$orderModel = new Order();
$customerOrders = $orderModel->getOrdersForProvider($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Orders</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Customer Orders</h2>

        <ul style="text-align: left; padding: 20px; background: rgba(255,255,255,0.05); border-radius: 10px; list-style-type: none;">
            <?php if (empty($customerOrders)): ?>
                <li>No one has bought your items yet.</li>
            <?php else: ?>
                <?php foreach ($customerOrders as $order): ?>
                    <li style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                        <strong><?php echo $order['item_name']; ?></strong> was purchased by <strong><?php echo $order['buyer_name']; ?></strong>.
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <p><a href="providerDashboard.php">← Back to Hub</a></p>
    </div>
</body>
</html>