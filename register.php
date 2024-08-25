<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if the phone number already exists
    $sql = "SELECT * FROM users WHERE Number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Этот номер телефона уже зарегистрирован.";
        header("Location: main.php");
        exit();
    } else {
        // Insert the new user into the database
        $sql = "INSERT INTO users (FirstName, LastName, Number, Password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $fName, $lName, $phone, $password);

        if ($stmt->execute()) {
            // Registration successful, redirect to the mainpage
            $_SESSION['phone_number'] = $phone;
            header("Location: mainpage.php");
            exit();
        } else {
            $_SESSION['error'] = "Ошибка регистрации. Пожалуйста, попробуйте еще раз.";
            header("Location: main.php");
            exit();
        }
    }
}
?>
