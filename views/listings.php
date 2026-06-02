<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header('Location: login.php');
    exit();
}

require_once '../models/listings.php';
require_once '../models/listingsManager.php';

$listingModel = new Listing();
$marketplaceListings = $listingModel->getAllListingsWithDetails();

$sorter = (isset($_GET['sort']) && $_GET['sort'] == 'desc') ? new SortDescending() : new SortAscending();
$marketplaceListings = $sorter->sortData($marketplaceListings);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Marketplace</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/listings.css">
</head>
<body>
    <div class="container" style="max-width: 600px;">
        <h2>Marketplace</h2>
        
        <div style="margin-bottom: 20px;">
            <a href="?sort=asc" style="color: lightblue; margin-right: 15px;">Sort A-Z</a>
            <a href="?sort=desc" style="color: lightblue;">Sort Z-A</a>
        </div>

        <div>
            <?php if (empty($marketplaceListings)): ?>
                <p>No listings available right now.</p>
            <?php else: ?>
                <?php foreach ($marketplaceListings as $row): 
                    
                    $displayItem = new BaseItem($row['title']);
                    if ($row['is_premium'] == 1) {
                        $displayItem = new PremiumBadgeDecorator($displayItem);
                    }
                ?>
                    <div class="listing-box">
                        <strong style="font-size: 18px;"><?php echo $displayItem->getDisplayTitle(); ?></strong>
                        
                        <div>
                            <?php foreach ($row['traits'] as $key => $value): ?>
                                <span class="trait-pill"><?php echo $key . ": " . $value; ?></span>
                            <?php endforeach; ?>
                        </div>

                        <form action="../controllers/order_controller.php" method="POST" class="buy-form">
                            <input type="hidden" name="action" value="buy">
                            <input type="hidden" name="listing_id" value="<?php echo $row['id']; ?>">
                            
                            <input type="text" name="order_notes" class="note-input" placeholder="Add an optional delivery note to the provider...">
                            
                            <button type="submit" class="btn-buy">Buy Now</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <p style="margin-top: 20px;"><a href="userDashboard.php">← Back to Dashboard</a></p>
    </div>
</body>
</html>