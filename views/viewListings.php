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

require_once '../models/listings.php';
require_once '../models/listingsManager.php';

$listingModel = new Listing();
$myListings = $listingModel->getListingsByProviderWithDetails($_SESSION['user_id']);

$sorter = (isset($_GET['sort']) && $_GET['sort'] == 'desc') ? new SortDescending() : new SortAscending();
$myListings = $sorter->sortData($myListings);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Inventory</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .listing-box { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2); padding: 15px; margin-bottom: 15px; border-radius: 8px; text-align: left; }
        .trait-pill { background: rgba(0,0,0,0.3); padding: 4px 8px; border-radius: 4px; font-size: 12px; margin-right: 5px; display: inline-block; margin-top: 8px; color: lightgray; }
        .action-row { margin-top: 15px; display: flex; gap: 10px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px; }
        .btn-edit { background: #005b9f; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 13px; }
        .btn-delete { background: #9f0000; color: white; padding: 6px 12px; border: none; border-radius: 4px; font-size: 13px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container" style="max-width: 600px;">
        <h2>My Active Inventory</h2>
        
        <div style="margin-bottom: 20px;">
            <a href="?sort=asc" style="color: lightblue; margin-right: 15px;">Sort A-Z</a>
            <a href="?sort=desc" style="color: lightblue;">Sort Z-A</a>
        </div>

        <div>
            <?php if (empty($myListings)): ?>
                <p>No listings published yet.</p>
            <?php else: ?>
                <?php foreach ($myListings as $row): 
                    $displayItem = new BaseItem($row['title']);
                    if ($row['is_premium'] == 1) {
                        $displayItem = new PremiumBadgeDecorator($displayItem);
                    }
                ?>
                    <div class="listing-box">
                        <strong style="font-size: 18px;"><?php echo $displayItem->getDisplayTitle(); ?></strong>
                        
                        <div>
                            <?php foreach ($row['traits'] as $key => $value): ?>
                                <span class="trait-pill"><?php echo htmlspecialchars($key) . ": " . htmlspecialchars($value); ?></span>
                            <?php endforeach; ?>
                        </div>

                        <div class="action-row">
                            <a href="editListing.php?id=<?php echo $row['id']; ?>&title=<?php echo urlencode($row['title']); ?>" class="btn-edit">Edit</a>
                            
                            <form action="../controllers/listing_controller.php" method="POST" onsubmit="return confirm('Delete this listing?');" style="margin: 0;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="listing_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <p style="margin-top: 20px;"><a href="providerDashboard.php">← Back to Hub</a></p>
    </div>
</body>
</html>