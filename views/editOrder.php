<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: orders.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Order Notes</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Update Order Note</h2>
        <p style="margin-top: 0; margin-bottom: 20px; font-size: 13px;">Add special instructions for the provider regarding Order #<?php echo htmlspecialchars($_GET['id']); ?>.</p>
        
        <form action="../controllers/order_controller.php" method="POST">
            <input type="hidden" name="action" value="update_note">
            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
            
            <input type="text" name="order_notes" value="<?php echo htmlspecialchars($_GET['note'] ?? ''); ?>" placeholder="E.g., Please leave at the front desk..." required>
            
            <button type="submit">Save Note</button>
        </form>

        <p style="margin-top: 20px;"><a href="orders.php" style="color: lightgray;">Cancel</a></p>
    </div>
</body>
</html>