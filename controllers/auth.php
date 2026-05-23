<?php
session_start();
require_once '../models/auth/authManager.php';
require_once '../models/auth/login.php';
require_once '../models/auth/register.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['action'] == 'register') {
        $manager = new AuthManager(new register());

        $success = $manager->process($_POST);

        if ($success) echo "Registered successfully! Go back and log in.";
        else echo "Registration failed.";
    }

    if ($_POST['action'] == 'login') {
        $manager = new AuthManager(new login());

        $user = $manager->process($_POST);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['user_type_id'];

            if ($user['user_type_id'] == 1) {
                header("Location: ../views/admin_dashboard.php");
            } else {
                header("Location: ../views/donor_dashboard.php");
            }
            exit();
        } else {
            echo "Wrong email or password.";
        }
    }
}
?>