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
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" sizes="32x32" href="images/ico.png">
    <title>Запрос на обмен</title>
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
<body>
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
    
    <form class="container" action="zaprosForm.php" method="post">
    <h1>Запрос на обмен</h1>
        <h2>Книга предлагаемая к обмену</h2>
        <select name="offered_book_id" required>
            <?php
            if (isset($_SESSION['пользователь_id'])) {
                $user_id = $_SESSION['пользователь_id'];
            echo "User ID: " . $user_id; // Проверьте, выводится ли правильный ID
            // Подключение к базе данных
            

            // Запрос для получения книг пользователя
            $query = "SELECT книга_id, название, isbn FROM книги WHERE пользователь_id = ? AND статус = 'доступна'";
            $stmt = $mysql->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                echo "User ID: " . $user_id; // Проверьте, выводится ли правильный ID
                echo "<option value=''>Нет доступных книг</option>";
            } else {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['книга_id']}'>{$row['название']} (ISBN: {$row['isbn']})</option>";
                }
            }
            $stmt->close();
            $mysql->close();
        } else {
            echo "<p>Не указан идентификатор пользователя.</p>";
        }
            ?>
        </select>

        <h2>Данные по книге, запрашиваемой к обмену</h2>
        Жанр:
        <select name="desired_genre">
                <option value="Фантастика">Фантастика</option>
                <option value="Роман">Роман</option>
                <option value="Мистика">Мистика</option>
            <option value="Детектив">Детектив</option>
            </select><br>
        Состояние книги: 
        <select name="desired_condition">
            <option value="не имеет значения">Не имеет значения</option>
            <option value="новое">Новое</option>
            <option value="отличное">Отличное</option>
            <option value="хорошее">Хорошее</option>
            <option value="удовлетворительное">Удовлетворительное</option>
        </select><br>
        Другие характеристики: <textarea name="desired_other"></textarea><br>

        <input type="checkbox" id="agreeCheckbox" name="agree" required> Подтверждаю правильность введенных данных и согласие на обмен<br>
        <input type="submit" class="btn" id="submitButton" value="Отправить запрос" disabled>

        <script>
        const checkbox = document.getElementById('agreeCheckbox');
        const submitButton = document.getElementById('submitButton');
        
        checkbox.addEventListener('change', function() {
            submitButton.disabled = !this.checked;
        });
        </script>
    </form>
    <footer>
        <p>Контактная информация:<br>
        Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)<br>
        Наш режим работы: Понедельник - Воскресенье: 10:00 – 18:00<br>
        Электронная почта: <a href="mailto:BooksForExchange@gmail.com">Напишите нам!</a></p>
    </footer>
</body>
</html>