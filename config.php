<?php
define('DB_HOST', 'localhost');    // Database host (e.g., localhost)
define('DB_USER', 'root'); // Database username
define('DB_PASS', ''); // Database password
define('DB_NAME', 'travelquest'); // Database name



// Establish a connection to the database using MySQLi or PDO
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php

echo "Hello word !!!!!!";

?>

<?php

echo "Pull :git pull origin main";



?>


<?php

echo "uiuu dsdsd";



?>