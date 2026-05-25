<?php
require_once __DIR__ . '/../database/database.php';

class Listing {
    private $db;

    public function __construct() {
        $this->db = DB::getInstance()->getConnection();
    }

    public function createWithEAV($provider_id, $title, $trait_name, $trait_value, $is_premium) {
        $stmt = $this->db->prepare("INSERT INTO listing (provider_id, title, is_premium) VALUES (?, ?, ?)");
        $stmt->execute([$provider_id, $title, $is_premium]);
        $listing_id = $this->db->lastInsertId();

        $stmt2 = $this->db->prepare("INSERT IGNORE INTO attribute (name) VALUES (?)");
        $stmt2->execute([$trait_name]);
        
        $stmt3 = $this->db->prepare("SELECT id FROM attribute WHERE name = ?");
        $stmt3->execute([$trait_name]);
        $attribute_id = $stmt3->fetchColumn();

        $stmt4 = $this->db->prepare("INSERT INTO listing_value (listing_id, attribute_id, value) VALUES (?, ?, ?)");
        $stmt4->execute([$listing_id, $attribute_id, $trait_value]);
        return true;
    }

    public function getListingsByProviderWithDetails($provider_id) {
        $stmt = $this->db->prepare("SELECT id, title, is_premium FROM listing WHERE provider_id = ?");
        $stmt->execute([$provider_id]);
        $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($listings)) return [];

        $attrStmt = $this->db->query("SELECT id, name FROM attribute");
        $dictionary = $attrStmt->fetchAll(PDO::FETCH_KEY_PAIR); 

        foreach ($listings as &$listing) {
            $valStmt = $this->db->prepare("SELECT attribute_id, value FROM listing_value WHERE listing_id = ?");
            $valStmt->execute([$listing['id']]);
            $rawValues = $valStmt->fetchAll(PDO::FETCH_ASSOC);

            $listing['traits'] = [];
            foreach ($rawValues as $row) {
                $attributeName = $dictionary[$row['attribute_id']] ?? 'Unknown';
                $listing['traits'][$attributeName] = $row['value'];
            }
        }
        return $listings;
    }

    public function updateListingTitle($listing_id, $provider_id, $title, $is_premium) {
        $stmt = $this->db->prepare("UPDATE listing SET title = ?, is_premium = ? WHERE id = ? AND provider_id = ?");
        return $stmt->execute([$title, $is_premium, $listing_id, $provider_id]);
    }

    public function deleteListing($listing_id, $provider_id) {
        $stmt = $this->db->prepare("DELETE FROM listing WHERE id = ? AND provider_id = ?");
        return $stmt->execute([$listing_id, $provider_id]);
    }

    public function getAllListingsWithDetails() {
        $stmt = $this->db->query("SELECT id, title, is_premium FROM listing");
        $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($listings)) return [];

        $attrStmt = $this->db->query("SELECT id, name FROM attribute");
        $dictionary = $attrStmt->fetchAll(PDO::FETCH_KEY_PAIR); 

        foreach ($listings as &$listing) {
            $valStmt = $this->db->prepare("SELECT attribute_id, value FROM listing_value WHERE listing_id = ?");
            $valStmt->execute([$listing['id']]);
            $rawValues = $valStmt->fetchAll(PDO::FETCH_ASSOC);

            $listing['traits'] = [];
            foreach ($rawValues as $row) {
                $attributeName = $dictionary[$row['attribute_id']] ?? 'Unknown';
                $listing['traits'][$attributeName] = $row['value'];
            }
        }
        return $listings;
    }

    public function getAllListingsAdmin() {
        $stmt1 = $this->db->prepare("SELECT * FROM listing ORDER BY id DESC");
        $stmt1->execute();
        $listings = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        $stmt2 = $this->db->prepare("SELECT id, user_name FROM user");
        $stmt2->execute();
        $users = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $finalListingsArray = array();

        foreach ($listings as $listing) {
            $providerName = "Unknown Provider";

            foreach ($users as $user) {
                if ($user['id'] == $listing['provider_id']) {
                    $providerName = $user['user_name'];
                }
            }

            $listing['provider_name'] = $providerName;

            array_push($finalListingsArray, $listing);
        }

        return $finalListingsArray;
    }

    public function deleteListingAdmin($listing_id) {
        $sql = "DELETE FROM listing WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$listing_id]);
    }
}
?>