
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'config.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header("Location:../user_login.php");
    exit();
}


$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT * FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // Handle the case where the user is not found
    echo "<script>alert('User not found.');</script>";
    $user = null;
}

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
    <title>User Profile - TravelQuest</title>
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
            min-height: 100vh;
            justify-content: center; 
            align-items: center; 
        }

    
        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            color: #5096dd;
            font-size: 36px;
            font-weight: 600;
            letter-spacing: 2px;
        }

        
        .back-btn {
            text-decoration: none;
            color: #fff;
            background-color: #5096dd;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #4079bb;
        }

        
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 500px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-picture-container {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ccc;
            margin-bottom: 20px;
        }

        .profile-picture-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .form-group {
            width: 100%;
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
            display: block;
        }

        input[type="email"], input[type="text"], input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
            background-color: #fff;
            transition: border-color 0.3s;
        }

        input[type="email"]:focus, input[type="text"]:focus, input[type="file"]:focus {
            border-color: #5096dd;
            outline: none;
        }

        .btn {
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            border-radius: 6px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-top: 15px;
            display: inline-block;
        }

        .btn:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

    </style>
</head>
<body>

    
    <header>
        <h1>TravelQuest</h1>
    </header>

    
    <a href="javascript:history.back()" class="back-btn">Go Back</a>

    <div class="profile-picture-container" style="float: justify-center;">
    <?php if ($user): ?>
        <img id="profilePic" src="data:image/jpeg;base64,<?php echo base64_encode($user['user_pic']); ?>" alt="Profile Picture">
    <?php else: ?>
        <img id="profilePic" src="default-profile.png" alt="Default Profile Picture">
    <?php endif; ?>
</div>

<form action="profile.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user ? htmlspecialchars($user['email']) : ''; ?>" required>
    </div>
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $user ? htmlspecialchars($user['name']) : ''; ?>" required>
    </div>
    <div class="form-group">
        <label for="user_pic">Profile Picture:</label>
        <input type="file" id="user_pic" name="user_pic" accept="image/*">
    </div>
    <div style="text-align: center;">
        <button type="submit" name="update" class="btn update-btn"><i class="fas fa-user-edit"></i> Update Profile</button>
    </div>
</form>


<script>
    window.onload = function() {
        var img = document.getElementById('profilePic');
        img.onload = function() {
            if (img.naturalWidth > img.naturalHeight) {
                img.style.height = '100%';
                img.style.width = 'auto';
            } else {
                img.style.width = '100%';
                img.style.height = 'auto';
            }
            img.style.objectFit = 'cover';
        };
    };
</script>

</body>
</html>
