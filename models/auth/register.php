<?php

require_once 'iAuth.php';
require_once '/../../database/database.php';

class register implements iAuth {
    public function execute($data){
        $db = DB::getInstance()->getConnection();
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO user (user_name, email, password, user_type_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['name'],
                               $data['email'],
                               $hash,
                               $data['type']]);
        }
}

?>