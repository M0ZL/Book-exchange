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

    // Запрос к базе данных для получения информации об обменах с названиями книг
    $query = "
        SELECT 
            o.трек_номер, 
            o.статус AS статус_обмена, 
            o.дата_создания AS дата_создания_обмена,
            z.статус AS статус_заявки, 
            z.дата_создания AS дата_создания_заявки,
            k1.название AS выбранная_книга,
            k2.название AS предложенная_книга
        FROM 
            обмены o
        INNER JOIN 
            заявки_на_обмен z ON o.заявка_id = z.заявка_id
        INNER JOIN
            книги k1 ON z.книга_id = k1.книга_id
        INNER JOIN
            книги k2 ON o.предложенная_книга_id = k2.книга_id
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
<link rel="icon" type="image/png" sizes="32x32" href="images/ico.png">
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
    .exchange-item {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .exchange-item h3 {
        margin-top: 0;
    }
    .exchange-item p {
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
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div class='exchange-item'>
                    <h3>Обмен: Трек номер: " . $row["трек_номер"] . "</h3>
                    <p><strong>Статус обмена:</strong> " . $row["статус_обмена"] . "</p>
                    <p><strong>Дата создания обмена:</strong> " . $row["дата_создания_обмена"] . "</p>
                    <p><strong>Статус заявки:</strong> " . $row["статус_заявки"] . "</p>
                    <p><strong>Дата создания заявки:</strong> " . $row["дата_создания_заявки"] . "</p>
                    <p><strong>Выбранная книга:</strong> " . $row["выбранная_книга"] . "</p>
                    <p><strong>Предложенная вами книга:</strong> " . $row["предложенная_книга"] . "</p>
                  </div>";
        }
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