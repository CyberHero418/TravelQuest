<?php

include './config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$errorMessages = []; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Remove mysqli_real_escape_string as we use prepared statements
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($password)) {
        $errorMessages[] = "Name and Password are required.";
    } else {
        $sql = "SELECT user_id FROM user WHERE name = ? AND password =?"; 
        $stmt = $conn->prepare($sql);
        session_start();
        $_SESSION["user_id"] = $user_id;
        if ($stmt) {
            $stmt->bind_param("ss", $name,$password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $_SESSION['loggedin'] = true;
                $user_id = $row['user_id'];
                $_SESSION['user_id'] = $user_id; 
                header("Location: http://localhost/TravelQuest/user/user_dashboard.php?user_id=" . $row['user_id']);
                    exit();
                } else {
                    $errorMessages[] = "Invalid name or password.";
                }

            }
        mysqli_close($conn);
        }

}
