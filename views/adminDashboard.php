<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['role'] == 1) {
    header('Location: userDashboard.php');
    exit();
} elseif ($_SESSION['role'] == 2) {
    header('Location: providerDashboard.php');
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
    <title>Goodact - Provider Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/userDash.css">
    </head>
<body>
    <div class="container">
        <h2>Provider Workspace</h2>
        
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