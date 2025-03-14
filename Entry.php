<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
session_start();
$login = $_POST['login'];
$pass = $_POST['pass'];

$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
or die ('Ошибка ' . mysqli_error($mysql));

mysqli_close($mysql);
?>

<!DOCTYPE HTML>
<html>
<head>
<meta content="charset=utf-8">
<title>Авторизация</title>
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
        padding: 20px 30px 15px 15px; /* Отступы: верх, право, низ, лево */
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
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: inline-flex; /* Элементы внутри label будут в одной строке */
        align-items: center; /* Выравниваем по вертикали */
        white-space: nowrap; /* Запрещаем перенос текста */
    }
    .form-group input {
        width: 100%;
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .btn-primary {
        background-color:rgb(49, 49, 49);
        color: #fff;
        border: none;
        cursor: pointer;
    }
    .btn-primary:hover {
        background-color:rgb(49, 49, 49);
    }
    .btn-default {
        background-color: #ccc;
        color: #333;
        border: none;
        cursor: pointer;
    }
    .btn-default:hover {
        background-color: #bbb;
    }
    .btn-link {
        background-color: transparent;
        color: #333;
        border: none;
        cursor: pointer;
        text-decoration: underline;
    }
    .btn-link:hover {
        color: #555;
    }
    .form-actions {
        display: flex;
        flex-direction: column; /* Располагаем кнопки вертикально */
        align-items: center; /* Центрируем кнопки по горизонтали */
        gap: 10px; /* Отступ между кнопками */
        margin-top: 30px; /* Отступ сверху перед кнопками */
        margin-left: 15px; /* Отступ слева перед кнопками */
    }

    .form-actions .btn {
        width: 200px; /* Фиксированная ширина кнопок */
        text-align: center; /* Центрируем текст внутри кнопок */
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
    
    .form-group input[type="checkbox"] {
        margin-right: 10px; /* Отступ между чекбоксом и текстом */
    }
</style>
</head>
<body>
<header>
    <img src="images/l.png" alt="Логотип">
    <img src="images/logobooks.png" alt="Логотип">
    <img src="images/r.png" alt="Логотип">
    <?php if (isset($_SESSION['logged_user'])): ?>
        <a href="?logout=1" class="btn">Выйти</a>
    <?php endif; ?>
</header>
<img src="images/GamerGIF_PORNO.gif" alt="Анимация" class="fixed-gif">
<img src="images/chebyrashka.gif" alt="Анимация" class="fixed-gif1">
<div class="container">
    <h2 align="center">Войти</h2>
    <form action="Entry.php" method="post">
        <div class="form-group">
            <label for="login">Ваш логин (ник):</label>
            <input type="text" name="login" value="<?php echo isset($_COOKIE['login']) ? $_COOKIE['login'] : @$login; ?>" required>
        </div>
        <div class="form-group">
            <label for="pass">Ваш пароль:</label>
            <input type="password" name="pass" value="<?php echo isset($_COOKIE['pass']) ? $_COOKIE['pass'] : @$pass; ?>" required>
        </div>
        <div class="form-group">
            <label>
                Запомнить меня <input type="checkbox" name="remember"> 
            </label>
        </div>
        <div class="form-actions">
            <input type="submit" id="loginButton" class="btn btn-primary" value="Войти">
            <input type="reset" class="btn btn-default" value="Очистить данные">
            <a href="index.php" class="btn">На главную страницу</a>
        </div>
    </form>
</div>

<?php 
    $dbuser = 'mysql';
    $dbpass = 'mysql';
    $dbserver = 'localhost';
    $dbname = 'book';
    $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
    or die ('Ошибка ' . mysqli_error($mysql));
    if(isset($login) && isset($pass)){
        $errors= array();
        $a = mysqli_query($mysql, "SELECT * FROM `пользователи` where `ник_пользователя` = '$login' and `пароль` = '$pass'");
        
        if(mysqli_num_rows($a) > 0) {
            $_SESSION['logged_user'] = $a;
            echo '<script>location.replace("index.php");</script>';
            $errors = [];

            // Обработка выхода из системы
            if (isset($_GET['logout'])) {
                setcookie('login', '', time() - 3600, '/');
                setcookie('pass', '', time() - 3600, '/');
                session_destroy();
                header('Location: index.php');
                exit;
            }

            // Обработка формы авторизации
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login']) && isset($_POST['pass'])) {
                $login = trim($_POST['login']);
                $pass = trim($_POST['pass']);

                // Проверка на пустые поля
                if (empty($login) || empty($pass)) {
                    $errors[] = 'Логин и пароль не могут быть пустыми!';
                } else {
                    // Ищем пользователя по логину
                    $query = $mysql->prepare("SELECT * FROM `пользователи` WHERE `ник_пользователя` = ?");
                    $query->bind_param("s", $login);
                    $query->execute();
                    $result = $query->get_result();

                    if ($result && mysqli_num_rows($result) > 0) {
                        $user = mysqli_fetch_assoc($result);

                        // Проверяем пароль (без шифрования)
                        if ($pass === $user['пароль']) {
                            // Пароль верный
                            $_SESSION['logged_user'] = $user['ник_пользователя'];
                            $_SESSION['пользователь_id'] = $user['пользователь_id'];

                            // Загружаем данные пользователя в сессию
                            $_SESSION['prof_user'] = "<div>Ник пользователя: " . $user['ник_пользователя'] . "</br></br> Ваш рейтинг: " . $user['рейтинг'] . "</br></br> Дата регистрации: " . $user['дата_регистрации'] . " </br></br> Фамилия: " . $user['фамилия'] . 
                            "</br></br> Имя: " . $user['имя'] . "</br></br> Отчество: " . $user['отчество'] . "</br></br> Адрес: " . $user['адрес'] . "</br></br> Эл. почта: " . $user['электронная_почта'] . "</br></br> Возраст: " . $user['возраст'] . "</br></br> Телефон: " . $user['телефон'] . "</br></br></div>";
                            $_SESSION['log_user'] = "<div class='container'><form action='ProfileEdit.php' method='post'><div align=center><div class='form-group'>
                            <label for='login'>Ваш логин: </label></br><input type = 'text' value=". $user['ник_пользователя'] ."
                            name='login' size='20' step='any'></br></br></div><div class='form-group'>
                            <label for='pass'>Ваш текущий пароль: </label></br><input type = 'password' value=". $user['пароль'] ."
                            name='pass' size='20' step='any'></br></br></div><div class='form-group'>
                            <label for='pass2'>Новый пароль: </label></br><input type = 'password' value=". $user['пароль'] ."
                            name='pass2' size='20' step='any'></br></br></div><div class='form-group'>
                            <label for='pass3'>Подтвердите пароль: </label></br><input type = 'password'
                            name='pass3' size='20' step='any'></br></br></div><div class='form-group'>
                            <label for='surname'>Фамилия:</label></br><input type = 'text' value=". $user['фамилия'] ."
                            name='surname' size='20' step='any'></br></br></div><div class='form-group'>
                            <label for='name'>Имя: </label></br><input type = 'text' value=". $user['имя'] ."
                            name='name' size='20' step='any'></br></br></div><div class='form-group'>
                            <label for='patronymic'>Отчество: </label></br><input type = 'text' value='". $user['отчество'] ."'
                            name='patronymic' size='20' step='any'></br></br></div><div class='form-group'>
                            <label for='address'>Адрес:</label></br><input type = 'text' value='". $user['адрес'] ."'
                            name='address' size='20' step='any'></br></br></div><div class='form-group'>
                            <label for='email'>Ваша эл. почта: </label></br><input type = 'email' value=". $user['электронная_почта'] ."
                            name='email' size='20' step='any'></br></br></div><div class='form-group'>
                            <label for='age'>Возраст:</label></br><input type = 'text' value='". $user['возраст'] ."'
                            name='age' size='20' step='any'></br></br></div><div class='form-group'>
                            <label for='tel'>Телефон:</label></br><input type = 'text' value='". $user['телефон'] ."'
                            name='tel' size='20' step='any'></br></br></div><div class='btn-group'>
                            <input type='submit' class='btn btn-primary' style='width:180px'
                            value='Редактировать данные'>
                            <input type='reset' class='btn btn-default' style='width:140px' value='Очистить данные'></div> </div>
                            </form></div>";

                            // Сохранение логина и пароля в cookies, если выбрано "Запомнить меня"
                            if (isset($_POST['remember'])) {
                                setcookie('login', $login, time() + 60 * 60 * 24 * 30, '/');
                                setcookie('pass', $pass, time() + 60 * 60 * 24 * 30, '/');
                            }

                            // Перенаправление на главную страницу
                            header('Location: index.php');
                            exit;
                        } else {
                            // Пароль неверный
                            $errors[] = 'Неверный логин или пароль! g';
                            // Очистка полей ввода
                            echo '<script>document.querySelector("input[name=\'login\']").value = "";</script>';
                            echo '<script>document.querySelector("input[name=\'pass\']").value = "";</script>';
                        }
                    } else {
                        // Пользователь не найден
                        $errors[] = 'Неверный логин или пароль!';
                        // Очистка полей ввода
                        echo '<script>document.querySelector("input[name=\'login\']").value = "";</script>';
                        echo '<script>document.querySelector("input[name=\'pass\']").value = "";</script>';
                    }
                }
            }
        } else{
            $errors[] = 'Неверный логин или пароль!';
        }

        if (!empty($errors)) {
            echo '<div style="color: red;">' . array_shift($errors) . '</div><hr>';
        }
    }
    mysqli_close($mysql);
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginButton = document.getElementById('loginButton'); // Кнопка "Войти"
        const loginInput = document.querySelector('input[name="login"]'); // Поле логина
        const passInput = document.querySelector('input[name="pass"]'); // Поле пароля
        const errorMessage = document.querySelector('div[style="color: red;"]'); // Сообщение об ошибке

        // Функция для управления видимостью кнопки и сообщения об ошибке
        function handleInputChange() {
            if (errorMessage) {
                // Если поля логина или пароля изменены, удаляем сообщение об ошибке
                errorMessage.remove();
            }

            // Если оба поля не пустые, показываем кнопку
            if (loginInput.value.trim() !== '' && passInput.value.trim() !== '') {
                loginButton.style.display = 'inline-block';
            } else {
                // Если хотя бы одно поле пустое, скрываем кнопку
                loginButton.style.display = 'none';
            }
        }

        // Слушаем изменения в полях логина и пароля
        loginInput.addEventListener('input', handleInputChange);
        passInput.addEventListener('input', handleInputChange);

        // При загрузке страницы проверяем, нужно ли скрыть кнопку
        if (errorMessage) {
            loginButton.style.display = 'none'; // Скрываем кнопку, если есть ошибка
        }
    });
</script>

<footer>
    <p>Контактная информация:</p>
    <p>Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)</p>
    <p>Наш режим работы: Понедельник – Воскресенье: 10:00 – 18:00</p>
    <p>Электронная почта: <a href="mailto:BooksForExchange@gmail.com">Напишите нам!</a></p>
</footer>
</body>
</html>