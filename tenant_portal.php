<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['tenant_id'])) {
    header("Location: tenants_login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Portal</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { margin-top: 50px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to the Tenant Portal</h2>
        <p>Hello, <?php echo $_SESSION['tenant_name']; ?>! You are logged in.</p>
        <a href="tenant_dashboard.php">Go to Dashboard</a> | 
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
