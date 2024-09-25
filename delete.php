<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
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

        /* Header Styles */
        header {
            background-color: #356698;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            transition: background-color 0.3s;
            font-weight: 600;
        }

        header nav ul li a:hover {
            background-color: #16a085;
        }

        /* Delete Account Container */
        .delete-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
            margin: 40px auto;
        }

        .delete-container h1 {
            margin-bottom: 20px;
            color: #e74c3c;
            font-size: 24px;
        }

        .delete-container p {
            margin-bottom: 20px;
            color: #333;
        }

        .delete-container button {
            width: 100%;
            padding: 12px;
            background-color: #165ecb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .delete-container button:hover {
            background-color: #ff0000;
        }

        .delete-container .links {
            margin-top: 10px;
        }

        .delete-container .links a {
            color: #e74c3c;
            text-decoration: none;
        }

        .delete-container .links a:hover {
            text-decoration: underline;
        }

        /* Footer Styles */
        footer {
            text-align: center;
            padding: 20px;
            background-color: #57a3ba;
            color: white;
            font-size: 16px;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
        }

    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <h1>TravelQuest</h1>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#accommodations">Accommodations</a></li>
                <li><a href="#tours">Tours</a></li>
                <li><a href="#transport">Transport</a></li>
                <li><a href="#bookings">Bookings</a></li>
                <li><a href="#reviews&Enquiry">Reviews and Enquiry</a></li>
                <li><a href="#payments">Payments</a></li>
                <li><a href="#admin">Admin</a></li>
            </ul>
        </nav>
    </header>

    <!-- Delete Account Section -->
    <div class="delete-container">
        <h1>Delete Account</h1>
        <p>Are you sure you want to delete your account? This action cannot be undone.</p>
        <button type="button" onclick="confirmDelete()">Delete My Account</button>
        <div class="links">
            <a href="#">Cancel</a>
        </div>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Tourism Management System</p>
    </footer>

    <script>
        function confirmDelete() {
            alert("Your account has been deleted.");
        }
    </script>

</body>
</html>
