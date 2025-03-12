<?php
session_start();
include('./db_connect.php');

if (!isset($_SESSION['login_id'])) {
    header("Location: index.php");
    exit();
}

$tenant_id = $_SESSION['login_id'];

// Fetch available houses
$houses = $conn->query("SELECT h.id, h.house_no, c.name AS category, h.description, h.price 
                        FROM houses h 
                        JOIN categories c ON h.category_id = c.id
                        WHERE h.id NOT IN (SELECT house_id FROM bookings WHERE status = 'Confirmed')");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (localStorage.getItem("darkMode") === "true") {
                document.documentElement.classList.add("dark");
            }
        });

        function toggleDarkMode() {
            document.documentElement.classList.toggle("dark");
            localStorage.setItem("darkMode", document.documentElement.classList.contains("dark"));
        }

        function bookHouse(event) {
            event.preventDefault();
            let houseId = document.getElementById("house_id").value;
            let messageBox = document.getElementById("bookingMessage");

            if (!houseId) {
                messageBox.innerHTML = '<p class="text-red-600">Please select a house to book.</p>';
                return;
            }

            fetch("process_booking.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "house_id=" + houseId
            })
            .then(response => response.json())
            .then(data => {
                messageBox.innerHTML = `<p class="${data.status === 'success' ? 'text-green-600' : 'text-red-600'}">${data.message}</p>`;
                if (data.status === "success") {
                    document.getElementById("houseForm").reset();
                }
            })
            .catch(error => console.error("Error:", error));
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

<div class="max-w-2xl mx-auto mt-10 p-6 bg-white dark:bg-gray-800 shadow-md rounded">
    <h1 class="text-2xl font-bold text-blue-600 dark:text-blue-400">🏡 Book a House</h1>

    <form id="houseForm" onsubmit="bookHouse(event)" class="mt-4">
        <label class="block mb-2 font-medium">Select House:</label>
        <select id="house_id" name="house_id" class="w-full p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
            <option value="">-- Choose a House --</option>
            <?php while ($house = $houses->fetch_assoc()) { ?>
                <option value="<?php echo $house['id']; ?>">
                    <?php echo "House No: " . $house['house_no'] . " - " . $house['category'] . " (KES " . number_format($house['price']) . ")"; ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit" class="mt-4 w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-500">Book Now</button>
    </form>

    <div id="bookingMessage" class="mt-4 text-center font-medium"></div>
</div>

</body>
</html>
