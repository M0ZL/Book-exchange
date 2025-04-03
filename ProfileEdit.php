<?php
    session_start();
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    $pass3 = $_POST['pass3'];
    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $patronymic = $_POST['patronymic'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    //$nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];

    if (isset($_POST['pass2']) && $_POST['pass2'] === $_POST['pass3']) {
    
        // Обновляем пароль в сессии
        $_SESSION['user_pass'] = $pass2;
    
        // Обновляем куки, если "Запомнить меня" выбрано
        if (isset($_SESSION['remember_me']) && $_SESSION['remember_me'] === true) {
            setcookie('pass', $pass2, time() + 60 * 60 * 24 * 30, '/');
        }
    }

?>

<!DOCTYPE HTML>
<html>
<head>
<meta content="charset=utf-8">
<link rel="icon" type="image/png" sizes="32x32" href="images/ico.png">
<title>Редактирование профиля</title>
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
    .error {
        color: red;
        margin-bottom: 10px;
    }
    .success {
        color: green;
        margin-bottom: 10px;
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
    <img src="images/logobooks.png">
    <img src="images/r.png" alt="Логотип">
</header>

<div class="container">
<h1 align = "center">Редактирование профиля</h1>
    <?php
        $dbuser = 'mysql';
        $dbpass = 'mysql';
        $dbserver = 'localhost';
        $dbname = 'book';
        $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
        or die ('Ошибка ' . mysqli_error($mysql));
    
        $id = $_SESSION['пользователь_id'];     

        // Запрос для получения роли пользователя
        $query = "SELECT роль FROM пользователи WHERE пользователь_id = '$id'";
        $result = mysqli_query($mysql, $query) or die(mysqli_error($mysql));

        if ($user = mysqli_fetch_assoc($result)) {
            $_SESSION['роль'] = $user['роль']; // Сохраняем роль в сессии
        }

        $errors =  array();
        if(isset($_SESSION['log_user'])){
            echo "<h3>Вы вошли как: " . $_SESSION['роль'] . "</h3>"; // Отображаем роль пользователя
            echo "<p>" . $_SESSION['log_user'] . "</p>";
            
           
            if(isset($login) && isset($pass) && isset($pass2) && isset($pass3) && isset($surname) && isset($name) && isset($patronymic) 
            && isset($age) && isset($address) && isset($email) && isset($tel)){
                $p = mysqli_query($mysql,"SELECT * FROM `пользователи` WHERE `пользователь_id`= '$id'");

                if(mysqli_num_rows($p) == 0) {
                    $errors[]= 'Текущий пароль введен неверно!';
                }
                if($pass == ''){
                    $errors[]= 'Введите пароль!';
                }
                if(!empty($pass3)){
                    if($pass2 != $pass3){
                        $errors[]= 'Подтвержденный пароль введен неверно!';
                    }
                }
            
                if(empty($errors)){
                    $query1 = mysqli_query($mysql, "UPDATE `пользователи` SET 
                        `фамилия` = '$surname', 
                        `имя` = '$name', 
                        `отчество` = '$patronymic', 
                        `возраст` = '$age', 
                        `электронная_почта` = '$email', 
                        `ник_пользователя` = '$login', 
                        `пароль` = '$pass2', 
                        `адрес` = '$address', 
                        `телефон` = '$tel' 
                        WHERE `пользователь_id`= '$id'");
                    
                    if($query1) {
                        echo '<div class="success">Вы успешно отредактировали свои данные!</div><hr>';
                    } else {
                        echo '<div class="error">Ошибка при обновлении данных!</div><hr>';
                    }
                } else{
                    echo '<div class="error">'. array_shift($errors) .'</div><hr>';
                }
            }
            
        }
        mysqli_close($mysql);
    ?>
    <div align="center">
        <a href="Profile.php" class="btn">Назад</a><br><br>
        <a href="index.php" class="btn">На главную страницу</a><br><br>
        <p style="color: red;">Для обновления данных на странице «Профиль» необходимо перезайти!</p>
        <a href="Logout.php" class="btn">Выйти из аккаунта</a></br></br>
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