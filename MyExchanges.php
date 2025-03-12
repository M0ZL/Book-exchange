<?php
    session_start();

    // Подключение к базе данных
    $dbuser = 'mysql';
    $dbpass = 'mysql';
    $dbserver = 'localhost';
    $dbname = 'book';
    $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
    or die ('Ошибка ' . mysqli_error($mysql));

    // Проверяем, авторизован ли пользователь
    if (!isset($_SESSION['пользователь_id'])) {
        echo "Пожалуйста, войдите в систему, чтобы просмотреть свои обмены.";
        exit;
    }

    // Получаем ID пользователя из сессии
    $user_id = $_SESSION['пользователь_id'];

    // Запрос к базе данных для получения информации об обменах
    $query = "
        SELECT 
            o.обмен_id, 
            o.заявка_id, 
            o.предложенная_книга_id, 
            o.трек_номер, 
            o.статус AS статус_обмена, 
            o.дата_создания AS дата_обмена,
            z.пользователь_id, 
            z.книга_id, 
            z.статус AS статус_заявки, 
            z.дата_создания AS дата_заявки
        FROM 
            обмены o
        INNER JOIN 
            заявки_на_обмен z ON o.заявка_id = z.заявка_id
        WHERE 
            z.пользователь_id = $user_id
    ";

    $result = mysqli_query($mysql, $query);

    // Закрываем соединение с базой данных
    mysqli_close($mysql);
?>

<!DOCTYPE HTML>
<html>
<head>
<meta content="charset=utf-8">
<title>Мои обмены</title>
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
    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        flex: 1;
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
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
</head>
<body>
<header>
    <img src="images/l.png" alt="Логотип">
    <img src="images/logobooks.png" alt="Логотип">
    <img src="images/r.png" alt="Логотип">
</header>
<div class='container'>
    <h2>Мои обмены</h2>
    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table>
                <tr>
                    <th>ID обмена</th>
                    <th>ID заявки</th>
                    <th>ID предложенной книги</th>
                    <th>Трек-номер</th>
                    <th>Статус обмена</th>
                    <th>Дата обмена</th>
                    <th>Статус заявки</th>
                    <th>Дата заявки</th>
                </tr>";
        // Выводим данные каждой строки
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $row["обмен_id"]. "</td>
                    <td>" . $row["заявка_id"]. "</td>
                    <td>" . $row["предложенная_книга_id"]. "</td>
                    <td>" . $row["трек_номер"]. "</td>
                    <td>" . $row["статус_обмена"]. "</td>
                    <td>" . $row["дата_обмена"]. "</td>
                    <td>" . $row["статус_заявки"]. "</td>
                    <td>" . $row["дата_заявки"]. "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "У вас пока нет обменов.";
    }
    ?>
</div>
<div align="center">
    <a href="Profile.php" class="btn">Назад</a><br><br>
</div>
<footer>
    Контактная информация:</br>
    Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)</br>
    <p>Наш режим работы: Понедельник – Воскресенье: 10:00 – 18:00</p>
    <p>Электронная почта: <a href="mailto:BooksForExchange@gmail.com">Напишите нам!</a></p>
</footer>
</body>
</html>