
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
       
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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

        
        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            margin: 30px auto;
            text-align: center;
        }

        .login-container h1 {
            margin-bottom: 20px;
            color: #1abc9c;
            font-size: 24px;
        }

        .login-container input[type="text"], 
        .login-container input[type="password"] {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        .login-container input[type="text"]:hover, 
        .login-container input[type="password"]:hover,
        .login-container input[type="text"]:focus, 
        .login-container input[type="password"]:focus {
            border-color: #1abc9c;
            outline: none;
        }

        .login-container button {
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

        .login-container button:hover {
            background-color: #16a085;
        }

        .login-container .links {
            margin-top: 15px;
        }

        .login-container .links a {
            color: #1abc9c;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-container .links a:hover {
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

        @media (max-width: 400px) {
            .login-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

   
    <header>
        <h1>TravelQuest</h1>

    </header>

    
    <div class="login-container">
        <h1>Login</h1>
<form method="POST" action="./user_login.php">
    <input type="text" name="name" placeholder="name" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Log In</button>
</form>

        <div class="links">
            <a href="#">Forgot Password?</a> | <a href="../signup/signup.php">Sign Up</a>
        </div>
    </div>

    
    <footer>
        <p>&copy; 2024 Tourism Management System</p>


        <li><a href="../../admin/admin_login.php">Admin</a></li>

    </footer>

</body>
</html>
