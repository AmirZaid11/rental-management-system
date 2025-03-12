<?php
session_start();
include('./db_connect.php');

if (!isset($_SESSION['login_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch user details
$tenant_id = $_SESSION['login_id'];
$tenant = $conn->query("SELECT * FROM tenants WHERE id = $tenant_id")->fetch_assoc();
$tenant_name = $tenant['name'];
$tenant_email = $tenant['email'];
$profile_pic = $tenant['profile_pic'] ?: 'default.png';

// Fetch available houses
$availableHouses = $conn->query("SELECT h.id, h.house_no, c.name AS category, h.description, h.price 
                                 FROM houses h 
                                 JOIN categories c ON h.category_id = c.id");

// Fetch tenant bookings
$tenantBookings = $conn->query("SELECT b.id, h.house_no, c.name AS category, h.description, h.price, b.status, b.booking_date
                                FROM bookings b 
                                JOIN houses h ON b.house_id = h.id
                                JOIN categories c ON h.category_id = c.id
                                WHERE b.tenant_id = $tenant_id");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

<!-- Navbar -->
<nav class="bg-blue-600 dark:bg-gray-800 p-4 flex justify-between items-center shadow-md">
    <div class="flex items-center">
        <img src="logo.png" alt="Logo" class="h-10">
        <h1 class="text-white text-2xl font-bold ml-2">🏡 Tenant Dashboard</h1>
    </div>
    <div class="flex items-center space-x-3">
        <img src="<?php echo $profile_pic; ?>" class="w-10 h-10 rounded-full" alt="User Profile">
        <span class="text-white font-semibold"><?php echo $tenant_name; ?></span>
        <a href="logout.php" class="bg-red-600 px-3 py-1 rounded text-white shadow hover:bg-red-500">Logout</a>
    </div>
</nav>

<!-- Main Content -->
<div class="container mx-auto mt-6 p-4">

    <!-- Available Rentals -->
    <h2 class="text-2xl font-bold mt-6">🏘️ Available Rentals</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
        <?php while ($house = $availableHouses->fetch_assoc()) { ?>
            <div class="bg-white dark:bg-gray-800 p-4 rounded shadow-md">
                <h3 class="text-lg font-bold">House No: <?php echo $house['house_no']; ?></h3>
                <p><b>Category:</b> <?php echo $house['category']; ?></p>
                <p><?php echo $house['description']; ?></p>
                <p><b>Price:</b> KES <?php echo number_format($house['price']); ?></p>
                <form action="book_house.php" method="POST">
                    <input type="hidden" name="house_id" value="<?php echo $house['id']; ?>">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 w-full hover:scale-105">Book Now</button>
                </form>
            </div>
        <?php } ?>
    </div>

    <!-- My Bookings -->
    <h2 class="text-2xl font-bold mt-6">📜 My Bookings</h2>
    <table class="w-full mt-4 bg-white dark:bg-gray-800 rounded shadow-md">
        <thead class="bg-gray-200 dark:bg-gray-700">
            <tr>
                <th class="p-2">House No</th>
                <th>Category</th>
                <th>Price</th>
                <th>Status</th>
                <th>Booking Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($booking = $tenantBookings->fetch_assoc()) { ?>
                <tr class="border-b hover:bg-gray-100 dark:hover:bg-gray-700">
                    <td class="p-2"><?php echo $booking['house_no']; ?></td>
                    <td><?php echo $booking['category']; ?></td>
                    <td>KES <?php echo number_format($booking['price']); ?></td>
                    <td><?php echo ucfirst($booking['status']); ?></td>
                    <td><?php echo $booking['booking_date']; ?></td>
                    <td>
                        <?php if ($booking['status'] == 'Pending') { ?>
                            <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-500 transition cancel-booking-btn" 
                                    data-booking-id="<?php echo $booking['id']; ?>">
                                🚫 Cancel
                            </button>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<footer class="bg-gray-900 text-white p-4 text-center mt-10">
    <p>📞 Call: +254 715 264 486 | ✉ Email: eddysimba9@gmail.com</p>
</footer>

<!-- JavaScript for Cancel Booking -->
<script>
    document.querySelectorAll(".cancel-booking-btn").forEach(button => {
        button.addEventListener("click", function(event) {
            event.preventDefault();
            let bookingId = this.getAttribute("data-booking-id");
            let row = this.closest("tr"); // Get the row to remove

            if (!confirm("Are you sure you want to cancel this booking?")) return;

            fetch("cancel_booking.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `booking_id=${bookingId}`
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.status === "success") {
                    row.remove(); // Remove the booking row from the table
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
</script>


</body>
</html>
