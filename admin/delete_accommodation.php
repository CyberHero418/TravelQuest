<?php
include 'config.php'; 


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $accommodation_id = $_GET['id'];

    
    $query = "DELETE FROM accommodation WHERE accommodation_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $accommodation_id);

    if ($stmt->execute()) {
        echo "<script>alert('Accommodation deleted successfully.'); window.location.href='manage_accommodations.php';</script>";
    } else {
        echo "Error deleting accommodation: " . $conn->error;
    }
} else {
    echo "Invalid accommodation ID.";
    exit();
}
?>
