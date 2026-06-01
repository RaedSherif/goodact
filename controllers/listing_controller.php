<?php
session_start();
require_once __DIR__ . '/../models/listings.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $listing     = new Listing();
    $provider_id = $_SESSION['user_id'];
    $action      = $_POST['action'];

    if ($action == "create") {
        if (empty($_POST['title'])) {
            echo "Listing title is required.";
            exit();
        }

        if (isset($_POST['is_premium'])) {
            $is_premium = 1;
        } else {
            $is_premium = 0;
        }

        $listing->createWithEAV($provider_id, $_POST['title'], $_POST['trait_name'], $_POST['trait_value'], $is_premium);
    }
    elseif ($action == "update") {
        if (empty($_POST['title'])) {
            echo "Listing title is required.";
            exit();
        }

        if (isset($_POST['is_premium'])) {
            $is_premium = 1;
        } else {
            $is_premium = 0;
        }

        $listing->updateListingTitle($_POST['listing_id'], $provider_id, $_POST['title'], $is_premium);
    } 
    elseif ($action == "delete") {
        $listing->deleteListing($_POST['listing_id'], $provider_id);
    }

    header("Location: ../views/viewListings.php");
    exit();
}
?>