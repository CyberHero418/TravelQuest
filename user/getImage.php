<?php
include 'config.php'; // Make sure this path is correct

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']); // Ensures that the user ID is an integer

    $sql = "SELECT user_pic FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($imageData);
    $stmt->fetch();

    if ($imageData) {
        header("Content-Type: image/jpeg"); // Adjust according to your image type
        echo $imageData;
    } else {
        // Image not found, send a default image or error message
        header("HTTP/1.0 404 Not Found");
    }
    $stmt->close();
} else {
    header("HTTP/1.0 400 Bad Request");
    echo 'User ID is required.';
}
$conn->close();
?>
