<?php

session_start();
include 'config.php';

// SSLCOMMERZ sends back the transaction status here
if (!isset($_GET['booking_id'])) {
    echo "Invalid booking ID!";
    exit();
}

$booking_id = $_GET['booking_id'];
$tran_id = $_POST['tran_id'];
$amount = $_POST['amount'];
$currency = $_POST['currency'];
$transaction_status = $_POST['status'];

// Verify payment success
if ($transaction_status == "VALID") {
    // Update booking status to "Confirmed"
    $query = "UPDATE booking SET status = 'Confirmed' WHERE booking_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {
        echo "Booking Confirmed!";
    } else {
        echo "Error updating booking status!";
    }

    // Insert transaction details into a payments table (optional)
    $insert_query = "INSERT INTO payments (booking_id, transaction_id, amount, currency, status) VALUES (?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $status = 'Confirmed';
    $insert_stmt->bind_param("issds", $booking_id, $tran_id, $amount, $currency, $status);
    $insert_stmt->execute();
} else {
    echo "Payment verification failed!";
}

?>
