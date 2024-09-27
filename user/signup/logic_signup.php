<?php
include './config.php'; // Make sure this path is correct
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name']; 
    $email = $_POST['email'];
    $role='customer';
    $password = trim($_POST['password']);
    
    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
            // Prepared statement to insert new user
            $insertQuery = "INSERT INTO user (name, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssss", $name, $email, $password,$role);
            if ($stmt->execute()) {
                $success = "Registration successful! You can now log in.";
                $user_id = $stmt->insert_id; // Get the last inserted id
                header("Location: http://localhost/TravelQuest/user/user_dashboard.php?user_id=" . $row['user_id']);
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }
            $stmt->close();
        
    }
    $conn->close();
}
?>
