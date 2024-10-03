<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$step = 1;  // Initial step is to enter the Booking ID
$booking_id = null;
$total_amount = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user submitted a booking ID
    if (isset($_POST['booking_id']) && !isset($_POST['proceed_payment'])) {
        $booking_id = $_POST['booking_id'];

        // Fetch booking details from the database based on booking_id and user_id
        $query = "SELECT total_price FROM booking WHERE booking_id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $booking_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $booking = $result->fetch_assoc();
            $total_amount = $booking['total_price'];
            $step = 2;  // Move to the next step to process payment
        } else {
            echo "<script>alert('Invalid Booking ID or you are not authorized for this booking.');</script>";
        }
    } elseif (isset($_POST['proceed_payment'])) {
        // Handle the payment after Booking ID is verified
        $booking_id = $_POST['booking_id'];
        $total_amount = $_POST['total_amount'];
        $payment_method = $_POST['payment_method'];

        // Confirm the booking in the database (update status to 'Confirmed')
        $update_query = "UPDATE booking SET status = 'Confirmed' WHERE booking_id = ? AND user_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ii", $booking_id, $user_id);
        
        if ($stmt->execute()) {
            // Show a success message after booking is confirmed
            echo "<script>alert('Payment successful! Your booking has been confirmed.');</script>";
            $step = 3;  // Step 3: Show the success message
        } else {
            echo "<script>alert('Failed to confirm booking. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Confirm Booking</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');
        
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100vh;
        }

        header {
            background-color: #356698;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            color: #fff;
            font-size: 36px;
            letter-spacing: 2px;
            margin: 0;
        }

        header nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            background-color: #1abc9c;
            border-radius: 50px;
            transition: background-color 0.3s;
            font-weight: 600;
        }

        header nav ul li a:hover {
            background-color: #16a085;
        }

        .payment-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            margin: 40px auto;
            text-align: center;
        }

        .payment-container h1 {
            margin-bottom: 20px;
            color: #1abc9c;
            font-size: 28px;
        }

        .payment-container p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .payment-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .payment-container input[type="text"], 
        .payment-container input[type="number"],
        .payment-container select {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        .payment-container button {
            width: 100%;
            padding: 12px;
            background-color: #1abc9c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .payment-container button:hover {
            background-color: #16a085;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #57a3ba;
            color: white;
            font-size: 16px;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <header>
        <h1>TravelQuest - Payment</h1>
        <nav>
            <ul>
                <li><a href="./user_dashboard.php">Home</a></li>
                <li><a href="./accomdation.php">Accommodations</a></li>
                <li><a href="./transport.php">Transport</a></li>
                <li><a href="./review&enquiry.php">Reviews and Enquiry</a></li>
                <li><a href="#bookings">Bookings</a></li>
                <li><a href="./weather.php">Weather</a></li>
            </ul>
        </nav>
    </header>

    <div class="payment-container">
        <?php if ($step == 1): ?>
            <h1>Enter Booking ID</h1>
            <form action="payment.php" method="POST">
                <input type="text" name="booking_id" placeholder="Enter Booking ID" required>
                <button type="submit">Submit</button>
            </form>
        <?php elseif ($step == 2): ?>
            <h1>Confirm Your Payment</h1>
            <p>Please confirm the payment of BDT <?php echo $total_amount; ?> for your booking.</p>
            <form action="payment.php" method="POST">
                <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
                <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
                <label for="payment_method">Choose Payment Method:</label>
                <select name="payment_method" required>
                    <option value="Bkash">Bkash</option>
                    <option value="Nogod">Nogod</option>
                    <option value="AmarPay">AmarPay</option>
                </select>
                <button type="submit" name="proceed_payment">Proceed to Payment</button>
            </form>
        <?php elseif ($step == 3): ?>
            <h1>Payment Successful!</h1>
            <p>Your booking has been confirmed. Thank you for your payment.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2024 Tourism Management System</p>
    </footer>

</body>
</html>
