<?php
session_start();
$user_id = $_SESSION['пользователь_id']; // ID текущего пользователя

// Подключение к базе данных
$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname);

if (!$mysql) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Получение списка книг, доступных для обмена
$query = "
    SELECT з.запрос_id, з.offered_book_id, з.desired_genre, з.desired_condition, з.desired_other, 
           к.название AS offered_book_name, к.жанр AS offered_book_genre, 
           п.ник_пользователя AS user_nickname
    FROM запросы_на_обмен з
    JOIN книги к ON з.offered_book_id = к.книга_id
    JOIN пользователи п ON з.пользователь_id = п.пользователь_id
    WHERE з.статус = 'ожидание'
";
$result = $mysql->query($query);

// Фильтр по жанру
if (isset($_GET['genre'])) {
    $genre = $_GET['genre'];
    $query .= " AND к.жанр = '$genre'";
    $result = $mysql->query($query);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Обмен книгами</title>
</head>
<body>
    <h1>Обмен книгами</h1>

    <!-- Фильтр по жанру -->
    <form method="GET" action="">
        <label for="genre">Фильтр по жанру:</label>
        <select name="genre" id="genre">
            <option value="">Все жанры</option>
            <option value="Фантастика">Фантастика</option>
            <option value="Роман">Роман</option>
            <option value="Детектив">Детектив</option>
            <!-- Добавьте другие жанры -->
        </select>
        <button type="submit">Применить</button>
    </form>

    <!-- Список книг -->
    <h2>Книги, доступные для обмена</h2>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <strong>Книга:</strong> <?= $row['offered_book_name'] ?> (<?= $row['offered_book_genre'] ?>)<br>
                <strong>Желаемый жанр:</strong> <?= $row['desired_genre'] ?><br>
                <strong>Желаемое состояние:</strong> <?= $row['desired_condition'] ?><br>
                <strong>Другие пожелания:</strong> <?= $row['desired_other'] ?><br>
                <strong>Пользователь:</strong> <?= $row['user_nickname'] ?><br>
                <a href="offer_exchange.php?request_id=<?= $row['запрос_id'] ?>">Предложить обмен</a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>