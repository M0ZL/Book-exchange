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
    $nickname = $_POST['nickname'];
    $email = $_POST['email']; 
?>

<!DOCTYPE HTML>
<html>
<head>
<meta content="charset=utf-8">
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
</style>
</head>
<body>
<header>
    <img src="images/l.png" alt="Логотип">
    <img src="images/logobooks.png">
    <img src="images/r.png" alt="Логотип">
    <h1>Редактирование профиля</h1>
</header>

<div class="container">
    <?php
        $dbuser = 'mysql';
        $dbpass = 'mysql';
        $dbserver = 'localhost';
        $dbname = 'book';
        $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
        or die ('Ошибка ' . mysqli_error($mysql));
        $errors =  array();
        if(isset($_SESSION['log_user'])){
            echo "<p>" . $_SESSION['log_user'] . "</p>";
           
            if(isset($login) && isset($pass) && isset($pass2) && isset($pass3) && isset($surname) && isset($name) && isset($patronymic) 
            && isset($age) && isset($address) && isset($email)){
                $p = mysqli_query($mysql,"SELECT * FROM `users` WHERE `password`= '$pass'");

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
                    $query1 = mysqli_query($mysql, "UPDATE `users` SET last_name = '$surname', first_name = '$name', middle_name = '$patronymic', age = '$age', 
                    email = '$email', login ='$login', password = '$pass2', address = '$address' Where password = '$pass'");
                    echo '<div class="success">Вы успешно отредактировали свои данные!</div><hr>';
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