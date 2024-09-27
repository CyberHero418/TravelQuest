<?php
$conn=mysqli_connect("localhost","root","","travelquest") or die("Connection Failed");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

