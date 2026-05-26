<?php
session_start();
// If they are already logged in, skip the landing page and send them to their dashboard
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 1) header("Location: views/userDashboard.php");
    elseif ($_SESSION['role'] == 2) header("Location: views/providerDashboard.php");
    elseif ($_SESSION['role'] == 3) header("Location: views/adminDashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goodact - Connecting Hands, Changing Lives</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <style>

    </style>
</head>
<body>

    <div class="container" style="max-width: 500px;">
        <img src="assets/logo.png" alt="Goodact Logo" class="brand-logo" style="max-width: 180px; margin-bottom: 20px;">
        
        <h1 style="font-size: 32px; font-weight: 700; margin-bottom: 15px;">Welcome to Goodact</h1>
        
        <p class="hero-text">
            The premier platform dedicated to bridging the gap between those who have and those in need. 
            Whether you are a provider looking to list resources, or a community member claiming them, 
            Goodact makes organizing goodwill seamless, transparent, and efficient.
        </p>

        <div class="action-buttons">
            <a href="views/register.php" style="border: none;">
                <button type="button" class="btn-primary">Create an Account</button>
            </a>
            
            <a href="views/login.php" style="border: none;">
                <button type="button" class="btn-outline">Login to Dashboard</button>
            </a>

            <a href="views/about.php" style="border: none; margin-top: 10px;">
                <button type="button" class="btn-about">Read Our Story (About Us)</button>
            </a>
        </div>
    </div>

</body>
</html>