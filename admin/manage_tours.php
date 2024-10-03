<?php

session_start();
include 'config.php';

// Redirect if not logged in or not an admin
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle search query
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch tours to display
$query = "SELECT * FROM tour WHERE name LIKE ? ORDER BY tour_id DESC";
$stmt = $conn->prepare($query);
$search_param = "%{$search}%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$tours = $stmt->get_result();

// Handle creating or updating tours
$edit_data = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $description = $_POST['description'];
    $availability = isset($_POST['availability']) ? 1 : 0;

    if (isset($_POST['create'])) {
        // Create a new tour
        $create_query = "INSERT INTO tour (name, location, price, duration, description, availability) VALUES (?, ?, ?, ?, ?, ?)";
        $create_stmt = $conn->prepare($create_query);
        $create_stmt->bind_param("ssdsis", $name, $location, $price, $duration, $description, $availability);
        $create_stmt->execute();
        header("Location: manage_tours.php");
        exit();
    } elseif (isset($_POST['update'])) {
        // Update an existing tour
        $tour_id = $_POST['tour_id'];
        $update_query = "UPDATE tour SET name = ?, location = ?, price = ?, duration = ?, description = ?, availability = ? WHERE tour_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ssdsisi", $name, $location, $price, $duration, $description, $availability, $tour_id);
        $update_stmt->execute();
        header("Location: manage_tours.php");
        exit();
    }
}

// Handle tour deletion
if (isset($_GET['delete'])) {
    $tour_id = $_GET['delete'];
    $delete_query = "DELETE FROM tour WHERE tour_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $tour_id);
    $delete_stmt->execute();
    header("Location: manage_tours.php");
    exit();
}

// Fetch tour data for editing
if (isset($_GET['edit'])) {
    $tour_id = $_GET['edit'];
    $edit_query = "SELECT * FROM tour WHERE tour_id = ?";
    $edit_stmt = $conn->prepare($edit_query);
    $edit_stmt->bind_param("i", $tour_id);
    $edit_stmt->execute();
    $edit_data = $edit_stmt->get_result()->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tours - Admin Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');
        
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #5096dd;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            color: #fff;
            font-size: 36px;
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

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar input {
            padding: 10px;
            font-size: 16px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 6px;
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
            color: white;
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

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .btn {
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <header>
        <h1>Admin Dashboard - Manage Tours</h1>
        <nav>
            <ul>
                <li><a href="./admin.php">Dashboard</a></li>
                <li><a href="./manage_tours.php">Manage Tours</a></li>
                <li><a href="./manage_transport.php">Manage Transport</a></li>
                <li><a href="./manage_bookings.php">Manage Bookings</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <!-- Search Bar -->
        <div class="search-bar">
            <form method="GET" action="manage_tours.php">
                <input type="text" name="search" placeholder="Search tours..." value="<?php echo htmlspecialchars($search); ?>">
            </form>
        </div>

        <!-- Tour List Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Availability</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($tour = $tours->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $tour['tour_id']; ?></td>
                        <td><?php echo htmlspecialchars($tour['name']); ?></td>
                        <td><?php echo htmlspecialchars($tour['location']); ?></td>
                        <td>$<?php echo htmlspecialchars($tour['price']); ?></td>
                        <td><?php echo htmlspecialchars($tour['duration']); ?></td>
                        <td><?php echo $tour['availability'] ? 'Available' : 'Not Available'; ?></td>
                        <td class="action-buttons">
                            <a href="manage_tours.php?edit=<?php echo $tour['tour_id']; ?>" class="edit">Edit</a>
                            <a href="manage_tours.php?delete=<?php echo $tour['tour_id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this tour?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Tour Form (Create/Update) -->
        <div class="form-container">
            <h2><?php echo $edit_data ? 'Update Tour' : 'Create New Tour'; ?></h2>
            <form action="manage_tours.php" method="POST">
                <?php if ($edit_data): ?>
                    <input type="hidden" name="tour_id" value="<?php echo $edit_data['tour_id']; ?>">
                <?php endif; ?>
                <div class="form-group">
                    <label for="name">Tour Name:</label>
                    <input type="text" name="name" value="<?php echo $edit_data ? htmlspecialchars($edit_data['name']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" name="location" value="<?php echo $edit_data ? htmlspecialchars($edit_data['location']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="price">Price ($):</label>
                    <input type="number" step="0.01" name="price" value="<?php echo $edit_data ? htmlspecialchars($edit_data['price']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="duration">Duration:</label>
                    <input type="text" name="duration" value="<?php echo $edit_data ? htmlspecialchars($edit_data['duration']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" required><?php echo $edit_data ? htmlspecialchars($edit_data['description']) : ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="availability">
                        <input type="checkbox" name="availability" <?php echo ($edit_data && $edit_data['availability']) ? 'checked' : ''; ?>> Available
                    </label>
                </div>

                <button type="submit" name="<?php echo $edit_data ? 'update' : 'create'; ?>" class="btn">
                    <?php echo $edit_data ? 'Update' : 'Create'; ?>
                </button>
            </form>
        </div>
    </div>

</body>
</html>
