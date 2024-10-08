<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tourism Management System</title>
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
                <li><a href="./manage_tours.php">Manage Tours</a></li>
                <li><a href="./manage_transport.php">Manage Transport</a></li>
                <li><a href="./manage_bookings.php">Manage Bookings</a></li>
                <li><a href="./manage_pakage.php">Manage Package</a></li>
               <li><a href="./message.php">Message </a></li>
               <li><a href="./logout.php">Logout</a></li>

            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="section">
            <h2>All Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'config.php';
                    $query = "SELECT * FROM user";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['user_id'] . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                            echo "<td class='action-buttons'>";
                            echo "<a href='edit_user.php?id=" . $row['user_id'] . "' class='edit'>Edit</a>";
                            echo "<a href='delete_user.php?id=" . $row['user_id'] . "' class='delete' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No users found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        

        <div class="section">
            <h2>All Accommodations</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Price</th>
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
                            echo "<td class='action-buttons'>";
                            echo "<a href='edit_accommodation.php?id=" . $row['accommodation_id'] . "' class='edit'>Edit</a>";
                            echo "<a href='delete_accommodation.php?id=" . $row['accommodation_id'] . "' class='delete' onclick=\"return confirm('Are you sure you want to delete this accommodation?');\">Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No accommodations found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Tourism Management System</p>
    </footer>
</body>
</html>
