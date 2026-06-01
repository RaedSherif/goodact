<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../models/User.php';

$user      = new User();
$testEmail = "test_user@goodact.test";
$userId    = null;


# Test 1: register - success returns true
$data   = ['name' => 'Test User', 'email' => $testEmail, 'password' => 'testpass123', 'type' => 1];
$result = $user->register($data);
check("User::register returns true on success", $result === true);


# Test 2: login - valid credentials return user array
$data   = ['email' => $testEmail, 'password' => 'testpass123'];
$result = $user->login($data);
check("User::login returns user array on valid credentials", is_array($result) && isset($result['id']));

if (is_array($result) && isset($result['id'])) {
    $userId = $result['id'];
}

# Test 3: getUserById - returns correct record
$result = $user->getUserById($userId);
check("User::getUserById returns matching email", isset($result['email']) && $result['email'] === $testEmail);

# Test 4: updateUser - returns true
$result = $user->updateUser($userId, 'Updated Name', $testEmail, 1);
check("User::updateUser returns true on success", $result === true);

# Test 5: deleteUser - returns true
$result = $user->deleteUser($userId);
check("User::deleteUser returns true on success", $result === true);