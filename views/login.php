<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Goodwill - Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <div class="container">
        <img src="../assets/logo.png" alt="Goodact Logo" class="brand-logo">
        <h2>Login</h2>
        
        <form action="../controllers/AuthController.php" method="POST">
            <input type="hidden" name="action" value="login">
            
            <input type="email" name="email" placeholder="Email Address" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            
            <button type="submit">Login</button>
        </form>

        <br>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>

</body>
</html>