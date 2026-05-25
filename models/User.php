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
            return false;
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

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT user_name, email, user_type_id FROM user WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- ADMIN CRUD FUNCTIONS (Beginner Style) ---

    public function getAllUsers() {
        $stmt1 = $this->db->prepare("SELECT * FROM user ORDER BY id DESC");
        $stmt1->execute();
        $users = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        $stmt2 = $this->db->prepare("SELECT * FROM user_type");
        $stmt2->execute();
        $roles = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $finalUserList = array();

        foreach ($users as $user) {
            $roleName = "Unknown"; // Default value
            
            foreach ($roles as $role) {
                if ($role['id'] == $user['user_type_id']) {
                    $roleName = $role['name'];
                }
            }

            $user['role_name'] = $roleName;

            array_push($finalUserList, $user);
        }

        return $finalUserList;
    }

    public function updateUser($id, $name, $email, $role_id) {
        $sql = "UPDATE user SET user_name = ?, email = ?, user_type_id = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $email, $role_id, $id]);
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM user WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
