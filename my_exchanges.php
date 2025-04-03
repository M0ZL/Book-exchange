<?php
session_start();
if (!isset($_SESSION['пользователь_id'])) {
    die("Требуется авторизация");
}

$user_id = $_SESSION['пользователь_id'];

// Подключение к базе данных
$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}

// Получение предложенных обменов (где текущий пользователь - сторона А)
$query_proposed = "
    SELECT 
        п.предложение_id, п.запрос_id, п.книга_id, п.подтверждение,
        п.трек_номер_а, п.трек_номер_б,
        п.доставка_подтверждена_а, п.доставка_подтверждена_б,
        п.сторона_б,
        к.название AS offered_book_name,
        ю.ник_пользователя AS сторона_б_ник,
        ю.адрес AS адрес_стороны_б
    FROM предложения_на_обмен п
    JOIN книги к ON п.книга_id = к.книга_id
    JOIN пользователи ю ON п.сторона_б = ю.пользователь_id
    WHERE п.сторона_а = ? AND п.статус_завершения = FALSE
";

$stmt_proposed = $mysql->prepare($query_proposed);
if (!$stmt_proposed) {
    die("Ошибка подготовки запроса: " . $mysql->error);
}

$stmt_proposed->bind_param("i", $user_id);
$stmt_proposed->execute();
$result_proposed = $stmt_proposed->get_result();

// Получение полученных обменов (где текущий пользователь - сторона Б)
$query_received = "
    SELECT 
        п.предложение_id, п.запрос_id, п.книга_id, п.подтверждение,
        п.трек_номер_а, п.трек_номер_б,
        п.доставка_подтверждена_а, п.доставка_подтверждена_б,
        п.сторона_а,
        к.название AS offered_book_name,
        ю.ник_пользователя AS сторона_а_ник,
        ю.адрес AS адрес_стороны_а
    FROM предложения_на_обмен п
    JOIN книги к ON п.книга_id = к.книга_id
    JOIN пользователи ю ON п.сторона_а = ю.пользователь_id
    WHERE п.сторона_б = ? AND п.статус_завершения = FALSE
";

$stmt_received = $mysql->prepare($query_received);
if (!$stmt_received) {
    die("Ошибка подготовки запроса: " . $mysql->error);
}

