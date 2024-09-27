<?php
include 'config.php'; // Include your database connection file

// Check if an accommodation ID is passed
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $accommodation_id = $_GET['id'];

    // Fetch accommodation details
    $query = "SELECT * FROM accommodation WHERE accommodation_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $accommodation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $accommodation = $result->fetch_assoc();

    if (!$accommodation) {
        echo "Accommodation not found.";
        exit();
    }

    // Update accommodation details
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $type = $_POST['type'];
        $location = $_POST['location'];
        $price = $_POST['price'];
        $availability = isset($_POST['availability']) ? 1 : 0;
        $description = $_POST['description'];

        // Update query
        $updateQuery = "UPDATE accommodation SET name = ?, type = ?, location = ?, price = ?, availability = ?, description = ? WHERE accommodation_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssdisi", $name, $type, $location, $price, $availability, $description, $accommodation_id);

        if ($stmt->execute()) {
            echo "<script>alert('Accommodation updated successfully.'); window.location.href='manage_accommodations.php';</script>";
        } else {
            echo "Error updating accommodation: " . $conn->error;
        }
    }
} else {
    echo "Invalid accommodation ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Accommodation</title>
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
            max-width: 600px;
            margin: 160px auto 40px auto; /* Adjust for fixed header */
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .edit-form h2 {
            text-align: center;
            color: #34495e;
            margin-bottom: 20px;
        }

        .edit-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .edit-form input, .edit-form select, .edit-form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .edit-form button {
            width: 100%;
            padding: 10px;
            background-color: #1abc9c;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            font-weight: 600;
        }

        .edit-form button:hover {
            background-color: #16a085;
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
    </style>
</head>
<body>
    <header>
        <h1>Edit Accommodation - Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="./admin.php">Dashboard</a></li>
                <li><a href="./manage_accommodations.php">Manage Accommodations</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="edit-form">
            <h2>Edit Accommodation</h2>
            <form method="POST">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($accommodation['name']); ?>" required>

                <label for="type">Type:</label>
                <input type="text" name="type" id="type" value="<?php echo htmlspecialchars($accommodation['type']); ?>" required>

                <label for="location">Location:</label>
                <input type="text" name="location" id="location" value="<?php echo htmlspecialchars($accommodation['location']); ?>" required>

                <label for="price">Price (per night):</label>
                <input type="number" name="price" id="price" step="0.01" value="<?php echo htmlspecialchars($accommodation['price']); ?>" required>

                <label for="availability">Available:</label>
                <input type="checkbox" name="availability" id="availability" <?php echo $accommodation['availability'] ? 'checked' : ''; ?>>

                <label for="description">Description:</label>
                <textarea name="description" id="description" rows="3"><?php echo htmlspecialchars($accommodation['description']); ?></textarea>

                <button type="submit">Update Accommodation</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Tourism Management System</p>
    </footer>
</body>
</html>
