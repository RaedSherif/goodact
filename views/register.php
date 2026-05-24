<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Goodwill - Register</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <div class="container">
        <img src="../assets/logo.png" alt="Goodact Logo" class="brand-logo">
        <h2>Create an Account</h2>
        
        <form action="../controllers/AuthController.php" method="POST">
            <input type="hidden" name="action" value="register">
            
            <input type="text" name="name" placeholder="Full Name" required> <br>
            <input type="email" name="email" placeholder="Email Address" required> <br>
            <input type="password" name="password" placeholder="Password" required> <br>
            
            <select name="type" required>
                <option value="1">User</option>
                <option value="2">Provider</option>
            </select> <br>
            
            <button type="submit">Register</button>
        </form>

        <br>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>

</body>
</html>