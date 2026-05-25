<?php
session_start();
require_once '../models/Listing.php';

if ($_SESSION['role'] != 3) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $listingModel = new Listing();
    
    $action = $_POST['action'];

    if ($action == "delete") {
        $listingModel->deleteListingAdmin($_POST['listing_id']);
    }

    header("Location: ../views/adminListings.php");
    exit();
}
?>