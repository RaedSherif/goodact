<?php

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/listings.php';


# Setup: temporary provider to own the listing
$user      = new User();
$testEmail = "test_listing@goodact.test";
$data      = ['name' => 'Listing Tester', 'email' => $testEmail, 'password' => 'testpass123', 'type' => 2];
$user->register($data);

$loginResult = $user->login(['email' => $testEmail, 'password' => 'testpass123']);
$providerId  = $loginResult['id'];

$listing   = new Listing();
$listingId = null;


# Test 1: createWithEAV - success returns true
$result = $listing->createWithEAV($providerId, 'Test Listing', 'condition', 'new', 0);
check("Listing::createWithEAV returns true on success", $result === true);


# Test 2: getListingsByProviderWithDetails - returns array with traits
$result = $listing->getListingsByProviderWithDetails($providerId);
check("Listing::getListingsByProviderWithDetails returns non-empty array", is_array($result) && count($result) > 0);

if (is_array($result) && count($result) > 0) {
    $listingId = $result[0]['id'];
}


# Test 3: updateListingTitle - returns true
$result = $listing->updateListingTitle($listingId, $providerId, 'Updated Listing', 0);
check("Listing::updateListingTitle returns true on success", $result === true);


# Test 4: deleteListing - returns true
$result = $listing->deleteListing($listingId, $providerId);
check("Listing::deleteListing returns true on success", $result === true);


$user->deleteUser($providerId);
