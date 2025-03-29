<?php
session_start();
$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
or die ('Ошибка ' . mysqli_error($mysql));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="images/ico.png">
    <title>Профиль пользователя</title>
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
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
        }
        header img {
            max-height: 200px;
            width: auto;
            flex: 0 0 auto;
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
            width: 250px;
            height: auto;
            display: block;
            margin: 0 auto;
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
            margin-top: auto;
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
<body>
    <header>
        <img src="images/l.png" alt="Логотип">
        <img src="images/logobooks.png" alt="Логотип">
        <img src="images/r.png" alt="Логотип">
    </header>
    <img src="images/GamerGIF_PORNO.gif" alt="Анимация" class="fixed-gif">
    <div class="container">
        <?php
        if (isset($_GET['user_id'])) {
            $user_id = intval($_GET['user_id']);
            $query = mysqli_query($mysql, "SELECT * FROM пользователи WHERE пользователь_id = $user_id");
            $user = mysqli_fetch_array($query);

            if ($user) {
                echo "<h1>Профиль пользователя</h1>";
                echo "<p>Фамилия: " . $user['фамилия'] . "</p>";
                echo "<p>Имя: " . $user['имя'] . "</p>";
                echo "<p>Отчество: " . $user['отчество'] . "</p>";
                if($user["статус"]=="бан"){
                    echo "<p style=color:red;>ЗАБЛОКИРОВАН</p>";
                }
                
                
                // Получаем книги, выставленные пользователем
                $books_query = mysqli_query($mysql, "SELECT * FROM книги WHERE пользователь_id = $user_id");
                echo "<h2>Книги, выставленные пользователем:</h2>";
                echo "<table class='tbl'>";

                // Счетчик для отслеживания количества книг
                $count = 0;
                $cellsPerRow = 3; // Количество ячеек в одной строке

                // Массив для хранения данных о книгах
                $books = [];
                while ($book = mysqli_fetch_array($books_query)) {
                    $books[] = $book;
                }

                // Переменная для отслеживания текущей позиции в массиве книг
                $index = 0;
                $totalBooks = count($books);

                // Цикл для обработки книг блоками по 3
                while ($index < $totalBooks) {
                    // Первая строка: названия книг
                    echo "<tr>";
                    for ($i = 0; $i < $cellsPerRow; $i++) {
                        if ($index + $i < $totalBooks) {
                            echo "<td><b>" . $books[$index + $i]['название'] . "</b></td>";
                        } else {
                            echo "<td></td>"; // Пустая ячейка, если книг меньше 3
                        }
                    }
                    echo "</tr>";

                    // Вторая строка: фото книг
                    echo "<tr>";
                    for ($i = 0; $i < $cellsPerRow; $i++) {
                        if ($index + $i < $totalBooks) {
                            echo "<td><img src='{$books[$index + $i]['фото']}' alt='{$books[$index + $i]['название']}' class='book-image'></td>";
                        } else {
                            echo "<td></td>"; // Пустая ячейка, если книг меньше 3
                        }
                    }
                    echo "</tr>";

                    // Третья строка: текст о книгах
                    echo "<tr>";
                    for ($i = 0; $i < $cellsPerRow; $i++) {
                        if ($index + $i < $totalBooks) {
                            echo "<td>";
                            echo "ISBN: " . $books[$index + $i]['isbn'] . "<br>";
                            echo "Автор: " . $books[$index + $i]['автор'] . "<br>";
                            echo "Жанр: " . $books[$index + $i]['жанр'] . "<br>";
                            echo "Год издания: " . $books[$index + $i]['год_издания'] . "<br>";
                            echo "Статус: " . $books[$index + $i]['статус'] . "<br>";
                            echo "Дата добавления: " . $books[$index + $i]['дата_добавления'] . "<br>";
                            echo "</td>";
                        } else {
                            echo "<td></td>"; // Пустая ячейка, если книг меньше 3
                        }
                    }
                    echo "</tr>";

                    // Увеличиваем индекс на количество обработанных книг
                    $index += $cellsPerRow;
                }

                echo "</table>";

                // Кнопка "Подать жалобу"
                echo '<form action="SubmitComplaint.php" method="post">';
                echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
                echo '<label for="description">Описание жалобы:</label><br>';
                echo '<textarea name="description" id="description" rows="4" required></textarea><br>';
                echo '<button type="submit" class="btn">Подать жалобу</button>';
                echo '</form>';
            } else {
                echo "<p>Пользователь не найден.</p>";
            }
        } else {
            echo "<p>Не указан идентификатор пользователя.</p>";
        }
        mysqli_close($mysql);
        ?>
        <div align="center">
            <a href="index.php" class="btn">Назад</a>
        </div>
    </div>
    <footer>
        <p>Контактная информация:</p>
        <p>Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)</p>
        <p>Наш режим работы:</p>
        <p>Понедельник - Воскресенье: 10:00 – 18:00</p>
        <p>Электронная почта: <a href="mailto:BooksForExchange@gmail.com">Напишите нам!</a></p>
    </footer>
</body>
</html>