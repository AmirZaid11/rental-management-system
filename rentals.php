<?php
session_start();
include('./db_connect.php');

if (!isset($_SESSION['login_id'])) {
    header("Location: tenants_login.php?redirect=rentals.php"); // Redirect user to login
    exit();
}

// Default query to fetch all available houses
$query = "SELECT * FROM houses WHERE status = 'Available'";

// Filtering logic
if (!empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $query .= " AND location LIKE '%$search%'";
}

if (!empty($_GET['status']) && $_GET['status'] !== "All") {
    $status = $conn->real_escape_string($_GET['status']);
    $query .= " AND status = '$status'";
}

if (!empty($_GET['sort'])) {
    $sortOption = $_GET['sort'];
    if ($sortOption === "Low to High") {
        $query .= " ORDER BY price ASC";
    } elseif ($sortOption === "High to Low") {
        $query .= " ORDER BY price DESC";
    }
}

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
    <div class="d-flex justify-content-between align-items-center">
        <h2>Find Your Dream Rental</h2>

        <!-- Logout Button -->
        <a href="logout.php" class="btn btn-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <!-- Dark Mode Toggle -->
    <div class="text-end mt-2">
        <button class="btn btn-dark" onclick="toggleDarkMode()">🌙 Dark Mode</button>
    </div>

    <!-- Search & Filters Form -->
    <form method="GET" action="rentals.php">
        <div class="row filter-container">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search by location" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
            </div>
            <div class="col-md-3">
                <select name="sort" class="form-select">
                    <option value="">Sort by Price</option>
                    <option value="Low to High" <?= isset($_GET['sort']) && $_GET['sort'] == "Low to High" ? 'selected' : '' ?>>Low to High</option>
                    <option value="High to Low" <?= isset($_GET['sort']) && $_GET['sort'] == "High to Low" ? 'selected' : '' ?>>High to Low</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="All">Filter by Status</option>
                    <option value="Available" <?= isset($_GET['status']) && $_GET['status'] == "Available" ? 'selected' : '' ?>>Available</option>
                    <option value="Booked" <?= isset($_GET['status']) && $_GET['status'] == "Booked" ? 'selected' : '' ?>>Booked</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="rentals.php" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <!-- Rental Listings Grid -->
    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card rental-card">
                <?php 
    $imagePath = !empty($row['image']) ? 'assets/uploads/' . $row['image'] : 'assets/uploads/default-house.jpg';

    // Debugging: Check if file exists
    if (!file_exists("C:/xampp/htdocs/hr/" . $imagePath)) {
        echo "<p style='color:red;'>Error: Image not found at $imagePath</p>";
        $imagePath = "assets/uploads/default-house.jpg";
    }
?>
<img src="<?= $imagePath ?>" class="card-img-top rental-img" alt="House Image">

                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-home"></i> House No: <?= $row['house_no'] ?></h5>
                        <p class="card-text"><i class="fas fa-map-marker-alt"></i> 
    <?= isset($row['location']) ? htmlspecialchars($row['location']) : 'Location not available'; ?>
</p>


                        <p class="card-text"><i class="fas fa-dollar-sign"></i> Price: KES <?= number_format($row['price'], 2) ?></p>
                        <span class="badge bg-success"><?= $row['status'] ?></span>
                        
                        <!-- Book Now Button Redirecting to Tenants Dashboard -->
                        <a href="tenant_dashboard.php" class="btn btn-primary w-100 mt-3">
                            Book Now <i class="fas fa-arrow-right"></i>
                        </a>
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
