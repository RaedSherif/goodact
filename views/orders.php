<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header('Location: login.php');
    exit();
}

require_once '../models/Order.php';

$orderModel = new Order();
$myOrders = $orderModel->getOrdersByBuyer($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/orders.css">
</head>
<body>
    <div class="container" style="max-width: 600px;">
        <h2>My Orders</h2>

        <div>
            <?php if (empty($myOrders)): ?>
                <p>You haven't placed any orders yet.</p>
            <?php else: ?>
                <?php foreach ($myOrders as $order): ?>
                    <div class="order-box">
                        <strong style="font-size: 18px;"><?php echo htmlspecialchars($order['listing_title']); ?></strong>
                        
                        <div class="order-meta">
                            Order ID: #<?php echo $order['id']; ?> | Placed: <?php echo date("F j, Y", strtotime($order['order_date'])); ?>
                        </div>

                        <?php if (!empty($order['order_notes'])): ?>
                            <div class="order-note">
                                <strong>Note:</strong> <?php echo htmlspecialchars($order['order_notes']); ?>
                            </div>
                        <?php endif; ?>

                        <div class="action-row">
                            <a href="editOrder.php?id=<?php echo $order['id']; ?>&note=<?php echo urlencode($order['order_notes']); ?>" class="btn-edit">Edit Note</a>
                            
                            <form action="../controllers/order_controller.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');" style="margin: 0;">
                                <input type="hidden" name="action" value="cancel">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <button type="submit" class="btn-delete">Cancel Order</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <p style="margin-top: 20px;"><a href="userDashboard.php">← Back to Dashboard</a></p>
    </div>
</body>
</html>