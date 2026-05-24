<?php
session_start();
require_once '../models/AuthManager.php';
require_once '../models/User.php';
require_once '../utils/Logger.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user    = new User();
    $manager = new AuthManager($user, $_POST['action']);
    $manager->attach(Logger::getInstance());

    $result  = $manager->execute($_POST);

    if ($_POST['action'] == "register") {
        if ($result) {
            header("Location: ../views/login.php");
        } else {
            echo "Registration failed.";
        }
    } else if ($_POST['action'] == "login") {
        if ($result) {
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['role']    = $result['user_type_id'];

            if ($result['user_type_id'] == 1) {
                header("Location: ../views/userDashboard.php");
            } elseif ($result['user_type_id'] == 2) {
                header("Location: ../views/providerDashboard.php");
            } else {
                header("Location: ../views/adminDashboard.php");
            }
        } else {
            echo "Wrong email or password.";
        }
    }
}
