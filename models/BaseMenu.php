<?php
require_once __DIR__ . '/../interfaces/IMenu.php';

class BaseMenu implements IMenu {
    public function getMenuItems(): array {
        return [
            ['name' => 'My Profile', 'link' => 'profile.php'],
            ['name' => 'Logout', 'link' => '../controllers/logout.php']
        ];
    }
}
?>