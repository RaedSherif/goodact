<?php
require_once __DIR__ . '/../database/database.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = DB::getInstance()->getConnection();
    }

    public function placeOrder($buyer_id, $listing_id, $notes = '') {
        $stmt = $this->db->prepare("INSERT INTO orders (buyer_id, listing_id, order_notes) VALUES (?, ?, ?)");
        return $stmt->execute([$buyer_id, $listing_id, $notes]);
    }

    public function getOrdersByBuyer($buyer_id) {
        $stmt = $this->db->prepare("SELECT id, listing_id, order_notes, order_date FROM orders WHERE buyer_id = ? ORDER BY order_date DESC");
        $stmt->execute([$buyer_id]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($orders)) return [];
        $listStmt = $this->db->query("SELECT id, title FROM listing");
        $listingDict = $listStmt->fetchAll(PDO::FETCH_KEY_PAIR);

        foreach ($orders as &$order) {
            $order['listing_title'] = $listingDict[$order['listing_id']] ?? '[Listing Removed]'; 
        }

        return $orders;
    }

    public function updateOrderNote($order_id, $buyer_id, $notes) {
        $stmt = $this->db->prepare("UPDATE orders SET order_notes = ? WHERE id = ? AND buyer_id = ?");
        return $stmt->execute([$notes, $order_id, $buyer_id]);
    }

    public function cancelOrder($order_id, $buyer_id) {
        $stmt = $this->db->prepare("DELETE FROM orders WHERE id = ? AND buyer_id = ?");
        return $stmt->execute([$order_id, $buyer_id]);
    }
}
?>