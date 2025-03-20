<?php
session_start();
include('./db_connect.php');

if (!isset($_SESSION['login_id'])) {
    header("Location: index.php");
    exit();
}

$tenant_id = $_SESSION['login_id'];

// Fetch available houses
$houses = $conn->query("SELECT * FROM houses WHERE status = 'Available'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a House</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white dark:bg-gray-800 shadow-md rounded">
        <h1 class="text-2xl font-bold text-blue-600 dark:text-blue-400">🏡 Book a House</h1>

        <!-- House Selection Form -->
        <form id="houseForm" class="mt-4">
            <label class="block mb-2 font-medium">Select House:</label>
            <select id="house_id" name="house_id" class="w-full p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-gray-200" onchange="updatePaymentAmount()">
                <option value="">-- Choose a House --</option>
                <?php while ($house = $houses->fetch_assoc()) { ?>
                    <option value="<?php echo $house['id']; ?>" data-price="<?php echo $house['price']; ?>">
                        <?php echo "House No: " . $house['house_no'] . " - " . $house['description'] . " (KES " . number_format($house['price']) . ")"; ?>
                    </option>
                <?php } ?>
            </select>

            <button type="button" onclick="showPaymentModal()" class="mt-4 w-full bg-green-600 text-white p-2 rounded hover:bg-green-500" id="proceedPayment">Proceed to Payment</button>

            <button type="submit" id="confirmBooking" disabled class="mt-4 w-full bg-blue-600 text-white p-2 rounded opacity-50 cursor-not-allowed">Confirm Booking</button>
        </form>

        <div id="bookingMessage" class="mt-4 text-center font-medium"></div>
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md">
            <h2 class="text-lg font-bold">💳 Make Payment</h2>
            <p class="text-sm text-gray-600">Amount: <strong id="paymentAmount">KES 5000</strong></p>

            <button id="payButton" onclick="processPayment()" class="mt-4 w-full bg-green-600 text-white p-2 rounded hover:bg-green-500">Pay Now</button>

            <button onclick="document.getElementById('paymentModal').classList.add('hidden')" class="mt-2 w-full bg-red-600 text-white p-2 rounded hover:bg-red-500">Cancel</button>
        </div>
    </div>

    <script>
        // Update Payment Amount Based on Selected House
        function updatePaymentAmount() {
            let selectedHouse = document.getElementById("house_id");
            let selectedOption = selectedHouse.options[selectedHouse.selectedIndex];
            let price = selectedOption.dataset.price || 5000;
            document.getElementById("paymentAmount").textContent = `KES ${new Intl.NumberFormat().format(price)}`;
        }

        // Show Payment Modal
        function showPaymentModal() {
            let houseId = document.getElementById("house_id").value;
            if (!houseId) {
                alert("⚠️ Please select a house first!");
                return;
            }
            document.getElementById("paymentModal").classList.remove("hidden");
        }

        // Process Payment
        function processPayment() {
            let payButton = document.getElementById("payButton");
            payButton.innerText = "Processing...";
            payButton.disabled = true;

            setTimeout(() => {
                let tenantId = "<?php echo $tenant_id; ?>";
                let amount = document.getElementById("paymentAmount").textContent.replace("KES ", "");
                let invoice = "INV-" + Math.floor(Math.random() * 1000000);

                fetch('process_booking.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `tenant_id=${tenantId}&amount=${amount}&invoice=${invoice}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById("paymentModal").classList.add("hidden");
                        document.getElementById("confirmBooking").disabled = false;
                        document.getElementById("confirmBooking").classList.remove("opacity-50", "cursor-not-allowed");
                        document.getElementById("payButton").innerText = "Pay Now";
                        document.getElementById("bookingMessage").innerHTML = '<p class="text-green-600">✅ Payment successful! Now you can book the house.</p>';
                    } else {
                        alert("❌ Payment failed: " + data.message);
                    }
                    payButton.innerText = "Pay Now";
                    payButton.disabled = false;
                })
                .catch(error => {
                    alert("❌ Error processing payment!");
                    payButton.innerText = "Pay Now";
                    payButton.disabled = false;
                });
            }, 2000);
        }

        // Book House
        document.getElementById("houseForm").addEventListener("submit", function(event) {
            event.preventDefault();
            let houseId = document.getElementById("house_id").value;
            let messageBox = document.getElementById("bookingMessage");

            if (!houseId) {
                messageBox.innerHTML = '<p class="text-red-600">⚠️ Please select a house to book.</p>';
                return;
            }

            fetch("process_booking.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `house_id=${houseId}`
            })
            .then(response => response.json())
            .then(data => {
                messageBox.innerHTML = `<p class="${data.status === 'success' ? 'text-green-600' : 'text-red-600'}">${data.message}</p>`;
                if (data.status === "success") {
                    document.getElementById("houseForm").reset();
                    document.getElementById("confirmBooking").disabled = true;
                    document.getElementById("confirmBooking").classList.add("opacity-50", "cursor-not-allowed");
                }
            })
            .catch(error => {
                console.error("🔴 Booking Error:", error);
            });
        });
    </script>

</body>
</html>
