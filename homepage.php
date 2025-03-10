<!DOCTYPE html>
<html lang="en">
<!-- Include necessary files and start session -->
<?php
session_start();
include('./db_connect.php');
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo isset($_SESSION['system']['name']) ? $_SESSION['system']['name'] : '' ?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <style>
        /* Add custom styles here */
        body {
            font-family: Arial, sans-serif;
        }

        .hero {
            background-image: url('assets/images/banner1.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 250px 0;
            text-align: center;
            height: 600px;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 30px;
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 30px;
        }

        .featured-rentals .card {
            margin-bottom: 20px;
        }

        .services {
            background-color: #f8f9fa;
            padding: 50px 0;
        }

        .services h2 {
            margin-bottom: 30px;
        }

        .services .service-item {
            margin-bottom: 20px;
        }

        .testimonials {
            padding: 50px 0;
            text-align: center;
        }

        .testimonials h2 {
            margin-bottom: 30px;
        }

        .about-us {
            padding: 50px 0;
            background-color: #f8f9fa;
        }

        .about-us h2 {
            margin-bottom: 30px;
        }

        .contact {
            padding: 50px 0;
        }

        .contact form {
            max-width: 500px;
            margin: 0 auto;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        footer a {
            color: #fff;
        }

    </style>
</head>

<body>
    <!-- Header Section -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Smart Agencies Rentals Management System</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="homepage.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tenants_login.php">Rentals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Agent</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Find Your Dream Rental</h1>
            <p>Explore our wide range of rental properties</p>
            <a href="tenants_login.php" class="btn btn-primary">View Rentals</a>
        </div>
    </section></br>

    <!-- Featured Rentals Section -->
<section class="featured-rentals">
    <div class="container">
    <center><h2>Simply The Best Ahead Of The Rest</h2></center>
    <div class="row">
        <!-- Rental Cards -->
        <div class="col-md-4 mt-4"> <!-- Add mt-4 class here -->
            <div class="card">
                <img src="assets/images/property-2955057_1920.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Featured Rental 1</h5>
                    <p class="card-text">Brief description of the rental property.</p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4"> <!-- Add mt-4 class here -->
            <div class="card">
                <img src="assets/images/house-purchase-1019764_1920.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Featured Rental 2</h5>
                    <p class="card-text">Brief description of the rental property.</p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4"> <!-- Add mt-4 class here -->
            <div class="card">
                <img src="assets/images/keys.jpg" class="card-img-top" alt="..."></br>
                <div class="card-body">
                    <h5 class="card-title">Featured Rental 3</h5>
                    <p class="card-text">Brief description of the rental property.</p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
    </div>
</div>

</section>

    <!-- Services Offered Section -->
    <section class="services">
        <div class="container">
            <center><h2>Our Services</h2></center>
            <div class="row">
                <div class="col-md-4 service-item">
                    <h3>Property Management</h3>
                    <p>Description of property management service.</p>
                </div>
                <div class="col-md-4 service-item">
                    <h3>Tenant Screening</h3>
                    <p>Description of tenant screening service.</p>
                </div>
                <div class="col-md-4 service-item">
                    <h3>Maintenance</h3>
                    <p>Description of maintenance service.</p>
                </div>
            </div>
        </div>
    </section>

     <!-- Testimonial  Grid -->
            <section class="testimonials">
                <div class="container">
                    <h2>Testimonials</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="testimonial">
                                <img src="assets/images/user-33638_1280.jpg" alt="Client 1">
                                <h3>Client 1</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis felis at velit aliquet
                                    lobortis.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="testimonial">
                                <img src="assets/images/teacher-295387_1280.jpg" alt="Client 2">
                                <h3>Client 2</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis felis at velit aliquet
                                    lobortis.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="testimonial">
                                <img src="assets/images/user-33638_1280.jpg" alt="Client 3">
                                <h3>Client 3</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis felis at velit aliquet
                                    lobortis.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </section>

    <!-- About Us Section -->
    <section class="about-us">
        <div class="container">
            <h2>About Us</h2>
            <p>Brief overview of the company.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <form>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter your name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" id="message" rows="3" placeholder="Enter your message"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2022 Rental Management. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-right">
                    <a href="#">Terms of Service</a> | <a href="#">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>

</html>

