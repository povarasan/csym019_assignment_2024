<?php
// db.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Premier";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


// Function to close the connection
function closeConnection($conn) {
    $conn->close();
}
?>
