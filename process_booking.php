<?php
session_start();
include('./db_connect.php');

if (!isset($_SESSION['login_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access!']);
    exit();
}

$tenant_id = $_SESSION['login_id'];
$house_id = isset($_POST['house_id']) ? intval($_POST['house_id']) : 0;

if ($house_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid house selection.']);
    exit();
}

// Check if the house is available
$checkHouse = $conn->prepare("SELECT id FROM houses WHERE id = ? AND id NOT IN (SELECT house_id FROM bookings WHERE status = 'Confirmed') LIMIT 1");
$checkHouse->bind_param("i", $house_id);
$checkHouse->execute();
$houseResult = $checkHouse->get_result();

if ($houseResult->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'House is already booked or does not exist.']);
    exit();
}

// Check if tenant has pending booking
$checkBooking = $conn->prepare("SELECT id FROM bookings WHERE tenant_id = ? AND status = 'Pending' LIMIT 1");
$checkBooking->bind_param("i", $tenant_id);
$checkBooking->execute();
$bookingResult = $checkBooking->get_result();

if ($bookingResult->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'You already have a pending booking.']);
    exit();
}

// Insert booking
$bookingDate = date('Y-m-d H:i:s');
$insertBooking = $conn->prepare("INSERT INTO bookings (tenant_id, house_id, status, booking_date) VALUES (?, ?, 'Pending', ?)");
$insertBooking->bind_param("iis", $tenant_id, $house_id, $bookingDate);

if ($insertBooking->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Booking request sent! Await confirmation.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Booking failed. Try again later.']);
}

// Close DB connections
$insertBooking->close();
$checkHouse->close();
$checkBooking->close();
$conn->close();
?>
