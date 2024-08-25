<?php
session_start();
include 'connect.php';

// Handle form submission
$search_query = isset($_POST['search']) ? $_POST['search'] : '';

// Define the query to fetch data from Traner table with search functionality
$query_traner = "SELECT `№`, `ФИО тренера` AS `name` FROM Traner WHERE `ФИО тренера` LIKE ? LIMIT 19";
$stmt_traner = $conn->prepare($query_traner);
$search_param = "%{$search_query}%";
$stmt_traner->bind_param("s", $search_param);
$stmt_traner->execute();
$result_traner = $stmt_traner->get_result();

if (!$result_traner) {
    die('Query failed: ' . mysqli_error($conn));
}

// Define the query to fetch data from Students table with search functionality
$query_students = "SELECT `Номер`, `ФИО ученика` AS `name` FROM Students WHERE `ФИО ученика` LIKE ?";
$stmt_students = $conn->prepare($query_students);
$stmt_students->bind_param("s", $search_param);
$stmt_students->execute();
$result_students = $stmt_students->get_result();

if (!$result_students) {
    die('Query failed: ' . mysqli_error($conn));
}

// Close the statements
$stmt_traner->close();
$stmt_students->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sule.css"> <!-- Link your CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
    <title>Фонд «Каратэ» - Список Участников</title>
</head>
<body>
    <div class="container">
        <!-- Header with Logo, Search Form, and Account Icon -->
        <div class="header">
            <img src="/blog/logo.png" alt="Logo" class="logo">
            <div class="search-account">
                <form method="POST" class="form-inline">
                    <input type="text" name="search" class="form-control mr-sm-2" placeholder="Поиск по имени" value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit" class="btn btn-primary">Поиск</button>
                </form>
                <div class="account-icon">
                    <a href="personal_account.php">
                        <i class="fas fa-user-circle"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Display Trainer and Student Names -->
        <div class="row mt-5">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Список Тренеров
                    </div>
                    <div class="card-body table-container">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>ФИО тренера</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result_traner->num_rows > 0) { ?>
                                    <?php while ($row = mysqli_fetch_assoc($result_traner)) { ?>
                                        <tr>
                                            <td>
                                                <a href="details.php?type=trainer&id=<?php echo htmlspecialchars($row['№']); ?>">
                                                    <?php echo htmlspecialchars($row['name']); ?>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td>Нет данных для отображения</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Список Учеников
                    </div>
                    <div class="card-body table-container">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>ФИО ученика</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result_students->num_rows > 0) { ?>
                                    <?php while ($row = mysqli_fetch_assoc($result_students)) { ?>
                                        <tr>
                                            <td>
                                                <a href="details.php?type=student&id=<?php echo htmlspecialchars($row['Номер']); ?>">
                                                    <?php echo htmlspecialchars($row['name']); ?>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td>Нет данных для отображения</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