$stmt_received->bind_param("i", $user_id);
$stmt_received->execute();
$result_received = $stmt_received->get_result();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" sizes="32x32" href="images/ico.png">
    <title>Мои обмены</title>
    <style>
        .shipping-instruction {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-bottom: 20px;
        }
        .exchange-item {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
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
    
        <div align="center">
                <a href="index.php" class="btn">На главную</a>
                <a href="Profile.php" class="btn">Личный аккаунт</a>
        </div>
    <div class="container">
    <h1>Мои обмены</h1>

    <h2>Предложенные обмены</h2>
    <?php if ($result_proposed && $result_proposed->num_rows > 0): ?>
        <?php while ($row = $result_proposed->fetch_assoc()): ?>
            <div class="exchange-item">
                <h3><?= htmlspecialchars($row['offered_book_name']) ?></h3>
                <p><strong>Получатель:</strong> <?= htmlspecialchars($row['сторона_б_ник']) ?></p>
                <p><strong>Статус:</strong> <?= $row['подтверждение'] ? 'Подтвержден' : 'Ожидание' ?></p>
                
                <?php if ($row['подтверждение']): ?>
                    <?php if (empty($row['трек_номер_а'])): ?>
                        <div class="shipping-instruction">
                            <h4>Инструкция по отправке:</h4>
                            <ol>
                                <li>Отнесите книгу в ближайшее отделение "Почты России"</li>
                                <li>Отправьте на адрес: <?= htmlspecialchars($row['адрес_стороны_б']) ?></li>
                                <li>После отправки введите трек-номер:</li>
                            </ol>
                            <form method="POST" action="track_delivery.php">
                                <input type="text" name="track_number" required>
                                <input type="hidden" name="offer_id" value="<?= $row['предложение_id'] ?>">
                                <button type="submit">Отправить трек-номер</button>
                            </form>
                        </div>
                    <?php elseif (empty($row['трек_номер_б'])): ?>
                        <p>Ожидание трек-номера от получателя.</p>
                    <?php else: ?>
                        <p><strong>Ваш трек-номер:</strong> <?= htmlspecialchars($row['трек_номер_а']) ?></p>
                        <p><strong>Трек-номер получателя:</strong> <?= htmlspecialchars($row['трек_номер_б']) ?></p>
                        <?php if (!$row['доставка_подтверждена_а']): ?>
                            <form method="POST" action="confirm_delivery.php" id="deliveryForm">
                                <input type="hidden" name="offer_id" value="<?= $row['предложение_id'] ?>">
                                <button type="button" onclick="showReviewModal()">Подтвердить получение</button>
                            </form>

                            <!-- Модальное окно для отзыва -->
                            <div id="reviewModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:white; padding:20px; z-index:1000; border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,0.1);">
                                <h3>Напишите отзыв</h3>
                                <form id="reviewForm" method="POST" action="save_review.php">
                                    <input type="hidden" name="offer_id" value="<?= $row['предложение_id'] ?>">
                                    <textarea name="комментарий" rows="5" cols="40" required></textarea><br><br>
                                    Оценка:
                                    <select name="оценка">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="4">5</option>
                                    </select><br>
                                    <button type="submit">Отправить</button>
                                    <button type="button" onclick="closeModal()">Отказаться</button>
                                </form>
                            </div>
                            <div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;"></div>

                            <script>
                            function showReviewModal() {
                                document.getElementById('reviewModal').style.display = 'block';
                                document.getElementById('overlay').style.display = 'block';
                            }

                            function closeModal() {
                                document.getElementById('reviewModal').style.display = 'none';
                                document.getElementById('overlay').style.display = 'none';
                                // Отправляем форму подтверждения получения
                                document.getElementById('deliveryForm').submit();
                            }
                            </script>
                        <?php else: ?>
                            <p>Ожидание подтверждения от получателя.</p>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Ожидание подтверждения от получателя.</p>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>У вас нет предложенных обменов.</p>
    <?php endif; ?>

    <h2>Полученные обмены</h2>
    <?php if ($result_received && $result_received->num_rows > 0): ?>
        <?php while ($row = $result_received->fetch_assoc()): ?>
            <div class="exchange-item">
                <h3><?= htmlspecialchars($row['offered_book_name']) ?></h3>
                <p><strong>Отправитель:</strong> <?= htmlspecialchars($row['сторона_а_ник']) ?></p>
                <p><strong>Статус:</strong> <?= $row['подтверждение'] ? 'Подтвержден' : 'Ожидание' ?></p>
                
                <?php if (!$row['подтверждение']): ?>
                    <div>
                        <a href="confirm_exchange.php?offer_id=<?= $row['предложение_id'] ?>&action=confirm">Принять обмен</a> | 
                        <a href="confirm_exchange.php?offer_id=<?= $row['предложение_id'] ?>&action=reject">Отклонить обмен</a>
                    </div>
                <?php else: ?>
                    <?php if (empty($row['трек_номер_б'])): ?>
                        <div class="shipping-instruction">
                            <h4>Инструкция по отправке:</h4>
                            <ol>
                                <li>Отнесите книгу в ближайшее отделение "Почты России"</li>
                                <li>Отправьте на адрес: <?= htmlspecialchars($row['адрес_стороны_а']) ?></li>
                                <li>После отправки введите трек-номер:</li>
                            </ol>
                            <form method="POST" action="track_delivery.php">
                                <input type="text" name="track_number" required>
                                <input type="hidden" name="offer_id" value="<?= $row['предложение_id'] ?>">
                                <button type="submit">Отправить трек-номер</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <p><strong>Ваш трек-номер:</strong> <?= htmlspecialchars($row['трек_номер_б']) ?></p>
                        <p><strong>Трек-номер отправителя:</strong> <?= htmlspecialchars($row['трек_номер_а']) ?></p>
                        <?php if (!$row['доставка_подтверждена_б']): ?>
                            <form method="POST" action="confirm_delivery.php" id="deliveryForm">
                                <input type="hidden" name="offer_id" value="<?= $row['предложение_id'] ?>">
                                <button type="button" onclick="showReviewModal()">Подтвердить получение</button>
                            </form>

                            <!-- Модальное окно для отзыва -->
                            <div id="reviewModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:white; padding:20px; z-index:1000; border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,0.1);">
                                <h3>Напишите отзыв</h3>
                                <form id="reviewForm" method="POST" action="save_review.php">
                                    <input type="hidden" name="offer_id" value="<?= $row['предложение_id'] ?>">
                                    <textarea name="комментарий" rows="5" cols="40" required></textarea><br><br>
                                    Оценка:
                                    <select name="оценка">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="4">5</option>
                                    </select><br>
                                    <button type="submit">Отправить</button>
                                    <button type="button" onclick="closeModal()">Отказаться</button>
                                </form>
                            </div>
                            <div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;"></div>

                            <script>
                            function showReviewModal() {
                                document.getElementById('reviewModal').style.display = 'block';
                                document.getElementById('overlay').style.display = 'block';
                            }

                            function closeModal() {
                                document.getElementById('reviewModal').style.display = 'none';
                                document.getElementById('overlay').style.display = 'none';
                                // Отправляем форму подтверждения получения
                                document.getElementById('deliveryForm').submit();
                            }
                            </script>
                        <?php else: ?>
                            <p>Ожидание подтверждения от отправителя.</p>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>У вас нет полученных обменов.</p>
    <?php endif; ?>
    </div>
    <footer>
        <p>Контактная информация:<br>
        Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)<br>
        Наш режим работы: Понедельник - Воскресенье: 10:00 – 18:00<br>
        Электронная почта: <a href="mailto:BooksForExchange@gmail.com">Напишите нам!</a></p>
    </footer>
</body>
</html>
<?php
$mysql->close();
?>