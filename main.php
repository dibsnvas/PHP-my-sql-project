<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="/blog/logo.png" alt="Logo" class="logo">
        <div class="header-text">
            <div class="left-text">
                <p>РЕСПУБЛИКАНСКАЯ</p>
                <p>ФЕДЕРАЦИЯ КАРАТЭ</p>
                <p>ШИНКИОКУШИНКАЙ</p>
            </div>
            <div class="center-text">
                <p>Фонд «Каратэ»</p>
            </div>
        </div>
    </header>

    <div class="container" id="signup">
        <h1 class="form-title">Регистрация</h1>

        <?php
        if (isset($_SESSION['error'])) {
            echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        ?>

        <form method="post" action="register.php">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="fName" id="fName" placeholder="Имя" required>
            </div>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="lName" id="lName" placeholder="Фамилия" required>
            </div>
            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="tel" name="phone" id="phone" placeholder="Номер телефона" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Пароль" required>
            </div>
            <input type="submit" class="btn" value="Зарегестрироваться" name="signUp">
        </form>
        <div class="links">
            <p>Уже есть аккаунт?</p>
            <button id="signInButton">Войти</button>
        </div>
    </div>

    <div class="container" id="signIn" style="display:none;">
        <h1 class="form-title">Войти</h1>

        <?php
        if (isset($_SESSION['error'])) {
            echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        ?>

        <form method="post" action="login.php">
            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="tel" name="phone" id="phoneSignIn" placeholder="Phone Number" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="passwordSignIn" placeholder="Password" required>
            </div>
            <p class="recover">
                <a href="#">Забыли пароль?</a>
            </p>
            <input type="submit" class="btn" value="Войти" name="signIn">
        </form>
        <div class="links">
            <p>Еще нет аккаунта?</p>
            <button id="signUpButton">Зарегестрироваться</button>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
