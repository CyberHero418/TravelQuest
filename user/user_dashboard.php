<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourism Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            overflow-x: hidden;
        }
        header {
            background-color: #5096dd;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
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
            transition: background-color 0.3s, transform 0.3s;
            font-weight: 600;
        }
        header nav ul li a:hover {
            background-color: #16a085;
            transform: translateY(-2px);
        }
        .profile-menu {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
        .profile-dropdown {
            display: none;
            position: absolute;
            background-color: #5096dd;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            right: 0;
            text-align: left;
            width: 150px;
        }
        .profile-dropdown a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
        }
        .profile-dropdown a:hover {
            background-color: #16a085;
        }
        .hero-section {
            background-image: url('pexels-pixabay-38238.jpg');
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
            margin-top: 60px;
        }
        .hero-section h1 {
            font-size: 50px;
            font-weight: 600;
            margin: 0;
            letter-spacing: 1.5px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.4);
        }
        .hero-section p {
            font-size: 20px;
            margin: 20px 0 0;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #5096dd;
            color: white;
            font-size: 16px;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>TravelQuest</h1>
        <div class="profile-menu">
            <img src="profile-pic.jpg" alt="Profile" class="profile-pic" onclick="toggleDropdown()">
            <div class="profile-dropdown">
                <a href="./profile.php">My Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <nav>
            <ul>
                <li><a href="./user_dashboard.php">Home</a></li>
                <li><a href="./accomdation.php">Accommodations</a></li>
                <li><a href="./tours.php">Tours</a></li>
                <li><a href="./transport.php">Transport</a></li>
                <li><a href="./book_status.php">Bookings</a></li>
                <li><a href="./review&enquiry.php">Reviews and Enquiry</a></li>
                <li><a href="./payment.php">Payments</a></li>
                <li><a href="./weather.php">Weather</a></li>
            </ul>
        </nav>
    </header>
    <div class="hero-section">
        <div>
            <h1>Welcome to TravelQuest</h1>
            <p>Explore the world with us</p>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Tourism Management System</p>
    </footer>
    <script>
       function toggleDropdown() {
            var dropdown = document.querySelector('.profile-dropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</body>
</html>
