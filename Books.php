<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="images/ico.png">
    <title>Полный список книг для обмена</title>
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
            width: 40%; /* Уменьшаем ширину изображения до 30% от ширины ячейки */
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
        .fixed-gif1 {
            position: fixed;
            left: 0px;
            top: 50%; /* Начальная позиция по вертикали */
            transform: translateY(-50%); /* Центрирование по вертикали */
            z-index: 1000; /* Убедитесь, что гифка находится поверх других элементов */
            width: 220px; /* Ширина гифки */
            height: auto; /* Высота подстраивается автоматически */
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
    <img src="images/chebyrashka.gif" alt="Анимация" class="fixed-gif1">
    <div class="container">
            Полный список книг для обмена:
        </h2>
        <form action='' method='POST'>
        <table class="tbl">
            <?php
            $dbuser = 'mysql';
            $dbpass = 'mysql';
            $dbserver = 'localhost';
            $dbname = 'book';
            $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
            or die ('Ошибка ' . mysqli_error($mysql));
            $query1 = mysqli_query($mysql, "SELECT p.имя, k.книга_id, k.пользователь_id, k.название, k.isbn, фото, k.автор, k.жанр, k.год_издания, k.статус, k.дата_добавления FROM книги k INNER JOIN пользователи p ON k.пользователь_id = p.пользователь_id");

            $count = 0; // Счетчик для отслеживания количества ячеек в строке
            $cellsPerRow = 3; // Количество ячеек в одной строке

            echo "<tr>"; // Начинаем первую строку

            while ($row = mysqli_fetch_array($query1)) {
                if ($count % $cellsPerRow == 0 && $count != 0) {
                    echo "</tr><tr>"; // Закрываем текущую строку и начинаем новую, если достигли нужного количества ячеек
                }

                echo "<td><b>" . $row['название'] . "</b><br><br>";
                echo "<img src='{$row['фото']}' alt='{$row['название']}' class='book-image'><br>";
                echo "ISBN: " . $row['isbn'] . "<br>";
                echo "Автор: " . $row['автор'] . "<br>";
                echo "Жанр: " . $row['жанр'] . "<br>";
                echo "Год издания: " . $row['год_издания'] . "<br>";
                echo "Статус: " . $row['статус'] . "<br>";
                echo "Дата добавления: " . $row['дата_добавления'] . "<br>";
                echo "Пользователь, добавивший книгу: " . $row['имя'] . "<br>";
                echo "<a href='Entry.php' class='btn'>Оформление заявки</a>";
                echo "</td>";

                $count++;
            }

            // Если количество книг не кратно $cellsPerRow, добавляем пустые ячейки для завершения строки
            while ($count % $cellsPerRow != 0) {
                echo "<td></td>";
                $count++;
            }

            echo "</tr>"; // Закрываем последнюю строку

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
                if(!empty($_SESSION['acc_user'])){
                    echo "<p align=center><a href = 'AddProduct.php'>Добавить новую книгу</a><br><br>
                    <a href = 'EditProduct.php'>Редактировать данные о книгах</a><br>";
                    echo "<form action='Products.php'  method='post'><div align=center> 
                    <table>
                    <tr>
                    <td >Список:<br><select class='form-control' name='list' size='1'>";
                    
                    $stmt = mysqli_query($mysql, "SELECT * FROM products");
                    while ($row = mysqli_fetch_array($stmt))
                        echo '<option value="' . $row["id_product"] . '">' . $row["id_product"] ." ". $row["Name"] ." ". $row["Price"] ." ". $row["Count"] . '</option>';
                    echo "</select><br><br>";
                    
                    $list =$_POST["list"];
                    if (isset($_POST['delete'])) {
                        $strSQL2 = mysqli_query($mysql, "DELETE FROM `products` WHERE id_product = $list") 
                        or die (mysqli_error($mysql));
                    }
                    
                    echo "</td>
                    </tr>
                    </table>
                    <div align='center'><input type='submit' class= 'btn btn-primary' style='width:210px' name='delete'
                    value='Удалить данные о книге'></div>
                    </div></form>";
                }
            mysqli_close($mysql);
            ?>
        </form>
        <div align="center">
            <a href="index.php" class="btn">На главную страницу</a>
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