<?php 
session_start();
include('./db_connect.php');

if (!isset($_SESSION['login_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access!"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    
    // Update the booking status to 'Cancelled'
    $stmt = $conn->prepare("UPDATE bookings SET status = 'Cancelled' WHERE id = ? AND tenant_id = ?");
    $stmt->bind_param("ii", $booking_id, $_SESSION['login_id']);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Booking cancelled successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error cancelling booking!"]);
    }

    $stmt->close();
    exit();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request!"]);
    exit();
}
?>

