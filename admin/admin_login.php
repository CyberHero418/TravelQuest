<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Tourism Management System</title>
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
            width: 100%;
            top: 0;
            position: fixed;
            z-index: 1000;
        }

        header h1 {
            color: #fff;
            font-size: 28px;
            letter-spacing: 1px;
            margin: 0;
        }

        /* Login Container */
        .login-container {
            max-width: 400px;
            margin: 140px auto; /* Adjust for fixed header */
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-container h2 {
            color: #34495e;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #1abc9c;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #16a085;
        }

        .error {
            color: #dc3545;
            margin-top: 10px;
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
        <h1>TravelQuest - Admin Login</h1>
    </header>

    <div class="login-container">
        <h2>Admin Login</h2>
        <?php
        session_start();
        include 'config.php'; // Ensure this file has the database connection settings

        if (isset($_POST['login'])) {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Check if email and password match an admin user in the database
            $query = "SELECT * FROM user WHERE email = ? AND password = ? AND role = 'admin'";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $email, $password); // Assuming password is stored in plain text (not recommended, consider using hashed passwords)
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Valid admin credentials
                $_SESSION['admin_logged_in'] = true;
                header("Location: http://localhost/TravelQuest/admin/admin.php?admin_id=" . $row['user_id']);
                exit();
            } else {
                echo "<p class='error'>Invalid email or password.</p>";
            }
        }
        ?>

        <form action="admin_login.php" method="POST">
            <input type="text" name="email" placeholder="Enter your email" required><br>
            <input type="password" name="password" placeholder="Enter your password" required><br>
            <button type="submit" name="login" class="btn">Login</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Tourism Management System</p>
    </footer>
</body>
</html>
