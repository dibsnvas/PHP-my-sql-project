<?php
$host = 'localhost';
$user = 'root';
$password = '130505';
$database = 'Carate'; // Replace with your actual database name

// Create connection
$con = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
