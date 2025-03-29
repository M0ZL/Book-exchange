<?php
    session_start();
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $patronymic = $_POST['patronymic'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
?>

<!DOCTYPE HTML>
<html>
<head>
<meta content="charset=utf-8">
<link rel="icon" type="image/png" sizes="32x32" href="images/ico.png">
<title>Регистрация</title>
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
    .btn-default {
        background-color: #ccc;
        color: #333;
        border: none;
        cursor: pointer;
    }
    .btn-default:hover {
        background-color: #bbb;
    }
    .order-panel {
        background-color: #444;
        color: #fff;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        padding: 15px 27px 15px 15px; /* Отступы: верх, право, низ, лево */
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
        background-color:rgb(49, 49, 49);
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .order-panel input[type="submit"]:hover {
        background-color:rgb(49, 49, 49);
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
<img src="images/GamerGIF_PORNO.gif" alt="Анимация" class="fixed-gif">
<div class="container">
    <h2 align="center">Регистрация</h2>
    <form action="Registration.php" method="post" name="registrationForm" id="registrationForm" onsubmit="return validateForm()">
        <div class="order-panel" id="formContainer">
            <label for="login">Ваш логин (ник): </label><br>
            <input type="text" value="<?php echo @$login; ?>" name="login" size="20" step="any" required><br><br>
            <label for="pass">Ваш пароль: </label><br>
            <input type="password" value="<?php echo @$pass; ?>" name="pass" size="20" step="any" required><br><br>
            <label for="pass2">Повторный пароль: </label><br>
            <input type="password" value="<?php echo @$pass2; ?>" name="pass2" size="20" step="any" required><br><br>
            <label for="surname">Фамилия:</label><br>
            <input type="text" value="<?php echo @$surname; ?>" name="surname" size="20" step="any" required><br><br>
            <label for="name">Имя: </label><br>
            <input type="text" value="<?php echo @$name; ?>" name="name" size="20" step="any" required><br><br>
            <label for="patronymic">Отчество: </label><br>
            <input type="text" value="<?php echo @$patronymic; ?>" name="patronymic" size="20" step="any"><br><br>
            <label for="age">Возраст:</label><br>
            <input type="text" value="<?php echo @$age; ?>" name="age" size="20" step="any" required><br><br>
            <label for="address">Адрес:</label><br>
            <input type="text" value="<?php echo @$address; ?>" name="address" size="20" step="any"><br><br>
            <label for="email">Ваша эл. почта: </label><br>
            <input type="email" value="<?php echo @$email; ?>" name="email" size="20" step="any" required><br><br>
            <label for="email">Телефон: </label><br>
            <input type="tel" value="<?php echo @$tel; ?>" name="tel" size="20" step="any" required><br><br>
            <input type="submit" class="btn" value="Зарегистрироваться"><br><br>
            <div align="center">
            <input type="reset" class="btn btn-default" value="Очистить данные">
            </div>
        </div>
        <div align="center">
            <a href="index.php" class="btn">На главную страницу</a>
        </div>
    </form>
    <?php
        $dbuser = 'mysql';
        $dbpass = 'mysql';
        $dbserver = 'localhost';
        $dbname = 'book';
        $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
        or die ('Ошибка ' . mysqli_error($mysql));
        
        $errors = [];
        
        if (trim($login) == '') {
            $errors[] = 'Введите логин (ник)!';
        }
        
        $r = mysqli_query($mysql, "SELECT * FROM `пользователи` WHERE `ник_пользователя` = '$login'");
        if (mysqli_num_rows($r) > 0) {
            $errors[] = 'Данный логин уже зарегистрирован!';
        }
        
        if ($pass == '') {
            $errors[] = 'Введите пароль!';
        }
        
        if ($pass2 != $pass) {
            $errors[] = 'Повторный пароль введен неверно!';
        }
        
        if (trim($surname) == '') {
            $errors[] = 'Введите фамилию!';
        } elseif (!preg_match('/^[а-яА-ЯёЁa-zA-Z\s\-]+$/u', $surname)) {
            $errors[] = 'Фамилия не должна содержать цифр или специальных символов!';
        }
        
        if (trim($name) == '') {
            $errors[] = 'Введите имя!';
        } elseif (!preg_match('/^[а-яА-ЯёЁa-zA-Z\s\-]+$/u', $name)) {
            $errors[] = 'Имя не должно содержать цифр или специальных символов!';
        }
        
        if (trim($patronymic) == '') {
            $errors[] = 'Введите отчество!';
        } elseif (!preg_match('/^[а-яА-ЯёЁa-zA-Z\s\-]+$/u', $patronymic)) {
            $errors[] = 'Отчество не должно содержать цифр или специальных символов!';
        }
        
        if (trim($age) == '') {
            $errors[] = 'Введите возраст!';
        } elseif (!is_numeric($age) || $age <= 0 || $age > 120) {
            $errors[] = 'Возраст не может быть отрицательным или слишком большим (допустимо от 1 до 120 лет)!';
        }
        
        if (trim($email) == '') {
            $errors[] = 'Введите эл. почту!';
        }
        
        $e = mysqli_query($mysql, "SELECT * FROM `пользователи` WHERE `электронная_почта` = '$email'");
        if (mysqli_num_rows($e) > 0) {
            $errors[] = 'Данная эл. почта уже зарегистрирована!';
        }
        
        if (trim($tel) == '') {
            $errors[] = 'Введите номер телефона!';
        } elseif (!preg_match('/^\+79\d{9}$/', $tel)) {
            $errors[] = 'Телефон должен соответствовать формату: +79XXXXXXXXX (11 цифр, начинается с +79)!';
        }
        
        if (!empty($_POST)) {
            if (empty($errors)) {
                // Используем подготовленные выражения для безопасности
                $query = $mysql->prepare("INSERT INTO `пользователи` (фамилия, имя, отчество, возраст, адрес, электронная_почта, телефон, роль, пароль, ник_пользователя) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, 'участник', ?, ?)");
                $query->bind_param("sssisssss", $surname, $name, $patronymic, $age, $address, $email, $tel, $pass, $login);
                $query->execute();
        
                if ($query) {
                    echo '<div id="formContainer" style="color: green;"> Вы успешно зарегистрированы!<br>
                    Можете перейти на <a href="Entry.php">страницу авторизации!</a></div><hr>';
                } else {
                    echo '<div id="formContainer" style="color: red;">Ошибка при регистрации: ' . mysqli_error($mysql) . '</div><hr>';
                }
            } else {
                foreach ($errors as $error) {
                    echo '<div style="color: red;">' . $error . '</div>';
                }
            }
        }
        
        $login = mysqli_real_escape_string($mysql, $_POST['login']);
        $pass = mysqli_real_escape_string($mysql, $_POST['pass']);
        $pass2 = mysqli_real_escape_string($mysql, $_POST['pass2']);
        $surname = mysqli_real_escape_string($mysql, $_POST['surname']);
        $name = mysqli_real_escape_string($mysql, $_POST['name']);
        $patronymic = mysqli_real_escape_string($mysql, $_POST['patronymic']);
        $age = mysqli_real_escape_string($mysql, $_POST['age']);
        $address = mysqli_real_escape_string($mysql, $_POST['address']);
        $email = mysqli_real_escape_string($mysql, $_POST['email']);
        $tel = mysqli_real_escape_string($mysql, $_POST['tel']);
        
        mysqli_close($mysql);
    ?>
    <script>
    function validateForm() {
        var tel = document.forms["registrationForm"]["tel"].value;
        var telPattern = /^\+79\d{9}$/;
        if (!telPattern.test(tel)) {
            alert("Номер телефона должен быть в формате +79XXXXXXXXX (11 цифр)!");
            return false;
        }

        var form = document.getElementById('registrationForm');
        var formData = new FormData(form);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Обновляем содержимое контейнера
                document.getElementById('formContainer').innerHTML = xhr.responseText;
            } else {
                alert('Произошла ошибка при отправке формы.');
            }
        };
        xhr.onerror = function () {
            alert('Произошла ошибка при отправке формы.');
        };
        xhr.send(formData);

        return false; 
        }
    </script>
</div>
<footer>
    <p>Контактная информация:</p>
    <p>Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)</p>
    <p>Наш режим работы: Понедельник – Воскресенье: 10:00 – 18:00</p>
    <p>Электронная почта: <a href="mailto:BooksForExchange@gmail.com">Напишите нам!</a></p>
</footer>
</body>
</html>