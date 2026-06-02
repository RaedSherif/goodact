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
        $stmt = $this->db->prepare("SELECT id, listing_id, order_notes, order_date FROM orders WHERE buyer_id = ? AND is_deleted = 0 ORDER BY order_date DESC");
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
        $stmt = $this->db->prepare("UPDATE orders SET order_notes = ? WHERE id = ? AND buyer_id = ? AND is_deleted = 0");
        return $stmt->execute([$notes, $order_id, $buyer_id]);
    }

    public function cancelOrder($order_id, $buyer_id) {
        $stmt = $this->db->prepare("UPDATE orders SET is_deleted = 1 WHERE id = ? AND buyer_id = ?");
        return $stmt->execute([$order_id, $buyer_id]);
    }

    public function getOrdersForProvider($provider_id) {
        $finalOrders = [];

        $stmt1 = $this->db->prepare("SELECT id, title FROM listing WHERE provider_id = ?");
        $stmt1->execute([$provider_id]);
        $myListings = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        foreach ($myListings as $listing) {
            
            $stmt2 = $this->db->prepare("SELECT buyer_id FROM orders WHERE listing_id = ? AND is_deleted = 0");
            $stmt2->execute([$listing['id']]);
            $ordersForThisItem = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($ordersForThisItem as $order) {
                
                $stmt3 = $this->db->prepare("SELECT user_name FROM user WHERE id = ?");
                $stmt3->execute([$order['buyer_id']]);
                $buyer = $stmt3->fetch(PDO::FETCH_ASSOC);

                $finalOrders[] = [
                    'item_name' => $listing['title'],
                    'buyer_name' => $buyer['user_name']
                ];
            }
        }

        return $finalOrders;
    }

    public function getAllOrdersAdmin() {
        $stmt1 = $this->db->prepare("SELECT * FROM orders WHERE is_deleted = 0 ORDER BY id DESC");
        $stmt1->execute();
        $orders = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        $stmt2 = $this->db->prepare("SELECT id, user_name FROM user");
        $stmt2->execute();
        $users = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $stmt3 = $this->db->prepare("SELECT id, title FROM listing");
        $stmt3->execute();
        $listings = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        $finalOrdersList = array();

        foreach ($orders as $order) {
            $buyerName = "Unknown Buyer";
            $itemName = "Unknown Item";

            foreach ($users as $user) {
                if ($user['id'] == $order['buyer_id']) {
                    $buyerName = $user['user_name'];
                }
            }

            foreach ($listings as $listing) {
                if ($listing['id'] == $order['listing_id']) {
                    $itemName = $listing['title'];
                }
            }

            $order['buyer_name'] = $buyerName;
            $order['item_name'] = $itemName;

            array_push($finalOrdersList, $order);
        }

        return $finalOrdersList;
    }

    public function deleteOrderAdmin($order_id) {
        $sql = "UPDATE orders SET is_deleted = 1 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$order_id]);
    }
}
?>