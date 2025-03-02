<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Полный список книг для обмена</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
        header img {
            max-width: 100%;
            height: auto;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .tbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .tbl td, .tbl th {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .tbl th {
            background-color: #f2f2f2;
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
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <img src="images/logobooks1.png" alt="Логотип" width="300" height="300">
    </header>
    <div class="container">
        <h2 align="center">
            <?php
            if ($_POST['buy']) {
                unset($_SESSION['count_p']);
                echo "<p align='center'><span style='font-size: 20px; color: black; border: 1px solid red;'>Спасибо за покупку!</span></p>";
            }
            ?>
            Полный список книг для обмена:
        </h2>
        <form action='' method='POST'>
            <table class="tbl">
                <?php
                $dbuser = 'mysql';
                $dbpass = 'mysql';
                $dbserver = 'localhost';
                $dbname = '';
                $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
                or die ('Ошибка ' . mysqli_error($mysql));
                $query1 = mysqli_query($mysql, "SELECT id_product, Name, Image, Image2, Price, Count FROM products");
                while ($row = mysqli_fetch_array($query1)) {
                    echo "<tr>";
                    echo "<td><b>" . $row['Name'] . "</b><br><br>";
                    echo "<img width='350' height='300' src='{$row['Image']}' alt='{$row['Name']}'><br>";
                    echo "Цена: " . $row['Price'] . " руб.<br>";
                    if ($row['Count'] > 0) {
                        echo "<label for='counp'>Укажите количество товара:</label><br>";
                        echo "<input type='number' name='counp[]' min='0' max='{$row['Count']}' size='20' step='any'><br><br>";
                        echo "<input type='checkbox' name='id[]' value='{$row['id_product']}'>";
                        echo "<input type='hidden' name='tex[]' value='{$row['Name']}'>";
                        echo "<br>В наличии: есть";
                    } else {
                        echo "<input type='checkbox' name='id[]' value='{$row['id_product']}'>";
                        echo "<input type='hidden' name='tex[]' value='{$row['Name']}'>";
                        echo "<br>В наличии: нет";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                mysqli_close($mysql);
                ?>
            </table>
            <div align="center">
                <a href="SubmitRequest.php" class="btn">Оформление заявки</a>
            </div>
            <?php if (!$_POST['add']) { ?>
                <div class="order-panel">
                    <h3>Оформление заказа</h3>
                </div>
            <?php } ?>
            <?php
            if ($_POST['add']) {
                echo "<div class='order-panel'>";
                echo "<h3>Оформление заказа</h3>";
                echo "<p>Количество выбранных продуктов: " . count($_POST['id']) . "</p>";
                echo "<form method='POST'>";
                echo "<label>Виды доставки (если необходимо):</label><br>";
                echo "<input type='radio' name='d'> Курьером по городу<br>";
                echo "<label>Адрес:</label><br>";
                echo "<input type='text' name='address' size='20'><br>";
                echo "<input type='radio' name='d1'> Доставка почтой<br>";
                echo "<label>Адрес:</label><br>";
                echo "<input type='text' name='address' size='20'><br><br>";
                echo "<input type='submit' name='buy' value='Оформить заказ' class='btn'>";
                echo "</form>";
                echo "</div>";
            }
            ?>
            <?php if (isset($_SESSION['logged_user'])) { ?>
                <div align="center">
                    <input type='submit' name='add' value='Добавить книги в заказ' class='btn'>
                    <input type='submit' name='clear' value='Удалить книги из заказа' class='btn'>
                </div>
            <?php } ?>
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