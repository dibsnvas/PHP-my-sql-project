<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('db.php');

// Get the type and id from the URL
$type = isset($_GET['type']) ? $_GET['type'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($type === 'trainer') {
    // Fetch trainer details
    $query = "SELECT * FROM Traner WHERE `№` = $id";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die('Query failed: ' . mysqli_error($con));
    }

    $data = mysqli_fetch_assoc($result);

    // Fetch all students under this trainer
    $students_query = "SELECT `ФИО ученика`, `Номер` FROM Students WHERE `Тренер` = (SELECT `ФИО тренера` FROM Traner WHERE `№` = $id)";
    $students_result = mysqli_query($con, $students_query);

    if (!$students_result) {
        die('Query failed: ' . mysqli_error($con));
    }

    $students = [];
    while ($student = mysqli_fetch_assoc($students_result)) {
        $students[] = $student;
    }
} else {
    // Fetch student details
    $query = "SELECT * FROM Students WHERE `Номер` = $id";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die('Query failed: ' . mysqli_error($con));
    }

    $data = mysqli_fetch_assoc($result);
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
    <title>Фонд «Каратэ» - Детали Участника</title>
    <link rel="stylesheet" href="css.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="/blog/logo.png" alt="Logo" class="logo">
            <h1>Фонд «Каратэ»</h1>
        </div>
        
        <div class="details">
            <h2><?php echo escape($data[$type === 'trainer' ? 'ФИО тренера' : 'ФИО ученика']); ?></h2>
            <div class="info-section">
                <h3>Информация</h3>
                <?php if ($type === 'trainer') { ?>
                    <p><strong>№:</strong> <?php echo escape($data['№']); ?></p>
                    <p><strong>Спортивная организация:</strong> <?php echo escape($data['Спортивная организация']); ?></p>
                    <p><strong>Адрес спортивной организации:</strong> <?php echo escape($data['Адрес спортивной организации']); ?></p>
                    <p><strong>Гражданство:</strong> <?php echo escape($data['Гражданство']); ?></p>
                    <p><strong>Пол:</strong> <?php echo escape($data['Пол']); ?></p>
                    <p><strong>Дата рождения:</strong> <?php echo escape($data['Дата рождения']); ?></p>
                    <p><strong>Адрес места жительства:</strong> <?php echo escape($data['Адрес места жительства']); ?></p>
                    <p><strong>Мобильный телефон:</strong> <?php echo escape($data['Мобильный телефон']); ?></p>
                    <p><strong>ИНН:</strong> <?php echo escape($data['ИНН']); ?></p>
                    <p><strong>Разряд:</strong> <?php echo escape($data['Разряд']); ?></p>
                    <p><strong>Кью-Дан:</strong> <?php echo escape($data['Кью-Дан']); ?></p>
                    <p><strong>Дата сдачи последней аттестации:</strong> <?php echo escape($data['Дата сдачи последней аттестации']); ?></p>
                    <p><strong>Тренерская категория:</strong> <?php echo escape($data['Тренерская категория']); ?></p>
                    <p><strong>Степень:</strong> <?php echo escape($data['Степень']); ?></p>
                    <p><strong>ВУЗ:</strong> <?php echo escape($data['ВУЗ']); ?></p>
                    <p><strong>Регалии:</strong> <?php echo escape($data['Регалии']); ?></p>

                    <!-- List of students under this trainer -->
                    <h3>Ученики тренера</h3>
                    <ul>
                        <?php foreach ($students as $student) { ?>
                            <li>
                                <a href="details.php?type=student&id=<?php echo escape($student['Номер']); ?>">
                                    <?php echo escape($student['ФИО ученика']); ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p><strong>Номер:</strong> <?php echo escape($data['Номер']); ?></p>
                    <p><strong>ФИО ученика:</strong> <?php echo escape($data['ФИО ученика']); ?></p>
                    <p><strong>Спортивная организация:</strong> <?php echo escape($data['Спортивная организация']); ?></p>
                    <p><strong>Адрес спортивной организации:</strong> <?php echo escape($data['Адрес спортивной организации']); ?></p>
                    <p><strong>Гражданство:</strong> <?php echo escape($data['Гражданство']); ?></p>
                    <p><strong>Пол:</strong> <?php echo escape($data['Пол']); ?></p>
                    <p><strong>Дата рождения:</strong> <?php echo escape($data['Дата рождения']); ?></p>
                    <p><strong>Адрес места жительства:</strong> <?php echo escape($data['Адрес места жительства']); ?></p>
                    <p><strong>Мобильный телефон:</strong> <?php echo escape($data['Мобильный телефон']); ?></p>
                    <p><strong>ИНН:</strong> <?php echo escape($data['ИНН']); ?></p>
                    <p><strong>Разряд:</strong> <?php echo escape($data['Разряд']); ?></p>
                    <p><strong>Кью-Дан:</strong> <?php echo escape($data['Кью-Дан']); ?></p>
                    <p><strong>Дата сдачи последней аттестации:</strong> <?php echo escape($data['Дата сдачи последней аттестации']); ?></p>
                    <p><strong>Школа:</strong> <?php echo escape($data['Школа']); ?></p>
                    <p><strong>Тренер:</strong> <?php echo escape($data['Тренер']); ?></p>
                <?php } ?>
            </div>
            
            <div class="settings">
                <h3>Настройки</h3>
                <a href="logout.php" class="btn btn-danger">Выйти из аккаунта</a>
            </div>
        </div>
    </div>
</body>
</html>
