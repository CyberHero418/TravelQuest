<?php
include 'config.php'; 


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    
    $query = "DELETE FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully.'); window.location.href='admin.php';</script>";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "Invalid user ID.";
    exit();
}
?>
