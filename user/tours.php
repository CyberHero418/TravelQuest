<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tours - Tourism Management System</title>
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

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-evenly;
        }

        .card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
            width: 100%;
            max-width: 320px;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .card h3 {
            font-size: 20px;
            margin: 10px 0;
            color: #34495e;
        }

        .card p {
            color: #7f8c8d;
            line-height: 1.5;
            margin: 5px 0;
            font-size: 14px;
        }

        .price {
            color: #16a085;
            font-weight: bold;
            font-size: 16px;
        }

        .availability {
            margin-top: 10px;
            padding: 5px 10px;
            border-radius: 20px;
            background-color: #1abc9c;
            color: white;
            font-weight: 600;
            display: inline-block;
            font-size: 14px;
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
            .card-container {
                flex-direction: column;
                align-items: center;
            }

            header nav ul {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>TravelQuest - Tours</h1>
        <nav>
            <ul>
                <li><a href="./user_dashboard.php">Home</a></li>
                <li><a href="./transport.php">Transport</a></li>
                <li><a href="./book_status.php">Bookings</a></li>
                <li><a href="./review&enquiry.php">Reviews and Enquiry</a></li>
                <li><a href="./payment.php">Payments</a></li>
                <li><a href="./weather.php">Weather</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Available Tours</h2>
        <div class="card-container">
            <?php
            include 'config.php'; 
            $query = "SELECT * FROM tour WHERE availability = 1"; 
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card'>";
                    echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                    echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
                    echo "<p><strong>Duration:</strong> " . htmlspecialchars($row['duration']) . "</p>";
                    echo "<p><strong>Price:</strong> $" . htmlspecialchars($row['price']) . "</p>";
                    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No tours are available at the moment.</p>";
            }
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Tourism Management System</p>
    </footer>
</body>
</html>
