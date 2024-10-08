<?php
include './config.php'; 
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
            
            $insertQuery = "INSERT INTO user (name, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssss", $name, $email, $password,$role);
            if ($stmt->execute()) {
                $success = "Registration successful! You can now log in.";
                $user_id = $stmt->insert_id;
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
