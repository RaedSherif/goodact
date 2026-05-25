<?php
session_start();
if ($_SESSION['role'] != 3) {
    header('Location: login.php');
    exit();
}

require_once '../models/User.php';

$userModel = new User();
$allUsers = $userModel->getAllUsers();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container" style="max-width: 800px;">
        <h2>User Management</h2>

        <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px;">
            <h3>Add New User</h3>
            <br>
            <form action="../controllers/admin_user_controller.php" method="POST">
                <input type="hidden" name="action" value="create">
                
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                
                <select name="type" required>
                    <option value="1">User (Buyer)</option>
                    <option value="2">Provider (Seller)</option>
                    <option value="3">Admin</option>
                </select>
                
                <button type="submit">Create User</button>
            </form>
        </div>

        <br><br>

        <h3>All Registered Users</h3>
        <br>
        <table border="1" width="100%" cellpadding="10" style="border-collapse: collapse; text-align: left; background: rgba(0,0,0,0.3); color: white;">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            
            <?php foreach ($allUsers as $u) { ?>
            <tr>
                <td><?php echo $u['id']; ?></td>
                <td><?php echo $u['user_name']; ?></td>
                <td><?php echo $u['email']; ?></td>
                <td><?php echo $u['role_name']; ?></td>
                <td>
                    <a href="adminEditUser.php?id=<?php echo $u['id']; ?>&name=<?php echo urlencode($u['user_name']); ?>&email=<?php echo urlencode($u['email']); ?>&role=<?php echo $u['user_type_id']; ?>" style="color: lightblue;">Edit</a>
                    
                    <br><br>
                    
                    <?php if ($u['id'] != $_SESSION['user_id']) { ?>
                        <form action="../controllers/admin_user_controller.php" method="POST">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                            <button type="submit" style="background: red; padding: 5px; font-size: 12px; margin: 0;">Delete</button>
                        </form>
                    <?php } else { ?>
                        <i>You</i>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
            
        </table>

        <br>
        <a href="adminDashboard.php">Go Back</a>
    </div>
</body>
</html>