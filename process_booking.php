<?php
include('./db_connect.php');

error_log("🔵 process_payment.php called."); // Debug Log

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("🟡 POST request received.");

    $tenant_id = isset($_POST['tenant_id']) ? intval($_POST['tenant_id']) : 0;
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    $invoice = isset($_POST['invoice']) ? $_POST['invoice'] : '';

    error_log("🟡 Received Data -> Tenant ID: $tenant_id, Amount: $amount, Invoice: $invoice");

    if ($tenant_id <= 0 || $amount <= 0 || empty($invoice)) {
        error_log("🔴 Error: Invalid payment details.");
        echo json_encode(["status" => "error", "message" => "Invalid payment details."]);
        exit();
    }

    // Insert payment into the `payments` table
    $stmt = $conn->prepare("INSERT INTO payments (tenant_id, amount, invoice, payment_status) VALUES (?, ?, ?, 'Pending')");

    if (!$stmt) {
        error_log("🔴 SQL Error: " . $conn->error); // Debug Log
        echo json_encode(["status" => "error", "message" => "Database preparation error."]);
        exit();
    }

    $stmt->bind_param("ids", $tenant_id, $amount, $invoice);

    if ($stmt->execute()) {
        error_log("🟢 Payment successfully inserted for Invoice: $invoice");
        echo json_encode(["status" => "success", "message" => "Payment recorded successfully!"]);
    } else {
        error_log("🔴 Execution Error: " . $stmt->error);
        echo json_encode(["status" => "error", "message" => "Payment failed. Try again."]);
    }

    // Close connections
    $stmt->close();
    $conn->close();
    error_log("🔵 Database connection closed.");
}
?>
