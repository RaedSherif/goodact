<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../models/BaseMenu.php';


$menu = new BaseMenu();

$items = $menu->getMenuItems();
$names = array_column($items, 'name');

check(
    "BaseMenu returns My Profile and Logout",
    count($items) === 2
    && in_array('My Profile', $names, true)
    && in_array('Logout',     $names, true)
);
