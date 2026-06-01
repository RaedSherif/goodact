<?php
/**
 * Listing CRUD tests.
 * Pattern (Sommerville Ch.8): setup -> call -> assert.
 *
 * Run: C:\xampp\php\php.exe tests\test_listing.php
 */

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/listings.php';

$passed = 0;
$failed = 0;

function check(string $label, bool $condition): void
{
    global $passed, $failed;
    if ($condition) {
        echo "[PASS] $label\n";
        $passed++;
    } else {
        echo "[FAIL] $label\n";
        $failed++;
    }
}

// Setup: create a temporary provider to own the listings
$user      = new User();
$testEmail = "test_listing_" . time() . "@goodact.test";
$data      = ['name' => 'Listing Tester', 'email' => $testEmail, 'password' => 'testpass123', 'type' => 2];
$user->register($data);

$loginResult = $user->login(['email' => $testEmail, 'password' => 'testpass123']);
$providerId  = $loginResult['id'];

$listing   = new Listing();
$listingId = null;


// Test 1: createWithEAV — success returns true
$result = $listing->createWithEAV($providerId, 'Test Listing ' . time(), 'condition', 'new', 0);
check("Listing::createWithEAV returns true on success", $result === true);


// Test 2: getListingsByProviderWithDetails — returns array with traits
$result = $listing->getListingsByProviderWithDetails($providerId);
check("Listing::getListingsByProviderWithDetails returns non-empty array", is_array($result) && count($result) > 0);

if (is_array($result) && count($result) > 0) {
    $listingId = $result[0]['id'];
}


// Test 3: updateListingTitle — returns true
$result = $listing->updateListingTitle($listingId, $providerId, 'Updated Listing ' . time(), 0);
check("Listing::updateListingTitle returns true on success", $result === true);


// Test 4: deleteListing — returns true
$result = $listing->deleteListing($listingId, $providerId);
check("Listing::deleteListing returns true on success", $result === true);


// Cleanup: remove the temporary provider
$user->deleteUser($providerId);


// ===== Summary =====
echo "\n----------------------------------------\n";
echo "Passed: $passed\n";
echo "Failed: $failed\n";
exit($failed === 0 ? 0 : 1);
