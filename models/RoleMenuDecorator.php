<?php
require_once __DIR__ . '/../interfaces/IMenu.php';
require_once __DIR__ . '/../database/database.php';

class RoleMenuDecorator implements IMenu {
    private IMenu $wrapper;
    private int $roleId;

    public function __construct(IMenu $wrapper, $roleId) {
        $this->wrapper = $wrapper;
        $this->roleId = $roleId;
    }

    public function getMenuItems(): array {
        $items = $this->wrapper->getMenuItems();
        $db = DB::getInstance()->getConnection();

        $stmt1 = $db->prepare("
            SELECT menu_id FROM usertype_menu WHERE user_type_id = ?");
        $stmt1->execute([$this->roleId]);
        $menuIds = $stmt1->fetchAll(PDO::FETCH_COLUMN);

        $placeholders = implode(',', array_fill(0, count($menuIds), '?'));

        $stmt2 = $db->prepare("
                SELECT name, link FROM menu WHERE id IN ($placeholders)");
            $stmt2->execute($menuIds);
            $roleItems = $stmt2->fetchAll(PDO::FETCH_ASSOC);


        return array_merge($roleItems, $items);
    }
}
?>