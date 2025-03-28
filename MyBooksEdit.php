<?php
session_start();

if (!isset($_SESSION['пользователь_id'])) {
    echo "<script>location.replace('Entry.php');</script>"; // Перенаправляем на страницу входа, если пользователь не авторизован
    exit();
}

$user_id = $_SESSION['пользователь_id'];

// Обработка сохранения изменений
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    $dbuser = 'mysql';
    $dbpass = 'mysql';
    $dbserver = 'localhost';
    $dbname = 'book';
    $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
    or die ('Ошибка ' . mysqli_error($mysql));

    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $isbn = $_POST['isbn'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $status = $_POST['status'];

    // Обработка загрузки изображения
    if ($_FILES['cover']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'images/'; // Папка для сохранения загруженных изображений
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true); // Создаем папку, если она не существует
        }

        $file_name = basename($_FILES['cover']['name']);
        $file_path = $upload_dir . $file_name;

        // Перемещаем загруженный файл в папку uploads
        if (move_uploaded_file($_FILES['cover']['tmp_name'], $file_path)) {
            // Обновляем путь к изображению в базе данных
            $query = "UPDATE `книги` 
                      SET `название` = '$title', `isbn` = '$isbn', `автор` = '$author', `жанр` = '$genre', `год_издания` = '$year', `статус` = '$status', `фото` = '$file_path' 
                      WHERE `книга_id` = $book_id AND `пользователь_id` = $user_id";
        } else {
            echo "<script>alert('Ошибка при загрузке изображения.');</script>";
        }
    } else {
        // Если изображение не загружено, обновляем только текстовые данные
        $query = "UPDATE `книги` 
                  SET `название` = '$title', `isbn` = '$isbn', `автор` = '$author', `жанр` = '$genre', `год_издания` = '$year', `статус` = '$status' 
                  WHERE `книга_id` = $book_id AND `пользователь_id` = $user_id";
    }

    mysqli_query($mysql, $query) or die(mysqli_error($mysql));
    mysqli_close($mysql);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="images/ico.png">
    <title>Мои книги</title>
    <style>
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
            padding: 10px;
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
        .order-panel {
            background-color: #444;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .order-panel input[type="text"], .order-panel input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .order-panel input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .order-panel input[type="submit"]:hover {
            background-color: #218838;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
            margin-top: auto; /* Прижимаем footer к низу */
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
        <h2>Мои книги для обмена:</h2>
        <table class="tbl">
            <?php
            $dbuser = 'mysql';
            $dbpass = 'mysql';
            $dbserver = 'localhost';
            $dbname = 'book';
            $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
            or die ('Ошибка ' . mysqli_error($mysql));

            // Проверяем, авторизован ли пользователь
            if (isset($_SESSION['пользователь_id'])) {
                $user_id = $_SESSION['пользователь_id'];

                // Запрос для выбора книг, добавленных текущим пользователем
                $query1 = mysqli_query($mysql, "SELECT `книга_id`, `пользователь_id`, `название`, `isbn`, `фото`, `автор`, `жанр`, `год_издания`, `статус`, `дата_добавления` 
                                                FROM `книги` 
                                                WHERE `пользователь_id` = $user_id");

                $count = 0; // Счетчик для отслеживания количества книг
                $cellsPerRow = 3; // Количество ячеек в одной строке

                // Массив для хранения данных о книгах
                $books = [];
                while ($row = mysqli_fetch_array($query1)) {
                    $books[] = $row;
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

                    // Третья строка: форма редактирования книг
                    echo "<tr>";
                    for ($i = 0; $i < $cellsPerRow; $i++) {
                        if ($index + $i < $totalBooks) {
                            echo "<td>";
                            echo "<form method='POST' action='' enctype='multipart/form-data'>";
                            echo "<input type='hidden' name='book_id' value='{$books[$index + $i]['книга_id']}'>";
                            echo "Название: <input type='text' name='title' value='{$books[$index + $i]['название']}'><br>";
                            echo "ISBN: <input type='text' name='isbn' value='{$books[$index + $i]['isbn']}'><br>";
                            echo "Автор: <input type='text' name='author' value='{$books[$index + $i]['автор']}'><br>";
                            echo "Жанр: <input type='text' name='genre' value='{$books[$index + $i]['жанр']}'><br>";
                            echo "Год издания: <input type='text' name='year' value='{$books[$index + $i]['год_издания']}'><br>";
                            echo "Статус: <input type='text' name='status' value='{$books[$index + $i]['статус']}'><br>";
                            echo "Обложка: <input type='file' name='cover'><br>";
                            echo "<input type='submit' name='save' value='Сохранить изменения'>";
                            echo "</form>";
                            echo "</td>";
                        } else {
                            echo "<td></td>"; // Пустая ячейка, если книг меньше 3
                        }
                    }
                    echo "</tr>";

                    // Увеличиваем индекс на количество обработанных книг
                    $index += $cellsPerRow;
                }
            } else {
                echo "<tr><td colspan='3'>Пожалуйста, войдите в систему, чтобы увидеть свои книги.</td></tr>";
            }


            // Проверка, была ли удалена книга
            if (mysqli_affected_rows($mysql) > 0) {
                echo "<b>Книга успешно обновлена.</b>";
            } else {
                echo "<b>Ошибка: книга не обновлена!</b>";
            }

            mysqli_close($mysql);
            ?>
        </table>
        <?php
            $dbuser = 'mysql';
            $dbpass = 'mysql';
            $dbserver = 'localhost';
            $dbname = 'book';
            $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
            or die ('Ошибка ' . mysqli_error($mysql));
                if(!empty($_SESSION['пользователь_id'])){
                    
                    echo "<form action='MyBooksEdit.php' method='post'><div align='center'> 
                    <table>
                        <tr>
                            <td>Список:<br>
                                <select class='form-control' name='list' size='1'>";
                                
                                // Запрос для выбора книг текущего пользователя
                                $stmt = mysqli_query($mysql, "SELECT `книга_id`, `название`, `автор`, `жанр` 
                                                            FROM `книги` 
                                                            WHERE `пользователь_id` = $user_id");
                                while ($row = mysqli_fetch_array($stmt)) {
                                    echo '<option value="' . $row["книга_id"] . '">' . $row["название"] . " " . $row["автор"] . " " . $row["жанр"] . '</option>';
                                }
                                $list = $_POST["list"];
                                if (isset($_POST['delete'])) {
                                    // Удаление книги, если она принадлежит текущему пользователю
                                    $strSQL2 = mysqli_query($mysql, "DELETE FROM `книги` WHERE `книга_id` = $list AND `пользователь_id` = $user_id") 
                                    or die(mysqli_error($mysql));

                                    // Проверка, была ли удалена книга
                                    if (mysqli_affected_rows($mysql) > 0) {
                                        echo "<b>Книга успешно удалена.</b>";
                                    } else {
                                        echo "<b>Ошибка: книга не удалена или не найдена.</b>";
                                    }
                                }
                                }
                                echo "</select><br><br>
                            </td>
                        </tr>
                    </table>
                    <div align='center'>
                        <input type='submit' class='btn btn-primary' style='width:210px' name='delete' value='Удалить данные о книге'><br><br>
                    </div>
                </div></form>";

                
            mysqli_close($mysql);
            ?>
        <div align="center">
            <a href="Profile.php" class="btn">Назад</a>
        </div>
    </div>
    <footer>
        <p>Контактная информация:<br>
        Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)<br>
        Наш режим работы: Понедельник - Воскресенье: 10:00 – 18:00<br>
        Электронная почта: <a href="mailto:BooksForExchange@gmail.com">Напишите нам!</a></p>
    </footer>
</body>
</html>