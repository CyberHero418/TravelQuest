<?php
include 'config.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
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

        
        .signup-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            margin: 40px auto;
            text-align: center;
        }

        .signup-container h1 {
            margin-bottom: 20px;
            color: #1abc9c;
            font-size: 24px;
        }

        .signup-container input[type="text"], 
        .signup-container input[type="email"], 
        .signup-container input[type="password"] {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        .signup-container input[type="text"]:hover, 
        .signup-container input[type="email"]:hover, 
        .signup-container input[type="password"]:hover, 
        .signup-container input[type="text"]:focus, 
        .signup-container input[type="email"]:focus, 
        .signup-container input[type="password"]:focus {
            border-color: #1abc9c;
            outline: none;
        }

        .signup-container button {
            width: 100%;
            padding: 12px;
            background-color: #1abc9c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .signup-container button:hover {
            background-color: #16a085;
        }

        .signup-container .links {
            margin-top: 15px;
        }

        .signup-container .links a {
            color: #1abc9c;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .signup-container .links a:hover {
            text-decoration: underline;
            color: #16a085;
        }

       
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

    
    <div class="signup-container">
        <h1>Sign Up</h1>
        <form>
            <input type="text" placeholder="Username" required><br>
            <input type="email" placeholder="Email" required><br>
            <input type="password" placeholder="Password" required><br>
            <button type="submit">Sign Up</button>
        </form>
        <div class="links">
            <a href="#">Already have an account? Log In</a>
        </div>
    </div>

    
    <footer>
        <p>&copy; 2024 Tourism Management System</p>
    </footer>

</body>
</html>
