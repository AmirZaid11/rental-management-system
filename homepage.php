<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include('./db_connect.php');
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Agencies Rentals Management System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }

        .hero {
            background: url('assets/images/banner1.jpg') no-repeat center center/cover;
            color: #fff;
            padding: 250px 0;
            text-align: center;
            height: 600px;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 30px;
        }

        /* Rental Calculator Button */
        .calculator-btn {
            display: block;
            margin: 30px auto;
            width: 200px;
            font-size: 18px;
        }

        /* Rental Calculator Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background: #222;
            color: #fff;
            width: 350px;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            position: relative;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .modal-content select,
        .modal-content input {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background: #333;
            color: #fff;
            font-size: 16px;
        }

        .modal-content input::placeholder {
            color: #bbb;
        }

        .modal-content .btn {
            width: 100%;
            padding: 10px;
            font-size: 18px;
            margin-top: 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .close-btn {
            background: #dc3545;
            color: white;
        }

        .clear-btn {
            background: #ffc107;
            color: black;
        }

        .calculate-btn {
            background: #007bff;
            color: white;
        }

        #totalCost {
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
        }

        /* Footer */
        footer {
            background: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Smart Agencies Rentals</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a class="nav-link" href="homepage.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="tenants_login.php">Rentals</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Agent</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Find Your Dream Rental</h1>
            <p>Explore our wide range of rental properties</p>
            <?php
            $rentals_link = isset($_SESSION['login_id']) ? "rentals.php" : "tenants_login.php?redirect=rentals.php";
            ?>
            <a href="<?php echo $rentals_link; ?>" class="btn btn-primary">View Rentals</a>
        </div>
    </section>

    <!-- Our Services Section -->
<section id="services" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Our Services</h2>
        <div class="row">
            <!-- Service 1 -->
            <div class="col-md-4">
                <div class="service-card">
                    <div class="icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h4>Rental Property Listings</h4>
                    <p>Browse a variety of available rental properties with updated listings and competitive pricing.</p>
                </div>
            </div>

            <!-- Service 2 -->
            <div class="col-md-4">
                <div class="service-card">
                    <div class="icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h4>Lease Agreement Assistance</h4>
                    <p>Get professional guidance on lease agreements to ensure clarity and compliance.</p>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="col-md-4">
                <div class="service-card">
                    <div class="icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h4>Maintenance & Repairs</h4>
                    <p>We offer quick and reliable maintenance solutions for your rented property.</p>
                </div>
            </div>

            <!-- Service 4 -->
            <div class="col-md-4">
                <div class="service-card">
                    <div class="icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Security & Safety Checks</h4>
                    <p>We ensure every rental property meets high security and safety standards.</p>
                </div>
            </div>

            <!-- Service 5 -->
            <div class="col-md-4">
                <div class="service-card">
                    <div class="icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h4>24/7 Customer Support</h4>
                    <p>Our support team is available 24/7 to assist tenants and resolve any issues.</p>
                </div>
            </div>

            <!-- Service 6 -->
            <div class="col-md-4">
                <div class="service-card">
                    <div class="icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h4>Flexible Payment Options</h4>
                    <p>Choose from multiple payment methods for your rent, including mobile money & bank transfers.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Styles for Services -->
<style>
    #services {
        background: #f8f9fa;
    }
    
    .service-card {
        background: rgba(255, 255, 255, 0.85);
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
        margin-bottom: 20px;
    }

    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.15);
    }

    .service-card .icon {
        font-size: 40px;
        color: #007bff;
        margin-bottom: 10px;
    }

    .service-card h4 {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .service-card p {
        font-size: 14px;
        color: #555;
    }
</style>

<!-- FontAwesome for Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!-- Rental Calculator Button -->
    <button class="btn btn-dark calculator-btn" onclick="openCalculator()">🧮 Calculator</button>

    <!-- Rental Calculator Modal -->
    <div id="calculatorModal" class="modal">
        <div class="modal-content">
            <h3>Rental Cost Calculator</h3>
            <select id="currency">
                <option value="KES">KES</option>
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
                <option value="GBP">GBP</option>
            </select>
            <input type="number" id="baseRent" placeholder="Enter Monthly Rent" oninput="autoCalculate()">
            <input type="number" id="utilities" placeholder="Estimated Utilities" oninput="autoCalculate()">
            <input type="number" id="otherCharges" placeholder="Other Monthly Charges" oninput="autoCalculate()">
            <p id="totalCost">Total Cost: KES 0.00</p>
            <button class="btn clear-btn" onclick="clearCalculator()">Clear</button>
            <button class="btn close-btn" onclick="closeCalculator()">Close</button>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Smart Agencies Rentals | Developed by Ernest</p>
    </footer>

    <!-- JavaScript -->
    <script>
        function openCalculator() {
            document.getElementById("calculatorModal").style.display = "block";
        }

        function closeCalculator() {
            document.getElementById("calculatorModal").style.display = "none";
        }

        function clearCalculator() {
            document.getElementById("baseRent").value = "";
            document.getElementById("utilities").value = "";
            document.getElementById("otherCharges").value = "";
            autoCalculate();
        }

        function autoCalculate() {
            var rent = parseFloat(document.getElementById("baseRent").value) || 0;
            var utilities = parseFloat(document.getElementById("utilities").value) || 0;
            var otherCharges = parseFloat(document.getElementById("otherCharges").value) || 0;
            var total = rent + utilities + otherCharges;

            var currency = document.getElementById("currency").value;
            document.getElementById("totalCost").innerText = `Total Cost: ${currency} ${total.toFixed(2)}`;
        }
    </script>

</body>
</html>
