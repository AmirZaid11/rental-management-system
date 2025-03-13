<?php
session_start();
include('./db_connect.php');

if (!isset($_SESSION['login_id'])) {
    header("Location: tenants_login.php?redirect=rentals.php"); // Send user to login
    exit();
}

// Fetch available houses
$query = "SELECT * FROM houses WHERE status = 'Available'";
$result = $conn->query($query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Rentals</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: #f4f6f9;
            transition: background 0.3s, color 0.3s;
        }
        .dark-mode {
            background: #121212;
            color: white;
        }
        .rental-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .rental-card:hover {
            transform: scale(1.02);
        }
        .rental-img {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }
        .badge {
            font-size: 14px;
            padding: 5px 10px;
        }
        .filter-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center mb-4">Find Your Dream Rental</h2>

    <!-- Dark Mode Toggle -->
    <div class="text-end">
        <button class="btn btn-dark" onclick="toggleDarkMode()">🌙 Dark Mode</button>
    </div>

    <!-- Search & Filters -->
    <div class="row filter-container">
        <div class="col-md-3">
            <input type="text" id="search" class="form-control" placeholder="Search by location">
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option>Sort by Price</option>
                <option>Low to High</option>
                <option>High to Low</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option>Filter by Status</option>
                <option>Available</option>
                <option>Booked</option>
            </select>
        </div>
    </div>

    <!-- Rental Listings Grid -->
    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card rental-card">
                    <img src="house.jpg" class="card-img-top rental-img" alt="House">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-home"></i> House No: <?= $row['house_no'] ?></h5>
                        <p class="card-text"><i class="fas fa-map-marker-alt"></i> Description: <?= $row['description'] ?></p>
                        <p class="card-text"><i class="fas fa-dollar-sign"></i> Price: KES <?= $row['price'] ?></p>
                        <span class="badge bg-success"><?= $row['status'] ?></span>
                        <a href="#" class="btn btn-primary w-100 mt-3">Book Now</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- JavaScript for Dark Mode -->
<script>
function toggleDarkMode() {
    document.body.classList.toggle("dark-mode");
}
</script>

</body>
</html>
