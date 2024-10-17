<?php
include 'config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        
        $type = $_POST['type'];
        $name = $_POST['name'];
        $route = $_POST['route'];
        $price = $_POST['price'];
        $availability = $_POST['availability'];

        $query = "INSERT INTO transport (type, name, route, price, availability) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssdi", $type, $name, $route, $price, $availability);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        
        $id = $_POST['id'];
        $type = $_POST['type'];
        $name = $_POST['name'];
        $route = $_POST['route'];
        $price = $_POST['price'];
        $availability = $_POST['availability'];

        $query = "UPDATE transport SET type = ?, name = ?, route = ?, price = ?, availability = ? WHERE transport_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssdis", $type, $name, $route, $price, $availability, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['soft_delete'])) {
        
        $id = $_POST['id'];
        $query = "UPDATE transport SET availability = 0 WHERE transport_id = ?";
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


$query = "SELECT * FROM transport WHERE type LIKE ? OR name LIKE ? OR route LIKE ?";
$search_term = "%" . $search_query . "%";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $search_term, $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();


$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_query = "SELECT * FROM transport WHERE transport_id = ?";
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
    <title>Manage Transport - Admin</title>
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
            <form action="manage_transport.php" method="GET">
                <input type="text" name="search" placeholder="Search by type, name, or route" value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        
        <div class="section">
            <h2>Create or Update Transport</h2>
            <form action="manage_transport.php" method="POST">
                
                <input type="hidden" name="id" value="<?php echo $edit_data ? $edit_data['transport_id'] : ''; ?>">

                <div class="form-group">
                    <label for="type">Transport Type:</label>
                    <input type="text" name="type" value="<?php echo $edit_data ? $edit_data['type'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="name">Transport Name:</label>
                    <input type="text" name="name" value="<?php echo $edit_data ? $edit_data['name'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="route">Route:</label>
                    <input type="text" name="route" value="<?php echo $edit_data ? $edit_data['route'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" step="0.01" name="price" value="<?php echo $edit_data ? $edit_data['price'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="availability">Availability:</label>
                    <select name="availability" required>
                        <option value="1" <?php echo ($edit_data && $edit_data['availability'] == 1) ? 'selected' : ''; ?>>Available</option>
                        <option value="0" <?php echo ($edit_data && $edit_data['availability'] == 0) ? 'selected' : ''; ?>>Not Available</option>
                    </select>
                </div>

               
                <button type="submit" name="<?php echo $edit_data ? 'update' : 'create'; ?>">
                    <?php echo $edit_data ? 'Update' : 'Create'; ?>
                </button>
            </form>
        </div>

        
        <div class="section">
            <h2>All Transport Options</h2>
            <table>
                <thead>
                    <tr>
                        <th>Transport ID</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Route</th>
                        <th>Price</th>
                        <th>Availability</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['transport_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['route']); ?></td>
                        <td><?php echo '$' . htmlspecialchars($row['price']); ?></td>
                        <td><?php echo $row['availability'] ? 'Available' : 'Not Available'; ?></td>
                        <td class="action-buttons">
                            <a href="manage_transport.php?edit=<?php echo $row['transport_id']; ?>" class="edit">Edit</a>
                            <form action="manage_transport.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['transport_id']; ?>">
                                <button type="submit" name="soft_delete" class="delete" onclick="return confirm('Are you sure you want to mark this transport as unavailable?');">Soft Delete</button>
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
