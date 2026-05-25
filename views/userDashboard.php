<?php
session_start();

if (($_SESSION['user_id'])!= 1) {
    if (($_SESSION['user_id'])== 2) {
        header("Location: providerDashboard.php");
    } elseif (($_SESSION['user_id'])== 3) {
        header("Location: adminDashboard.php");
    } else {
        header("Location: login.php");
    }
    exit();
}

require_once '../interfaces/IMenu.php';
require_once '../models/BaseMenu.php';
require_once '../models/RoleMenuDecorator.php';

$baseMenu = new BaseMenu();

$dynamicMenu = new RoleMenuDecorator($baseMenu, $_SESSION['role']);

$navigationLinks = $dynamicMenu->getMenuItems();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Goodact Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/userDash.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard</h2>
        
        <div class="sidebar">
            <?php foreach ($navigationLinks as $link): ?>
                <a href="<?php echo htmlspecialchars($link['link']); ?>">
                    <?php echo htmlspecialchars($link['name']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>