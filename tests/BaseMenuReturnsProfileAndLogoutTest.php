<?php
/**
 * Test: BaseMenu.getMenuItems returns the default Profile + Logout entries.
 * Success scenario - menu built without role decoration.
 */

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../models/BaseMenu.php';

// setup
$menu = new BaseMenu();

// call
$items = $menu->getMenuItems();
$names = array_column($items, 'name');

// assert
check(
    "BaseMenu returns My Profile and Logout",
    count($items) === 2
    && in_array('My Profile', $names, true)
    && in_array('Logout',     $names, true)
);
