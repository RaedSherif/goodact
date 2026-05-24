<?php

require_once 'iAuth.php';
require_once __DIR__ . '/../../database/database.php';

class register implements iAuth {
    public function execute($data){
        $db = DB::getInstance()->getConnection();

        $checkStmt = $db->prepare("SELECT id FROM user WHERE email = ?");
        $checkStmt->execute([$data['email']]);
        
        if ($checkStmt->fetch()) {
            return false; 
        }

        $hash = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO user (user_name, email, password, user_type_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['name'],
                               $data['email'],
                               $hash,
                               $data['type']]);
        }
}

?>