<?php
session_start();
require_once '../models/User.php';

if ($_SESSION['role'] != 3) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userModel = new User();
    
    $action = $_POST['action'];

    if ($action == "create") {
        
        $data = array();
        $data['name'] = $_POST['name'];
        $data['email'] = $_POST['email'];
        $data['password'] = $_POST['password'];
        $data['type'] = $_POST['type'];
        
        $userModel->register($data);
        
    } else if ($action == "update") {
        
        $userModel->updateUser($_POST['user_id'], $_POST['name'], $_POST['email'], $_POST['type']);
        
    } else if ($action == "delete") {
        
        if ($_POST['user_id'] != $_SESSION['user_id']) {
            $userModel->deleteUser($_POST['user_id']);
        }
        
    }

    header("Location: ../views/admin_users.php");
    exit();
}
?>