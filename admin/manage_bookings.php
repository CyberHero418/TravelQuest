<?php
include 'config.php';


$users = $conn->query("SELECT user_id, name FROM user");
$accommodations = $conn->query("SELECT accommodation_id, name FROM accommodation");
$transports = $conn->query("SELECT transport_id, name FROM transport");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        
        $user_id = $_POST['user_id'];
        $accommodation_id = $_POST['accommodation_id'];
        $transport_id = $_POST['transport_id'];
        $booking_date = $_POST['booking_date'];
        $total_price = $_POST['total_price'];
        $status = $_POST['status'];

        $query = "INSERT INTO booking (user_id, accommodation_id, transport_id, booking_date, total_price, status) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiisds", $user_id, $accommodation_id, $transport_id, $booking_date, $total_price, $status);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        
        $id = $_POST['id'];
        $user_id = $_POST['user_id'];
        $accommodation_id = $_POST['accommodation_id'];
        $transport_id = $_POST['transport_id'];
        $booking_date = $_POST['booking_date'];
        $total_price = $_POST['total_price'];
        $status = $_POST['status'];

        $query = "UPDATE booking SET user_id = ?, accommodation_id = ?, transport_id = ?, booking_date = ?, total_price = ?, status = ? WHERE booking_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiisdsi", $user_id, $accommodation_id, $transport_id, $booking_date, $total_price, $status, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        
        $id = $_POST['id'];
        $query = "UPDATE booking SET status = 'Cancelled' WHERE booking_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}


$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}


$query = "SELECT booking.*, user.email FROM booking 
          JOIN user ON booking.user_id = user.user_id 
          WHERE user.email LIKE ? OR booking.status LIKE ? OR booking.booking_date LIKE ?";
$search_term = "%" . $search_query . "%";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $search_term, $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();


$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_query = "SELECT * FROM booking WHERE booking_id = ?";
    $stmt = $conn->prepare($edit_query);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $edit_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
       
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        
        header {
            background-color: #5096dd;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        header h1 {
            color: #fff;
            font-size: 28px;
            letter-spacing: 1px;
            margin: 0;
        }

        header nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 10px 0 0;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            background-color: #1abc9c;
            border-radius: 50px;
            transition: background-color 0.3s, transform 0.3s;
            font-weight: 600;
        }

        header nav ul li a:hover {
            background-color: #16a085;
            transform: translateY(-2px);
        }

        
        .container {
            max-width: 1200px;
            margin: 140px auto 40px auto; 
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            flex: 1;
        }

        .section {
            margin-bottom: 40px;
        }

        .section h2 {
            text-align: center;
            color: #34495e;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #5096dd;
            color: #fff;
        }

        .action-buttons a {
            text-decoration: none;
            padding: 5px 10px;
            margin-right: 5px;
            border-radius: 5px;
            color: white;
        }

        .edit {
            background-color: #28a745;
        }

        .delete {
            background-color: #dc3545;
        }

        
        footer {
            text-align: center;
            padding: 20px;
            background-color: #5096dd;
            color: white;
            font-size: 16px;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            position: fixed;
            bottom: 0;
        }

        
        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            padding: 10px;
            width: 300px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .search-container button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #218838;
        }

        
        @media (max-width: 768px) {
            header nav ul {
                flex-direction: column;
            }

            .action-buttons a {
                display: block;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>TravelQuest - Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="./admin.php">Dashboard</a></li>
                <li><a href="./manage_accommodations.php">Manage Accommodations</a></li>
                <li><a href="./manage_bookings.php">Manage Bookings</a></li>
                <li><a href="./manage_transport.php">Manage Transport</a></li>
                <li><a href="./amount_booking.php">Show amount and Booking</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        
        <div class="search-container">
            <form action="manage_bookings.php" method="GET">
                <input type="text" name="search" placeholder="Search by email, status, or booking date" value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <
        <div class="section">
            <h2>Create or Update Booking</h2>
            <form action="manage_bookings.php" method="POST">
                
                <input type="hidden" name="id" value="<?php echo $edit_data ? $edit_data['booking_id'] : ''; ?>">

                <div class="form-group">
                    <label for="user_id">User:</label>
                    <select name="user_id" required>
                        <?php while ($user = $users->fetch_assoc()): ?>
                            <option value="<?php echo $user['user_id']; ?>" 
                            <?php echo ($edit_data && $edit_data['user_id'] == $user['user_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($user['name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="accommodation_id">Accommodation:</label>
                    <select name="accommodation_id" required>
                        <?php while ($acc = $accommodations->fetch_assoc()): ?>
                            <option value="<?php echo $acc['accommodation_id']; ?>" 
                            <?php echo ($edit_data && $edit_data['accommodation_id'] == $acc['accommodation_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($acc['name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="transport_id">Transport:</label>
                    <select name="transport_id" required>
                        <?php while ($transport = $transports->fetch_assoc()): ?>
                            <option value="<?php echo $transport['transport_id']; ?>" 
                            <?php echo ($edit_data && $edit_data['transport_id'] == $transport['transport_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($transport['name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="booking_date">Booking Date:</label>
                    <input type="date" name="booking_date" value="<?php echo $edit_data ? $edit_data['booking_date'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="total_price">Total Price:</label>
                    <input type="number" step="0.01" name="total_price" value="<?php echo $edit_data ? $edit_data['total_price'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="status">Status:</label>
                    <select name="status" required>
                        <option value="Pending" <?php echo ($edit_data && $edit_data['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="Confirmed" <?php echo ($edit_data && $edit_data['status'] == 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                        <option value="Cancelled" <?php echo ($edit_data && $edit_data['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>

                
                <button type="submit" name="<?php echo $edit_data ? 'update' : 'create'; ?>">
                    <?php echo $edit_data ? 'Update' : 'Create'; ?>
                </button>
            </form>
        </div>

        
        <div class="section">
            <h2>All Bookings</h2>
            <table>
                <thead>
                    <tr>
                        <th>User Email</th>
                        <th>Booking Status</th>
                        <th>Total Price</th>
                        <th>Booking Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo '$' . htmlspecialchars($row['total_price']); ?></td>
                        <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                        <td class="action-buttons">
                            <a href="manage_bookings.php?edit=<?php echo $row['booking_id']; ?>" class="edit">Edit</a>
                            <form action="manage_bookings.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['booking_id']; ?>">
                                <button type="submit" name="delete" class="delete" onclick="return confirm('Are you sure you want to cancel this booking?');">Cancel</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 TravelQuest - All Rights Reserved</p>
    </footer>
</body>
</html>
