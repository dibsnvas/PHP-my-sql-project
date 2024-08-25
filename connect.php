<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "Carate";

// Create a new connection
$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
