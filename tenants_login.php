<?php
session_start();
include('./db_connect.php');

ob_start();
if (!isset($_SESSION['system'])) {
    $system = $conn->query("SELECT * FROM system_settings LIMIT 1")->fetch_array();
    foreach ($system as $k => $v) {
        $_SESSION['system'][$k] = $v;
    }
}
ob_end_flush();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data
    $query = "SELECT * FROM clients WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        $_SESSION['login_id'] = $row['id'];
        $_SESSION['tenant_name'] = $row['name'];

        // Redirect to tenant dashboard
        header("Location: tenant_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?php echo $_SESSION['system']['name'] ?></title>

    <?php include('./header.php'); ?>

    <style>
        body {
            width: 100%;
            height: 100%;
            background: #f4f6f9;
        }
        main#main {
            width: 100%;
            height: 100%;
        }
        #login-container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

<main id="main">
    <div id="login-container">
        <h4 class="text-center"><b><?php echo $_SESSION['system']['name'] ?></b></h4>
        <hr>
        <form id="login-form" method="POST">
            <div class="form-group">
                <label for="username" class="control-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <a href="homepage.php" class="btn btn-secondary btn-block">Back</a>
            </div>
            <div class="text-center">
                <p>Don't have an account? <a href="tenants_regform.php">Register here</a></p>
            </div>
        </form>
    </div>
</main>

</body>
</html>
