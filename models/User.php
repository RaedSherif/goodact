<?php
require_once __DIR__ . '/../database/database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = DB::getInstance()->getConnection();
    }

    public function register($data)
    {
        $check = $this->db->prepare("SELECT id FROM user WHERE email = ?");
        $check->execute([$data['email']]);

        if ($check->fetch()) {
            return false; // email already exists
        }

        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->db->prepare(
            "INSERT INTO user (user_name, email, password, user_type_id) 
             VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $hash,
            $data['type']
        ]);
    }

    public function login($data)
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$data['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($data['password'], $user['password'])) {
            return $user;
        }
        return false;
    }
}
