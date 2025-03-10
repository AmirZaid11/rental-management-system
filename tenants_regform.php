<?php
session_start();
include('./db_connect.php');

ob_start();
if(!isset($_SESSION['system'])){
    $system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
    foreach($system as $k => $v){
        $_SESSION['system'][$k] = $v;
    }
}
ob_end_flush();

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check if username already exists
    $check_query = "SELECT * FROM clients WHERE username='$username'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Username already exists. Please choose a different one.');</script>";
    } else {
        // Insert new user into the database
        $insert_query = "INSERT INTO clients (name, username, password) VALUES ('$name', '$username', '$password')";
        if ($conn->query($insert_query) === TRUE) {
            $_SESSION['reg_success'] = true; // Set session variable for successful registration
        } else {
            echo "<script>alert('Error registering user.');</script>";
        }
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
    <?php 
    if(isset($_SESSION['login_id']))
        header("location:tenants_login.php");
    ?>

</head>
<style>
    body{
        width: 100%;
        height: calc(100%);
        /*background: #007bff;*/
    }
    main#main{
        width:100%;
        height: calc(100%);
        background:white;
    }
    #login-right{
        position: absolute;
        right:0;
        width:40%;
        height: calc(100%);
        background:white;
        display: flex;
        align-items: center;
    }
    #login-left{
        position: absolute;
        left:0;
        width:60%;
        height: calc(100%);
        background:#59b6ec61;
        display: flex;
        align-items: center;
        background: url(assets/images/house-4516175_640.jpg);
        background-repeat: no-repeat;
        background-size: cover;
    }
    #login-right .card{
        margin: auto;
        z-index: 1
    }
    .logo {
        margin: auto;
        font-size: 8rem;
        background: white;
        padding: .5em 0.7em;
        border-radius: 50% 50%;
        color: #000000b3;
        z-index: 10;
    }
    div#login-right::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: calc(100%);
        height: calc(100%);
        /*background: #000000e0;*/
    }

</style>

<body>

    <?php
    if(isset($_SESSION['reg_success'])) {
        echo "<script>alert('Registration successful.');</script>";
        unset($_SESSION['reg_success']); // Unset the session variable
    }
    ?>


<main id="main" class=" bg-light">
    <div id="login-left" class="bg-dark">
    </div>

    <div id="login-right" class="bg-light">
        <div class="w-100">
            <h4 class="text-blue text-center"><b><?php echo $_SESSION['system']['name'] ?></b></h4>
            <br>
            <br>
            <div class="card col-md-8">
                <div class="card-body">
                    <form id="register-form" method="POST">
                        <div class="form-group">
                            <label for="name" class="control-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn-sm btn-block btn-wave col-md-4 float-right btn-primary" name="register">Register</button>
                            <a href="homepage.php" class="btn btn-secondary">Back</a>
                        </div>

                        <div class="text-center mt-3">
                            <p>Already have an account? <a href="tenants_login.php">Login here</a></p>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>


</main>

<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
</html>
