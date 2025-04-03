<?php
session_start(); // Запускаем сессию

// Подключение к базе данных
$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
or die ('Ошибка ' . mysqli_error($mysql));

$user_id = $_SESSION['пользователь_id'];

// Получаем данные о текущем пользователе
$query = mysqli_query($mysql, "SELECT * FROM пользователи WHERE пользователь_id = $user_id");
$user = mysqli_fetch_assoc($query);

// Получаем список всех книг, кроме тех, которые добавлены текущим пользователем
$queryAllBooks = mysqli_query($mysql, "SELECT * FROM книги WHERE пользователь_id != $user_id");
$allBooks = mysqli_fetch_all($queryAllBooks, MYSQLI_ASSOC);

// Получаем список книг текущего пользователя
$queryUserBooks = mysqli_query($mysql, "SELECT * FROM книги WHERE пользователь_id = $user_id");
$userBooks = mysqli_fetch_all($queryUserBooks, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" sizes="32x32" href="images/ico.png">
    <title>Создание заявки на обмен книгами</title>
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
            width: 98%;
            padding: 8px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .order-panel input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color:rgb(46, 44, 44);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .order-panel input[type="submit"]:hover {
            background-color:rgb(46, 44, 44);
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
    </style>
</head>
<body>
    <header>
        <img src="images/l.png" alt="Логотип">
        <img src="images/logobooks.png" alt="Логотип">
        <img src="images/r.png" alt="Логотип">
    </header>
    
    <div class="container">
        <h1>Создание заявки на обмен книгами</h1>

        <script>
            function validateForm() {
                const bookId = document.getElementById('bookId').value;
                const userBookId = document.getElementById('userBookId').value;
                const userName = document.getElementById('userName').value;
                const userEmail = document.getElementById('userEmail').value;
                const userPhone = document.getElementById('userPhone').value;

                if (bookId.trim() === "") {
                    alert("Пожалуйста, выберите книгу для обмена.");
                    return false;
                }

                if (userBookId.trim() === "") {
                    alert("Пожалуйста, выберите свою книгу для обмена.");
                    return false;
                }

                if (userName.trim() === "") {
                    alert("Пожалуйста, введите ваше имя.");
                    return false;
                }

                if (!validateEmail(userEmail)) {
                    alert("Пожалуйста, введите корректный email.");
                    return false;
                }

                if (!validatePhone(userPhone)) {
                    alert("Пожалуйста, введите корректный номер телефона.");
                    return false;
                }

                return true;
            }

            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(String(email).toLowerCase());
            }

            function validatePhone(phone) {
                const re = /^\+79\d{9}$/; // Проверяет формат +7, затем 9, и еще 9 цифр
                return re.test(String(phone));
            }
        </script>

        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Получаем данные из формы
                $bookId = htmlspecialchars($_POST['bookId']);
                $userBookId = htmlspecialchars($_POST['userBookId']);
                $userName = htmlspecialchars($_POST['userName']);
                $userEmail = htmlspecialchars($_POST['userEmail']);
                $userPhone = htmlspecialchars($_POST['userPhone']);

                // Вставка заявки в таблицу `заявки_на_обмен` с текущей датой
                    $query = "INSERT INTO заявки_на_обмен (пользователь_id, книга_id, параметры_поиска, статус, дата_создания) 
                    VALUES ($user_id, $bookId, 'Обмен книги $userBookId на книгу $bookId', 'ожидание', NOW())";
                if (mysqli_query($mysql, $query)) {
                    // Получаем ID последней вставленной заявки
                    $заявка_id = mysqli_insert_id($mysql);

                    // Генерация случайного трек-номера из 14 цифр
                    $трек_номер = mt_rand(10000000000000, 99999999999999);

                    // Вставка данных в таблицу `обмены` с текущей датой
                    $query = "INSERT INTO обмены (заявка_id, предложенная_книга_id, трек_номер, статус, дата_создания) 
                            VALUES ($заявка_id, $userBookId, '$трек_номер', 'ожидание', NOW())";
                    if (mysqli_query($mysql, $query)) {
                        // Обновляем рейтинг пользователя
                        $updateRatingQuery = "UPDATE пользователи SET рейтинг = рейтинг + 1 WHERE пользователь_id = $user_id";
                        if (mysqli_query($mysql, $updateRatingQuery)) {
                            echo "<div class='alert-success'>Спасибо, $userName! Ваша заявка на обмен книги принята. Трек-номер: $трек_номер. Ваш рейтинг увеличен на 1 очко.</div>";
                        } else {
                            echo "<div class='alert-error'>Ошибка при обновлении рейтинга: " . mysqli_error($mysql) . "</div>";
                        }
                    } else {
                        echo "<div class='alert-error'>Ошибка: " . mysqli_error($mysql) . "</div>";
                    }
                }
            }
        ?>

        <div class="order-panel">
            <form action="" method="post" onsubmit="return validateForm()">
                <label for="bookId">Название книги:</label>
                <select id="bookId" name="bookId" required>
                    <?php foreach ($allBooks as $book): ?>
                        <option value="<?= $book['книга_id'] ?>"><?= $book['название'] ?></option>
                    <?php endforeach; ?>
                </select><br><br>

                <label for="userBookId">Предложите свою книгу:</label>
                <select id="userBookId" name="userBookId" required>
                    <?php foreach ($userBooks as $book): ?>
                        <option value="<?= $book['книга_id'] ?>"><?= $book['название'] ?></option>
                    <?php endforeach; ?>
                </select><br><br>

                <label for="userName">Ваше имя:</label>
                <input type="text" id="userName" name="userName" value="<?= $user['имя'] ?>" required><br><br>

                <label for="userEmail">Ваш email:</label>
                <input type="email" id="userEmail" name="userEmail" value="<?= $user['электронная_почта'] ?>" required><br><br>

                <label for="userPhone">Ваш телефон:</label>
                <input type="tel" id="userPhone" name="userPhone" value="<?= $user['телефон'] ?>" required><br><br>

                <input type="submit" class="btn" value="Отправить заявку">
            </form><br>
            <div align="center">
                <a href="Profile.php" class="btn">Назад</a><br><br>
            </div>
            <div align="center">
                <a href="index.php" class="btn">На главную страницу</a>
            </div>
        </div>
    </div>
    <footer>
        <p>Контактная информация:</p>
        <p>Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)</p>
        <p>Наш режим работы: Понедельник – Воскресенье: 10:00 – 18:00</p>
        <p>Электронная почта: <a href="mailto:BooksForExchange@gmail.com">Напишите нам!</a></p>
    </footer>
</body>
</html>