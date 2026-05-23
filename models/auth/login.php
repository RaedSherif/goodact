<?php

require_once 'iAuth.php';
require_once '../Database.php';

class login implements iAuth {
    public function execute($data) {
        $db = DB::get()->conn;

        $stmt = $db->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$data['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($data['password'],
                                     $user['password'])) {
            return $user;
        }
        return false;
    }
}

?>