<?php

session_start();
include 'config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT transport_id, name, type, route, price, availability FROM transport WHERE availability = 1";
$result = $conn->query($sql);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $transport_id = $_POST['transport'];
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $travel_date = $_POST['date'];
    $passengers = $_POST['passengers'];

    
    $booking_sql = "INSERT INTO booking (user_id, transport_id, booking_date, total_price, status) VALUES (?, ?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($booking_sql);

    
    $price_sql = "SELECT price FROM transport WHERE transport_id = ?";
    $price_stmt = $conn->prepare($price_sql);
    $price_stmt->bind_param("i", $transport_id);
    $price_stmt->execute();
    $price_result = $price_stmt->get_result();
    $transport = $price_result->fetch_assoc();
    $total_price = $transport['price'] * $passengers;

    
    $stmt->bind_param("iisd", $user_id, $transport_id, $travel_date, $total_price);
    
    if ($stmt->execute()) {
        echo "<script>alert('Booking Successful!');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}


$bookings_sql = "SELECT b.booking_id, t.name AS transport_name, t.route, b.booking_date, b.total_price, b.status 
                 FROM booking b 
                 JOIN transport t ON b.transport_id = t.transport_id 
                 WHERE b.user_id = ?";
$bookings_stmt = $conn->prepare($bookings_sql);
$bookings_stmt->bind_param("i", $user_id);
$bookings_stmt->execute();
$user_bookings = $bookings_stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Booking</title>
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

        .booking-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            margin: 40px auto;
            text-align: center;
        }

        .booking-container h1 {
            margin-bottom: 20px;
            color: #1abc9c;
            font-size: 28px;
        }

        .booking-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .booking-container select, 
        .booking-container input[type="text"], 
        .booking-container input[type="date"], 
        .booking-container input[type="number"] {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        .booking-container input:hover,
        .booking-container select:hover,
        .booking-container input:focus,
        .booking-container select:focus {
            border-color: #1abc9c;
            outline: none;
        }

        .booking-container button {
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

        .booking-container button:hover {
            background-color: #16a085;
        }

        .user-bookings {
            margin: 40px auto;
            width: 80%;
        }

        .user-bookings table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .user-bookings th, .user-bookings td {
            padding: 12px;
            border: 1px solid #ccc;
        }

        .user-bookings th {
            background-color: #356698;
            color: white;
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
        <h1>TravelQuest</h1>
        <nav>
            <ul>
                <li><a href="./user_dashboard.php">Home</a></li>
                <li><a href="#accommodations">Accommodations</a></li>
                <li><a href="">Tours</a></li>
                <li><a href="./transport.php">Transport</a></li>
                <li><a href="#bookings">Bookings</a></li>
                <li><a href="./review&enquiry.php">Reviews and Enquiry</a></li>
                <li><a href="#payments">Payments</a></li>
            </ul>
        </nav>
    </header>

    <div class="booking-container">
        <h1>Book Your Transport</h1>
        <form action="transport.php" method="POST">
            
            <select name="transport" required>
                <option value="">Select Transport</option>
                <?php
            
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['transport_id'] . "'>" . $row['type'] . " - " . $row['name'] . " (Route: " . $row['route'] . ", Price: $" . $row['price'] . ")</option>";
                    }
                } else {
                    echo "<option value=''>No transport available</option>";
                }
                ?>
            </select>

            <input type="text" name="departure" placeholder="Departure Location" required>
            <input type="text" name="destination" placeholder="Destination Location" required>
            <input type="date" name="date" required>
            <input type="number" name="passengers" placeholder="Number of Passengers" min="1" max="10" required>

            <button type="submit">Book Now</button>
        </form>
    </div>

    
    <div class="user-bookings">
        <h2>Your Transport Bookings</h2>
        <table>
            <thead>
                <tr>
                    <th>Transport Name</th>
                    <th>Route</th>
                    <th>Booking Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                if ($user_bookings->num_rows > 0) {
                    while ($booking = $user_bookings->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($booking['transport_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($booking['route']) . "</td>";
                        echo "<td>" . htmlspecialchars($booking['booking_date']) . "</td>";
                        echo "<td>$" . htmlspecialchars($booking['total_price']) . "</td>";
                        echo "<td>" . htmlspecialchars($booking['status']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No bookings found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 Tourism Management System</p>
    </footer>

</body>
</html>
