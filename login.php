<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phoneNumber = $_POST['phone'];
    $password = $_POST['password'];

    // Fetch user data from the database
    $sql = "SELECT * FROM users WHERE Number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $phoneNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['Password'])) {
            // Set session variables and redirect to mainpage.php
            $_SESSION['phone_number'] = $user['Number'];
            header("Location: mainpage.php");
            exit();
        } else {
            // Wrong password, show an error
            $_SESSION['error'] = "Неверный пароль.";
            header("Location: main.php");
            exit();
        }
    } else {
        // User not found, show an error
        $_SESSION['error'] = "Пользователь не найден.";
        header("Location: main.php");
        exit();
    }
}
?>
