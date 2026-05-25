<?php
session_start();
if ($_SESSION['role'] != 3) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit User</h2>
        <br>
        
        <form action="../controllers/admin_user_controller.php" method="POST">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="user_id" value="<?php echo $_GET['id']; ?>">
            
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $_GET['name']; ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $_GET['email']; ?>" required>
            
            <label>Role:</label>
            <select name="type" required>
                <option value="1" <?php if($_GET['role'] == 1) { echo 'selected'; } ?>>User</option>
                <option value="2" <?php if($_GET['role'] == 2) { echo 'selected'; } ?>>Provider</option>
                <option value="3" <?php if($_GET['role'] == 3) { echo 'selected'; } ?>>Admin</option>
            </select>
            
            <br>
            <button type="submit">Save Changes</button>
        </form>

        <br>
        <a href="admin_users.php">Cancel</a>
    </div>
</body>
</html>