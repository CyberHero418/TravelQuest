<?php
session_start();
include 'config.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


function getPackageByName($conn, $packageName) {
    $stmt = $conn->prepare("SELECT * FROM package WHERE name = ?");
    $stmt->bind_param("s", $packageName);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_booking'])) {
    $package_name = $_POST['package_name'];
    $booking_date = $_POST['booking_date'];
    $status = $_POST['status'];

   
    $packageData = getPackageByName($conn, $package_name);

    if ($packageData) {
        $accommodation_id = $packageData['accommodation_id'];
        $tour_id = $packageData['tour_id'];
        $transport_id = $packageData['transport_id'];
        $total_price = $packageData['price'];

        
        $stmt = $conn->prepare("INSERT INTO booking (user_id, accommodation_id, tour_id, transport_id, booking_date, total_price, status) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiissds", $user_id, $accommodation_id, $tour_id, $transport_id, $booking_date, $total_price, $status);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Booking successfully added!');</script>";
        } else {
            echo "<script>alert('Error adding booking: " . $conn->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Package not found. Please check the package name and try again.');</script>";
    }
}


$result = $conn->query("SELECT booking_id, accommodation_id, tour_id, transport_id, booking_date, total_price, status 
                        FROM booking WHERE user_id = $user_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Status and Add Booking</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:wght@400;600" rel="stylesheet">
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

        header, footer {
            background-color: #356698;
            padding: 20px;
            text-align: center;
            color: #fff;
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

        .container {
            padding: 40px;
            margin: 40px auto;
            width: 80%;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #5096dd;
        }

        input, select, button {
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: calc(100% - 24px);
        }

        button {
            background-color: #1abc9c;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #16a085;
        }
    </style>
</head>
<body>
    <header>
        <h1>TravelQuest Bookings</h1>
        <nav>
            <ul>
                <li><a href="./user_dashboard.php">Home</a></li>
                <li><a href="./book_status.php">Booking Status</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Add New Booking</h2>
        <form method="post">
            <input type="text" name="package_name" placeholder="Package Name" required>
            <input type="date" name="booking_date" placeholder="Booking Date" required>
            <select name="status">
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <button type="submit" name="add_booking">Add Booking</button>
        </form>
    </div>

    <div class="container">
        <h2>Your Booking Status</h2>
        <table>
            <tr>
                <th>Booking ID</th>
                <th>Accommodation ID</th>
                <th>Tour ID</th>
                <th>Transport ID</th>
                <th>Booking Date</th>
                <th>Total Price</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['booking_id']) ?></td>
                <td><?= htmlspecialchars($row['accommodation_id']) ?></td>
                <td><?= htmlspecialchars($row['tour_id']) ?></td>
                <td><?= htmlspecialchars($row['transport_id']) ?></td>
                <td><?= htmlspecialchars($row['booking_date']) ?></td>
                <td><?= htmlspecialchars($row['total_price']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 TravelQuest</p>
    </footer>
</body>
</html>
