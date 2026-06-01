<?php
/**
 * User CRUD tests.
 * Pattern (Sommerville Ch.8): setup -> call -> assert.
 *
 * Run: C:\xampp\php\php.exe tests\test_user.php
 */

require_once __DIR__ . '/../models/User.php';

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

$user      = new User();
$testEmail = "test_user_" . time() . "@goodact.test";
$userId    = null;


// Test 1: register — success returns true
$data   = ['name' => 'Test User', 'email' => $testEmail, 'password' => 'testpass123', 'type' => 1];
$result = $user->register($data);
check("User::register returns true on success", $result === true);


// Test 2: login — valid credentials return user array
$data   = ['email' => $testEmail, 'password' => 'testpass123'];
$result = $user->login($data);
check("User::login returns user array on valid credentials", is_array($result) && isset($result['id']));

if (is_array($result) && isset($result['id'])) {
    $userId = $result['id'];
}


// Test 3: getUserById — returns correct record
$result = $user->getUserById($userId);
check("User::getUserById returns matching email", isset($result['email']) && $result['email'] === $testEmail);


// Test 4: updateUser — returns true
$result = $user->updateUser($userId, 'Updated Name', $testEmail, 1);
check("User::updateUser returns true on success", $result === true);


// Test 5: deleteUser — returns true
$result = $user->deleteUser($userId);
check("User::deleteUser returns true on success", $result === true);


// ===== Summary =====
echo "\n----------------------------------------\n";
echo "Passed: $passed\n";
echo "Failed: $failed\n";
exit($failed === 0 ? 0 : 1);
