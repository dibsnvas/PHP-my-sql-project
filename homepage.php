<?php
session_start();
include("connect.php");

if (!isset($_SESSION['phone_number'])) {
    header("Location: main.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>
<body>
    <div style="text-align:center; padding:15%;">
      <p style="font-size:50px; font-weight:bold;">
       Hello  
       <?php 
       $phoneNumber = $_SESSION['phone_number'];
       $query = $conn->prepare("SELECT firstName, lastName FROM users WHERE phone_number=?");
       $query->bind_param("s", $phoneNumber);
       $query->execute();
       $result = $query->get_result();
       if ($row = $result->fetch_assoc()) {
           echo $row['firstName'] . ' ' . $row['lastName'];
       }
       ?>
       :)
      </p>
      <a href="logout.php">Logout</a>
    </div>
</body>
</html>
