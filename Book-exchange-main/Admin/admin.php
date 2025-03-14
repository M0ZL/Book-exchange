<?php
session_start();

// Подключение к базе данных
$dbuser = 'root';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
or die ('Ошибка ' . mysqli_error($mysql));

// Проверка, залогинен ли администратор
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Обработка удаления пользователя
if (isset($_GET['delete'])) {
    $userId = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM `users` WHERE `id` = $userId";
    
    if (mysqli_query($mysql, $deleteQuery)) {
        echo "<script>alert('Пользователь удалён.')</script>";
    } else {
        echo "<script>alert('Ошибка при удалении пользователя: " . mysqli_error($mysql) . "')</script>";
    }
}

// Получение списка пользователей
$users = [];
$result = mysqli_query($mysql, "SELECT * FROM `users`");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
} else {
    echo 'Ошибка при получении данных: ' . mysqli_error($mysql);
}

mysqli_close($mysql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }

        h1 {
            text-align: center;
            color: #007BFF;
        }

        .nav-list {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }

        .nav-list li {
            display: inline;
            margin: 0 15px;
            padding: 10px 15px;
            background: #007BFF;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }

        .nav-list li:hover {
            background: #0056b3;
        }

        .section {
            display: none; /* Скрыть все секции по умолчанию */
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .active {
            display: block; /* Показывать активную секцию */
        }

        a.logout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #dc3545;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }

        a.logout:hover {
            background: #c82333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        .delete-btn {
            color: red;
            cursor: pointer;
            text-decoration: underline;
        }

        .delete-btn:hover {
            color: darkred;
        }
    </style>
    <script>
        // Функция для отображения соответствующей секции
        function showSection(section) {
            const sections = document.querySelectorAll('.section');
            sections.forEach(s => {
                s.classList.remove('active'); // Скрываем все секции
            });
            document.getElementById(section).classList.add('active'); // Показываем выбранную секцию
        }

        // Показать первую секцию по умолчанию
        window.onload = function() {
            showSection('user-list');
        };

        // Подтверждение удаления
        function confirmDelete(userId) {
            if (confirm('Вы действительно хотите удалить этого пользователя?')) {
                window.location.href = "?delete=" + userId;
            }
        }
    </script>
</head>
<body>
    <h1>Панель администратора</h1>
    <ul class="nav-list">
        <li onclick="showSection('current-exchanges')">Текущие обмены</li>
        <li onclick="showSection('user-list')">Список всех пользователей</li>
        <li onclick="showSection('staff-list')">Список всех сотрудников</li>
        <li onclick="showSection('reports')">Раздел с репортами</li>
    </ul>

    <div id="user-list" class="section active">
        <h2>Список всех пользователей</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Email</th>
                    <th>Возраст</th>
                    <th>Адрес</th>
                    <th>Логин</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['first_name']) ?></td>
                    <td><?= htmlspecialchars($user['last_name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['age']) ?></td>
                    <td><?= htmlspecialchars($user['address']) ?></td>
                    <td><?= htmlspecialchars($user['login']) ?></td>
                    <td><span class="delete-btn" onclick="confirmDelete(<?= $user['id'] ?>)">Удалить</span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="current-exchanges" class="section">
        <h2>Текущие обмены</h2>
        <p>Текущие обмены будут отображены здесь.</p>
    </div>

    <div id="staff-list" class="section">
        <h2>Список всех сотрудников</h2>
        <p>Список сотрудников будет отображён здесь.</p>
    </div>

    <div id="reports" class="section">
        <h2>Раздел с репортами</h2>
        <p>Отчёты будут отображены здесь.</p>
    </div>

    <a href="logout.php" class="logout">Выйти</a>
</body>
</html>
