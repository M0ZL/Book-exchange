<?php
session_start();

// Подключение к базе данных
$dbuser = 'mysql';
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
$result = mysqli_query($mysql, "SELECT * FROM `пользователи`");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
} else {
    echo 'Ошибка при получении данных: ' . mysqli_error($mysql);
}


mysqli_close($mysql);
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
or die ('Ошибка ' . mysqli_error($mysql));

// Получаем данные о жалобах
$query = "
    SELECT 
        j.жалоба_id,
        j.описание,
        u1.ник_пользователя AS жалобщик,
        u2.ник_пользователя AS жалобный,
        j.дата_создания
    FROM 
        жалобы j
    JOIN 
        пользователи u1 ON j.пользователь_id = u1.пользователь_id
    JOIN 
        пользователи u2 ON j.жалоба_на = u2.пользователь_id
";
$result = mysqli_query($mysql, $query);
$complaints = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($mysql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <style>
        .admin-info {
            font-size: 16px;
            color: #333;
        }
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
    function changeStatus(userId, currentStatus) {
        // Определяем новый статус
        const newStatus = currentStatus === 'активный' ? 'бан' : 'активный';

        // Отправляем AJAX-запрос
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "change_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Обновляем статус на странице
                const statusElement = document.querySelector(`tr td span.status[data-id="${userId}"]`);
                if (statusElement) {
                    statusElement.textContent = newStatus;
                    // Обновляем текст кнопки
                    const button = statusElement.nextElementSibling;
                    button.textContent = newStatus === 'активный' ? 'Забанить' : 'Разбанить';
                }
            }
        };
        xhr.send("user_id=" + userId + "&new_status=" + newStatus);
    }
    </script>
    <script>
        // function changeStatus(userId, currentStatus) {
        //     const newStatus = currentStatus === 'активный' ? 'бан' : 'активный';
        //     if (confirm(`Вы действительно хотите изменить статус пользователя на "${newStatus}"?`)) {
                
        //     }
        // }
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
<div class="header">
        <h1>Панель администратора</h1>
        <div class="admin-info">
            <?php if (isset($_SESSION['admin_full_name'])): ?>
                <span><?= htmlspecialchars($_SESSION['admin_full_name']) ?></span>
                <a href="logout.php" class="logout">Выйти</a>
            <?php endif; ?>
        </div>
    </div>

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
                    <th>Статус</th>
                    
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['пользователь_id']) ?></td>
                    <td><?= htmlspecialchars($user['имя']) ?></td>
                    <td><?= htmlspecialchars($user['фамилия']) ?></td>
                    <td><?= htmlspecialchars($user['электронная_почта']) ?></td>
                    <td><?= htmlspecialchars($user['возраст']) ?></td>
                    <td><?= htmlspecialchars($user['адрес']) ?></td>
                    <td><?= htmlspecialchars($user['ник_пользователя']) ?></td>
                    <td>
                        <span class="status"><?= htmlspecialchars($user['статус']) ?></span>
                        <button onclick="changeStatus(<?= $user['пользователь_id'] ?>, '<?= $user['статус'] ?>')">
                            <?= $user['статус'] === 'активный' ? 'Забанить' : 'Разбанить' ?>
                        </button>
                    </td>
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
        <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Жалобщик (ID, Ник)</th>
                <th>Жалобный (ID, Ник)</th>
                <th>Описание жалобы</th>
                <th>Дата создания</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($complaints as $complaint): ?>
                <tr>
                    <td><?= htmlspecialchars($complaint['жалоба_id']) ?></td>
                    <td><?= htmlspecialchars($complaint['жалобщик']) ?> (<?= htmlspecialchars($complaint['пользователь_id']) ?>)</td>
                    <td><?= htmlspecialchars($complaint['жалобный']) ?> (<?= htmlspecialchars($complaint['жалоба_на']) ?>)</td>
                    <td><?= htmlspecialchars($complaint['описание']) ?></td>
                    <td><?= htmlspecialchars($complaint['дата_создания']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>

</body>
</html>
