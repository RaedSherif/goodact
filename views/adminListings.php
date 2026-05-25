<?php
session_start();

if ($_SESSION['role'] != 3) {
    header('Location: login.php');
    exit();
}

require_once '../models/listings.php';

$listingModel = new Listing();
$allListings = $listingModel->getAllListingsAdmin();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Listings</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container" style="max-width: 800px;">
        <h2>Listing Management</h2>
        <br>

        <table border="1" width="100%" cellpadding="10" style="border-collapse: collapse; text-align: left; background: rgba(0,0,0,0.3); color: white;">
            <tr>
                <th>Item ID</th>
                <th>Listing Title</th>
                <th>Provider Name</th>
                <th>Premium Status</th>
                <th>Actions</th>
            </tr>
            
            <?php if (empty($allListings)) { ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No listings have been published yet.</td>
                </tr>
            <?php } else { ?>
                <?php foreach ($allListings as $listing) { ?>
                <tr>
                    <td>#<?php echo $listing['id']; ?></td>
                    <td><?php echo $listing['title']; ?></td>
                    <td><?php echo $listing['provider_name']; ?></td>
                    <td>
                        <?php 
                        if ($listing['is_premium'] == 1) {
                            echo "Yes";
                        } else {
                            echo "No";
                        }
                        ?>
                    </td>
                    <td>
                        <form action="../controllers/admin_listing_controller.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this listing? It will also delete any orders attached to it.');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="listing_id" value="<?php echo $listing['id']; ?>">
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