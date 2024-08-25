<?php
session_start();
include 'connect.php';

// Check if the user is logged in
if (!isset($_SESSION['phone_number'])) {
    header("Location: login.php");
    exit();
}

$phoneNumber = $_SESSION['phone_number'];

// Fetch user information based on the phone number
// First, check if the user is a trainer
$sql_trainer = "SELECT * FROM Traner WHERE `Мобильный телефон` = ?";
$stmt_trainer = $conn->prepare($sql_trainer);
$stmt_trainer->bind_param("s", $phoneNumber);
$stmt_trainer->execute();
$result_trainer = $stmt_trainer->get_result();

if ($result_trainer->num_rows > 0) {
    $user = $result_trainer->fetch_assoc();
    $userType = 'trainer';
} else {
    // If not a trainer, check if the user is a student
    $sql_student = "SELECT * FROM Students WHERE `Мобильный телефон` = ?";
    $stmt_student = $conn->prepare($sql_student);
    $stmt_student->bind_param("s", $phoneNumber);
    $stmt_student->execute();
    $result_student = $stmt_student->get_result();

    if ($result_student->num_rows > 0) {
        $user = $result_student->fetch_assoc();
        $userType = 'student';
    } else {
        echo "User not found.";
        exit();
    }
}

function escape($value) {
    return htmlspecialchars($value !== null ? $value : '-', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="personal.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo-container">
                <img src="/blog/logo.png" alt="Logo" class="logo">
                <div class="header-text">
                    <div class="center-text">
                        <p>Фонд «Каратэ»</p>
                    </div>
                </div>
            </div>
            <nav class="menu">
                <ul>
                    <li><a href="mainpage.php">Главная страница</a></li>
                    <li><a href="index.php">Список</a></li>
                </ul>
            </nav>
        </header>

        <div class="details">
            <h2 class="details-title">
                Личный кабинет: <?php echo escape($userType == 'trainer' ? $user['ФИО тренера'] : $user['ФИО ученика']); ?>
            </h2>
            <div class="info-section">
                <span class="info-title">Информация</span>
                <?php if ($userType == 'trainer'): ?>
                    <p><strong>ФИО тренера:</strong> <?php echo escape($user['ФИО тренера']); ?></p>
                    <p><strong>Спортивная организация:</strong> <?php echo escape($user['Спортивная организация']); ?></p>
                    <p><strong>Адрес спортивной организации:</strong> <?php echo escape($user['Адрес спортивной организации']); ?></p>
                    <p><strong>Гражданство:</strong> <?php echo escape($user['Гражданство']); ?></p>
                    <p><strong>Пол:</strong> <?php echo escape($user['Пол']); ?></p>
                    <p><strong>Дата рождения:</strong> <?php echo escape($user['Дата рождения']); ?></p>
                    <p><strong>Адрес места жительства:</strong> <?php echo escape($user['Адрес места жительства']); ?></p>
                    <p><strong>Мобильный телефон:</strong> <?php echo escape($user['Мобильный телефон']); ?></p>
                    <p><strong>ИНН:</strong> <?php echo escape($user['ИНН']); ?></p>
                    <p><strong>Разряд:</strong> <?php echo escape($user['Разряд']); ?></p>
                    <p><strong>Кью-Дан:</strong> <?php echo escape($user['Кью-Дан']); ?></p>
                    <p><strong>Дата сдачи последней аттестации:</strong> <?php echo escape($user['Дата сдачи последней аттестации']); ?></p>
                    <p><strong>Тренерская категория:</strong> <?php echo escape($user['Тренерская категория']); ?></p>
                    <p><strong>Степень:</strong> <?php echo escape($user['Степень']); ?></p>
                    <p><strong>ВУЗ:</strong> <?php echo escape($user['ВУЗ']); ?></p>
                    <p><strong>Регалии:</strong> <?php echo escape($user['Регалии']); ?></p>
                <?php else: ?>
                    <p><strong>Номер:</strong> <?php echo escape($user['Номер']); ?></p>
                    <p><strong>ФИО:</strong> <?php echo escape($user['ФИО ученика']); ?></p>
                    <p><strong>Спортивная организация:</strong> <?php echo escape($user['Спортивная организация']); ?></p>
                    <p><strong>Адрес спортивной организации:</strong> <?php echo escape($user['Адрес спортивной организации']); ?></p>
                    <p><strong>Гражданство:</strong> <?php echo escape($user['Гражданство']); ?></p>
                    <p><strong>Пол:</strong> <?php echo escape($user['Пол']); ?></p>
                    <p><strong>Дата рождения:</strong> <?php echo escape($user['Дата рождения']); ?></p>
                    <p><strong>Адрес места жительства:</strong> <?php echo escape($user['Адрес места жительства']); ?></p>
                    <p><strong>Мобильный телефон:</strong> <?php echo escape($user['Мобильный телефон']); ?></p>
                    <p><strong>ИНН:</strong> <?php echo escape($user['ИНН']); ?></p>
                    <p><strong>Разряд:</strong> <?php echo escape($user['Разряд']); ?></p>
                    <p><strong>Кью-Дан:</strong> <?php echo escape($user['Кью-Дан']); ?></p>
                    <p><strong>Дата сдачи последней аттестации:</strong> <?php echo escape($user['Дата сдачи последней аттестации']); ?></p>
                    <p><strong>Школа:</strong> <?php echo escape($user['Школа']); ?></p>
                    <p><strong>Тренер:</strong> <?php echo escape($user['Тренер']); ?></p>
                <?php endif; ?>
            </div>

            <div class="settings">
                <h3 class="settings-title">Настройки</h3>
                <a href="logout.php" class="btn-logout">Выйти из аккаунта</a>
            </div>
        </div>
    </div>
</body>
</html>
