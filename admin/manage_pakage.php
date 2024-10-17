<?php
include 'config.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $accommodation_id = $_POST['accommodation_id'];
    $tour_id = $_POST['tour_id'];
    $transport_id = $_POST['transport_id'];
    $price = $_POST['price'];
    $description = $_POST['description'];

   
    $query = "INSERT INTO package (name, accommodation_id, tour_id, transport_id, price, description) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("siiids", $name, $accommodation_id, $tour_id, $transport_id, $price, $description);

    if ($stmt->execute()) {
        echo "<script>alert('Package added successfully.'); window.location.href='manage_packages.php';</script>";
    } else {
        echo "Error adding package: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Packages - Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
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

        /* Header Styles */
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

        /* Container Styles */
        .container {
            max-width: 1200px;
            margin: 160px auto 40px auto; /* Adjust for fixed header */
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

        .add-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1abc9c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
            font-weight: 600;
        }

        .add-btn:hover {
            background-color: #16a085;
        }

        .add-form {
            display: none; /* Initially hidden */
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .add-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .add-form input, .add-form select, .add-form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .add-form button {
            background-color: #1abc9c;
            border: none;
            padding: 10px 15px;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }

        .add-form button:hover {
            background-color: #16a085;
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

        /* Footer Styles */
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

        /* Make the layout responsive */
        @media (max-width: 768px) {
            header nav ul {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Manage Packages - Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="./admin.php">Dashboard</a></li>
                <li><a href="./manage_users.php">Manage Users</a></li>
                <li><a href="./manage_packages.php">Manage Packages</a></li>
                <li><a href="./manage_tours.php">Manage Tours</a></li>
                <li><a href="./manage_transport.php">Manage Transport</a></li>
                <li><a href="./manage_bookings.php">Manage Bookings</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="section">
            <h2>All Packages</h2>
            <a href="#" class="add-btn" onclick="toggleAddForm()">Add New Package</a>

            <!-- Add Package Form -->
            <div class="add-form" id="addForm">
                <h3>Add New Package</h3>
                <form method="POST" action="">
                    <label for="name">Package Name:</label>
                    <input type="text" name="name" id="name" required>

                    <label for="accommodation_id">Accommodation ID:</label>
                    <input type="number" name="accommodation_id" id="accommodation_id" required>

                    <label for="tour_id">Tour ID:</label>
                    <input type="number" name="tour_id" id="tour_id" required>

                    <label for="transport_id">Transport ID:</label>
                    <input type="number" name="transport_id" id="transport_id" required>

                    <label for="price">Price:</label>
                    <input type="number" name="price" id="price" step="0.01" required>

                    <label for="description">Description:</label>
                    <textarea name="description" id="description" rows="3"></textarea>

                    <button type="submit">Add Package</button>
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Accommodation ID</th>
                        <th>Tour ID</th>
                        <th>Transport ID</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM package";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['package_id'] . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['accommodation_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tour_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['transport_id']) . "</td>";
                            echo "<td>$" . htmlspecialchars($row['price']) . "</td>";
                            echo "<td class='action-buttons'>";
                            echo "<a href='edit_package.php?id=" . $row['package_id'] . "' class='edit'>Edit</a>";
                            echo "<a href='delete_package.php?id=" . $row['package_id'] . "' class='delete' onclick=\"return confirm('Are you sure you want to delete this package?');\">Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No packages found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Tourism Management System</p>
    </footer>

    <script>
        function toggleAddForm() {
            const form = document.getElementById('addForm');
            form.style.display = form.style.display === 'none' || form.style.display === '' ? 'block' : 'none';
        }
    </script>
</body>
</html>
