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
           з.пользователь_id as request_user_id,  -- Добавляем ID пользователя, создавшего запрос
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
    <style type="text/css">
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            flex: 1;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            display: flex;
            justify-content: space-between; /* Распределяем пространство между изображениями */
            align-items: center; /* Центрируем изображения по вертикали */
            flex-wrap: nowrap; /* Запрещаем перенос на новую строку */
        }
        header img {
            max-height: 200px; /* Ограничиваем высоту изображений */
            width: auto; /* Ширина подстраивается автоматически */
            flex: 0 0 auto; /* Запрещаем изображениям растягиваться или сжиматься */
        }
        @media (max-width: 768px) {
            header img {
                flex: 1 1 45%;
            }
        }
        @media (max-width: 480px) {
            header img {
                flex: 1 1 100%;
            }
        }
        nav {
            display: flex;
            justify-content: center;
            background-color: #444;
            padding: 10px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        nav a:hover {
            background-color: #555;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex: 1;
        }
        .carousel {
            position: relative;
            width: 100%;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .carousel img {
            width: 100%;
            height: auto;
        }
        .carousel-control {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 10px;
            cursor: pointer;
            border-radius: 50%;
            user-select: none;
        }
        .carousel-control.prev {
            left: 10px;
        }
        .carousel-control.next {
            right: 10px;
        }
        .tbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .tbl td, .tbl th {
            border: 0px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .tbl th {
            background-color: #f2f2f2;
        }
        .book-image {
            width: 250px; /* Уменьшаем ширину изображения до 250px от ширины ячейки */
            height: auto; /* Высота подстраивается автоматически для сохранения пропорций */
            display: block; /* Убирает лишние отступы вокруг изображения */
            margin: 0 auto; /* Центрирование изображения по горизонтали */
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #555;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
            margin-top: auto; /* Прижимаем footer к низу */
        }
		.carousel {
        position: relative;
        width: 100%;
        overflow: hidden;
        margin-bottom: 20px;
        }

        .carousel-inner {
            display: flex;
            transition: transform 0.5s ease-in-out; /* Плавный переход */
        }

        .carousel-item {
            min-width: 100%; /* Каждый слайд занимает 100% ширины */
            box-sizing: border-box;
        }

        .carousel-control {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 10px;
            cursor: pointer;
            border-radius: 50%;
            user-select: none;
            z-index: 10;
        }

        .carousel-control.prev {
            left: 10px;
        }

        .carousel-control.next {
            right: 10px;
        }
        .container1 {
            width: 60%;
            margin: 0 auto;
            text-align: center;
        }
        .news-item {
            text-align: left;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .news-item h2, .news-item p, .news-item h5 {
            margin: 5px 0;
        }
        .fixed-gif {
            position: fixed;
            right: 40px;
            top: 50%; /* Начальная позиция по вертикали */
            transform: translateY(-50%); /* Центрирование по вертикали */
            z-index: 1000; /* Убедитесь, что гифка находится поверх других элементов */
            width: 150px; /* Ширина гифки */
            height: auto; /* Высота подстраивается автоматически */
        }
        .tbl td {
            text-align: center; /* Выравнивание текста по центру */
            vertical-align: middle; /* Выравнивание содержимого по вертикали */
        }
    </style>
</head>
<header>
        <img src="images/l.png" alt="Логотип">
        <img src="images/logobooks.png" alt="Логотип">
        <img src="images/r.png" alt="Логотип">
    </header><br>
    <img src="images/GamerGIF_PORNO.gif" alt="Анимация" class="fixed-gif">
        <div align="center">
                <a href="index.php" class="btn">На главную</a>
                <a href="Profile.php" class="btn">Личный аккаунт</a>
        </div>
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
                
                <?php if ($row['request_user_id'] != $user_id): ?>
                    <a href="offer_exchange.php?request_id=<?= $row['запрос_id'] ?>">Предложить обмен</a>
                <?php else: ?>
                    <span style="color: gray;">Это ваш запрос</span>
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>