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

if (!isset($_GET['id'])) {
    header("Location: viewListings.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Listing</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Listing</h2>
        
        <form action="../controllers/listing_controller.php" method="POST">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="listing_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
            
            <input type="text" name="title" value="<?php echo htmlspecialchars($_GET['title'] ?? ''); ?>" required>
            
            <label style="display: block; text-align: left; margin: 15px 0 5px 0; font-size: 14px; cursor: pointer; color: white;">
                <input type="checkbox" name="is_premium" value="1" style="width: auto; margin-right: 8px;"> 
                Mark as Premium Listing (⭐)
            </label>

            <button type="submit">Save Changes</button>
        </form>

        <p style="margin-top: 20px;"><a href="viewListings.php" style="color: lightgray;">Cancel</a></p>
    </div>
</body>
</html>