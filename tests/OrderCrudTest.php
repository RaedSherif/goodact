<?php

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/listings.php';
require_once __DIR__ . '/../models/Order.php';

# Order CRUD Unit Tests

#Setup: create a provider and a buyer, then a listing to order
$user = new User();

$providerEmail = "test_provider@goodact.test";
$buyerEmail    = "test_buyer@goodact.test";

$user->register(['name' => 'Test Provider', 'email' => $providerEmail, 'password' => 'testpass123', 'type' => 2]);
$user->register(['name' => 'Test Buyer',    'email' => $buyerEmail,    'password' => 'testpass123', 'type' => 1]);

$providerResult = $user->login(['email' => $providerEmail, 'password' => 'testpass123']);
$buyerResult    = $user->login(['email' => $buyerEmail,    'password' => 'testpass123']);

$providerId = $providerResult['id'];
$buyerId    = $buyerResult['id'];

$listing = new Listing();
$listing->createWithEAV($providerId, 'Order Test Listing', 'condition', 'used', 0);

$listings  = $listing->getListingsByProviderWithDetails($providerId);
$listingId = $listings[0]['id'];

$order   = new Order();
$orderId = null;


#Test 1: placeOrder - success returns true
$result = $order->placeOrder($buyerId, $listingId, 'test note');
check("Order::placeOrder returns true on success", $result === true);


#Test 2: getOrdersByBuyer - returns array with listing_title resolved
$result = $order->getOrdersByBuyer($buyerId);
check("Order::getOrdersByBuyer returns array with listing_title", is_array($result) && isset($result[0]['listing_title']));

if (is_array($result) && count($result) > 0) {
    $orderId = $result[0]['id'];
}


#Test 3: updateOrderNote - returns true
$result = $order->updateOrderNote($orderId, $buyerId, 'updated note');
check("Order::updateOrderNote returns true on success", $result === true);


#Test 4: cancelOrder - returns true
$result = $order->cancelOrder($orderId, $buyerId);
check("Order::cancelOrder returns true on success", $result === true);


#Cleanup: remove test listing and users (cascade removes orders)
$listing->deleteListing($listingId, $providerId);
$user->deleteUser($providerId);
$user->deleteUser($buyerId);
