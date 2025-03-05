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
   // $nickname = $_POST['nickname'];
    $email = $_POST['email'];   
?>

<!DOCTYPE HTML>
<html>
<head>
<meta content="charset=utf-8">
<title>Регистрация</title>
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
        margin-top: 20px;
    }
</style>
</head>
<body>
<header>
    <img src="images/logobooks.png" alt="Логотип" width="300" height="300">
</header>
<div class="container">
    <h2 align="center">Регистрация</h2>
    <form action="Registration.php" method="post">
        <div class="order-panel">
            <label for="login">Ваш логин: </label><br>
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
            <input type="text" value="<?php echo @$patronymic; ?>" name="patronymic" size="20" step="any" required><br><br>
            <label for="age">Возраст:</label><br>
            <input type="text" value="<?php echo @$age; ?>" name="age" size="20" step="any" required><br><br>
            <label for="address">Адрес (страна, город, улица, номер дома):</label><br>
            <input type="text" value="<?php echo @$address; ?>" name="address" size="20" step="any"><br><br>
            <label for="email">Ваша эл. почта: </label><br>
            <input type="email" value="<?php echo @$email; ?>" name="email" size="20" step="any" required><br><br>
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
        $errors =  array();
        if(trim($login) == ''){
            $errors[]= 'Введите логин!';
        }
        $r = mysqli_query($mysql,"SELECT * FROM `users` WHERE `login`= '$login'");

        if(mysqli_num_rows($r) > 0) {
            $errors[]= 'Данный логин уже зарегистрирован!';
        }
        if($pass == ''){
            $errors[]= 'Введите пароль!';
        }
        if($pass2 != $pass){
            $errors[]= 'Повторный пароль введен неверно!';
        }
        if(trim($surname) == ''){
            $errors[]= 'Введите фамилию!';
        }
        if(trim($name) == ''){
            $errors[]= 'Введите имя!';
        }
        if(trim($patronymic) == ''){
            $errors[]= 'Введите отчество!';
        }
        if(trim($age) == ''){
            $errors[]= 'Введите возраст!';
        }
        if(trim($email) == ''){
            $errors[]= 'Введите эл. почту!';
        }
        $e = mysqli_query($mysql,"SELECT * FROM `users` WHERE `email`= '$email'");

        if(mysqli_num_rows($e) > 0) {
            $errors[]= 'Данная эл. почта уже зарегистрирована!';
        }
        
        if(isset($login) && isset($pass) && isset($pass2) && isset($surname) && isset($name) && isset($patronymic) && isset($age) && isset($email) && isset($address)){
            if(empty($errors)){
                $query1 = mysqli_query($mysql, "INSERT INTO `users`(first_name, last_name, middle_name, age, address, email, password, login) 
                values ('$name','$surname','$patronymic','$age','$address','$email','$pass','$login')");
                echo '<div style="color: green;"> Вы успешно зарегистрированы!<br>
                Можете перейти на <a href="Entry.php">страницу авторизации!</a></div><hr>';
            } else{
                echo '<div style="color: red;">'. array_shift($errors) .'</div><hr>';
            }
        }
        mysqli_close($mysql);
    ?>
</div>
<footer>
    <p>Контактная информация:</p>
    <p>Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)</p>
    <p>Наш режим работы: Понедельник – Воскресенье: 10:00 – 18:00</p>
    <p>Электронная почта: <a href="mailto:BooksForExchange@gmail.com">Напишите нам!</a></p>
</footer>
</body>
</html>