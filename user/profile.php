<?php
session_start();
include 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT * FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $imageData = NULL;

    // Check if a file has been uploaded without errors
    if (isset($_FILES['user_pic']) && $_FILES['user_pic']['error'] == UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['user_pic']['tmp_name'];
        $imageData = file_get_contents($imageTmpPath);  // Convert image to binary data

        // Update query to include image data
        $sql = "UPDATE user SET email = ?, name = ?, user_pic = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $null = NULL; // This is required to bind the blob type
        $stmt->bind_param("ssbi", $email, $name, $null, $user_id);
        $stmt->send_long_data(2, $imageData); // Sending the binary data

        if ($stmt->execute()) {
            echo "<script>alert('Profile updated successfully.');</script>";
        } else {
            echo "Error updating record: " . $stmt->error;
        }
    } else {
        // Update without changing the image
        $sql = "UPDATE user SET email = ?, name = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $email, $name, $user_id);

        if ($stmt->execute()) {
            echo "<script>alert('Profile updated successfully without image update.');</script>";
        } else {
            echo "Error updating record: " . $stmt->error;
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Tourism Management System</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #5096dd;
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

        .container {
            width: 85%;
            margin: 30px auto;
        }

        .profile-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-user_pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
        }

        .form-group {
            max-width: 400px;
            margin: 0 auto 15px auto;
        }

        input[type="email"], input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            border-radius: 6px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            margin-top: 15px;
        }

        .btn:hover {
            background-color: #218838;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #5096dd;
            color: white;
            font-size: 16px;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <!-- Header from Homepage -->
    <header>
        <h1>TravelQuest</h1>
        <nav>
            <ul>
                <li><a href="./user_dashboard.php">Home</a></li>
                <li><a href="./">Accommodations</a></li>
                <li><a href="">Tours</a></li>
                <li><a href="./transport.php">Transport</a></li>
                <li><a href="#bookings">Bookings</a></li>
                <li><a href="./review&enquiry.php">Reviews and Enquiry</a></li>
                <li><a href="#payments">Payments</a></li>
                <li><a href="./weather.php">Weather</a></li>
            </ul>
        </nav>
    </header>

    <!-- Profile Section -->
    <div class="container">
    <div class="profile-section">
    <?php if (isset($user['user_id'])): ?>
        <img src="./getImage.php?php echo htmlspecialchars($user['user_id']); ?>" alt="Profile Picture" class="profile-user_pic">
    <?php else: ?>
        <img src="path/to/default/image.jpg" alt="Default Profile Picture" class="profile-user_pic">
    <?php endif; ?>
</div>



        <form action="profile.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="user_pic">Profile user_pic:</label>
                <input type="file" id="user_pic" name="user_pic" accept="user_pic/*">
            </div>
            <div style="text-align: center;">
                <button type="submit" name="update" class="btn update-btn"><i class="fas fa-user-edit"></i> Update Profile</button>
            </div>
        </form>
    </div>

    <!-- Footer from Homepage -->
    <footer>
        <p>&copy; 2024 Tourism Management System</p>
    </footer>

</body>
