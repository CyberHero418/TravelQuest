<?php

session_start();

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];
    echo "Payment failed for Booking ID: " . $booking_id;
} else {
    echo "Invalid booking ID!";
}

?>
