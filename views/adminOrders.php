<?php
session_start();
if ($_SESSION['role'] != 3) {
    header('Location: login.php');
    exit();
}

require_once '../models/Order.php';

$orderModel = new Order();
$allOrders = $orderModel->getAllOrdersAdmin();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Orders</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container" style="max-width: 800px;">
        <h2>Order Management</h2>
        <br>

        <table border="1" width="100%" cellpadding="10" style="border-collapse: collapse; text-align: left; background: rgba(0,0,0,0.3); color: white;">
            <tr>
                <th>Order ID</th>
                <th>Item Purchased</th>
                <th>Buyer Name</th>
                <th>Date Placed</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
            
            <?php if (empty($allOrders)) { ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No orders have been placed yet.</td>
                </tr>
            <?php } else { ?>
                <?php foreach ($allOrders as $order) { ?>
                <tr>
                    <td>#<?php echo $order['id']; ?></td>
                    <td><?php echo $order['item_name']; ?></td>
                    <td><?php echo $order['buyer_name']; ?></td>
                    <td><?php echo date("Y-m-d", strtotime($order['order_date'])); ?></td>
                    <td>
                        <?php 
                        if ($order['order_notes'] == '') {
                            echo "<i>None</i>";
                        } else {
                            echo $order['order_notes'];
                        }
                        ?>
                    </td>
                    <td>
                        <form action="../controllers/admin_order_controller.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <button type="submit" style="background: red; padding: 5px; font-size: 12px; margin: 0;">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            <?php } ?>
            
        </table>

        <br><br>
        <a href="adminDashboard.php">Go Back</a>
    </div>
</body>
</html>