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

?>