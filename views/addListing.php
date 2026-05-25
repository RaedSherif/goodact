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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Publish Listing</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Publish Listing</h2>
        
        <form action="../controllers/listing_controller.php" method="POST">
            <input type="hidden" name="action" value="create">
            
            <input type="text" name="title" placeholder="Listing Title" required>
            <input type="text" name="trait_name" placeholder="Pricing method" required>
            <input type="text" name="trait_value" placeholder="price incl currency" required>
            
            <label style="display: block; text-align: left; margin: 15px 0; font-size: 14px; cursor: pointer; color: white;">
                <input type="checkbox" name="is_premium" value="1" style="width: auto; margin-right: 8px;"> 
                Mark as Premium Listing
            </label>

            <button type="submit">Publish</button>
        </form>

        <p style="margin-top: 20px;"><a href="providerDashboard.php">← Back to Hub</a></p>
    </div>
</body>
</html>