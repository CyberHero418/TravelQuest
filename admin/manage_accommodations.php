<?php
include 'config.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $availability = isset($_POST['availability']) ? 1 : 0;
    $description = $_POST['description'];

    
    $query = "INSERT INTO accommodation (name, type, location, price, availability, description) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssdss", $name, $type, $location, $price, $availability, $description);

    if ($stmt->execute()) {
        echo "<script>alert('Accommodation added successfully.'); window.location.href='manage_accommodations.php';</script>";
    } else {
        echo "Error adding accommodation: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Accommodations - Admin Dashboard</title>
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
            margin: 160px auto 40px auto; 
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
            display: none; 
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

        
        @media (max-width: 768px) {
            header nav ul {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Manage Accommodations - Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="./admin.php">Dashboard</a></li>
                <li><a href="./manage_users.php">Manage Users</a></li>
                <li><a href="./manage_accommodations.php">Manage Accommodations</a></li>
                <li><a href="./manage_tours.php">Manage Tours</a></li>
                <li><a href="./manage_transport.php">Manage Transport</a></li>
                <li><a href="./manage_bookings.php">Manage Bookings</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="section">
            <h2>All Accommodations</h2>
            <a href="#" class="add-btn" onclick="toggleAddForm()">Add New Accommodation</a>

            
            <div class="add-form" id="addForm">
                <h3>Add New Accommodation</h3>
                <form method="POST" action="">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" required>

                    <label for="type">Type:</label>
                    <input type="text" name="type" id="type" required>

                    <label for="location">Location:</label>
                    <input type="text" name="location" id="location" required>

                    <label for="price">Price (per night):</label>
                    <input type="number" name="price" id="price" step="0.01" required>

                    <label for="availability">Available:</label>
                    <input type="checkbox" name="availability" id="availability" value="1">

                    <label for="description">Description:</label>
                    <textarea name="description" id="description" rows="3"></textarea>

                    <button type="submit">Add Accommodation</button>
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Availability</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM accommodation";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['accommodation_id'] . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                            echo "<td>$" . htmlspecialchars($row['price']) . "</td>";
                            echo "<td>" . ($row['availability'] == 1 ? 'Available' : 'Unavailable') . "</td>";
                            echo "<td class='action-buttons'>";
                            echo "<a href='edit_accommodation.php?id=" . $row['accommodation_id'] . "' class='edit'>Edit</a>";
                            echo "<a href='delete_accommodation.php?id=" . $row['accommodation_id'] . "' class='delete' onclick=\"return confirm('Are you sure you want to delete this accommodation?');\">Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No accommodations found.</td></tr>";
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
