<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../models/User.php';

$userModel = new User();
$userData = $userModel->getUserById($_SESSION['user_id']);

$roleMapping = [
    1 => 'User (Buyer)',
    2 => 'Provider (Seller)',
    3 => 'System Admin'
];
$roleText = $roleMapping[$userData['user_type_id']] ?? 'Unknown Role';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Goodact - My Profile</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
    <div class="container">
        <h2 style="margin-bottom: 20px;">My Profile</h2>
        
        <div class="profile-card">
            <div class="profile-row">
                <span class="profile-label">Full Name</span>
                <span class="profile-value"><?php echo htmlspecialchars($userData['user_name']); ?></span>
            </div>
            
            <div class="profile-row">
                <span class="profile-label">Email Address</span>
                <span class="profile-value"><?php echo htmlspecialchars($userData['email']); ?></span>
            </div>
            
            <div class="profile-row">
                <span class="profile-label">Account Type</span>
                <span class="profile-value"><?php echo $roleText; ?></span>
            </div>
        </div>

        <?php if ($_SESSION['role'] == 2): ?>
            <a href="providerDashboard.php" style="color: lightblue; text-decoration: none; font-size: 14px;">← Back to Dashboard</a>
        <?php elseif ($_SESSION['role'] == 3): ?>
            <a href="adminDashboard.php" style="color: lightblue; text-decoration: none; font-size: 14px;">← Back to Dashboard</a>
        <?php else: ?>
            <a href="userDashboard.php" style="color: lightblue; text-decoration: none; font-size: 14px;">← Back to Dashboard</a>
        <?php endif; ?>
    </div>
</body>
</html>