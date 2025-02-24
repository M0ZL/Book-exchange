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
    $nickname = $_POST['nickname'];
    $email = $_POST['email'];   
?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<meta  content="charset=utf-8">
<title>Регистрация</title>
<style type="text/css">
  </style>
</head>
<body background="images/background.jpg">
<p align=center><img width="600" height="340" src="images/logobooks.png" /></p>
<h2 align=center>Регистрация</h2>
<div class='container'>
	<form action="Registration.php" method="post"><div align=center><div class='form-group'>
<div class='form-group'>
 <label for="login">Ваш логин: </label></br><input type = "text" value="<?php echo @$login; ?>"
 name="login" size="20" step="any" required></br></br></div><div class='form-group'>
 <label for="pass">Ваш пароль: </label></br><input type = "password" value="<?php echo @$pass; ?>"
 name="pass" size="20" step="any" required></br></br></div><div class='form-group'>
 <label for="pass2">Повторный пароль: </label></br><input type = "password" value="<?php echo @$pass2; ?>"
 name="pass2" size="20" step="any" required></br></br></div><div class='form-group'>
 <label for="surname">Фамилия:</label></br><input type = "text" value="<?php echo @$surname; ?>"
 name="surname" size="20" step="any" required></br></br></div><div class='form-group'>
 <label for="name">Имя: </label></br><input type = "text" value="<?php echo @$name; ?>"
 name="name" size="20" step="any" required></br></br></div><div class='form-group'>
 <label for="patronymic">Отчество: </label></br><input type = "text" value="<?php echo @$patronymic; ?>"
 name="patronymic" size="20" step="any" required></br></br></div><div class='form-group'>
 <label for="age">Возраст:</label></br><input type = "text" value="<?php echo @$age; ?>"
 name="age" size="20" step="any" required></br></br></div><div class='form-group'>
 <label for="address">Адрес (страна, город, улица, номер дома):</label></br><input type = "text" value="<?php echo @$address; ?>"
 name="address" size="20" step="any"></br></br></div><div class='form-group'>
 <label for="email">Ваша эл. почта: </label></br><input type = "email" value="<?php echo @$email; ?>"
 name="email" size="20" step="any" required></br></br></div><div class='btn-group'>
<input type="submit" class='btn btn-primary' style="width:160px"
value="Зарегистрироваться">
<input type="reset" class='btn btn-default' style="width:140px" value="Очистить данные"> <br></div>
<div align="center"><input type="button"  onclick="window.location.href = 'index.php';" class="btn btn-link"  value="На главную страницу"><br><br></div></div>
</div></form>
<?php
    $dbuser = 'mysql';
    $dbpass = 'mysql';
    $dbserver = 'localhost';
    $dbname = '';
    $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
    or die ('Ошибка ' . mysqli_error($mysql));
    $errors =  array();
    if(trim($login) == ''){
        $errors[]= 'Введите логин!';
    }
    $r = mysqli_query($mysql,"SELECT * FROM `visitors` WHERE `Login`= '$login'");

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
    $e = mysqli_query($mysql,"SELECT * FROM `visitors` WHERE `Email`= '$email'");

    if(mysqli_num_rows($e) > 0) {
        $errors[]= 'Данная эл. почта уже зарегистрирована!';
    }
    
    if(isset($login) && isset($pass) && isset($pass2) && isset($surname) && isset($name) && isset($patronymic) && isset($age) && isset($email) && isset($address)){
        if(empty($errors)){
            $query1 = mysqli_query($mysql, "INSERT INTO `visitors`(IsAdmin, Surname, Name, Patronymic, Age, Email, Login, Password, Address) 
            values ('0','$surname','$name','$patronymic','$age','$email','$login','$pass', '$address')");
            echo '<div style="color: green;"> Вы успешно зарегистрированы!<br>
            Можете перейти на <a href="Entry.php">страницу авторизации!</a></div><hr>';
        } else{
            echo '<div style="color: red;">'. array_shift($errors) .'</div><hr>';
        }
    }
    mysqli_close($mysql);
?>
<p align=center>Контактная информация:</br>
   Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)</br>
   Наш режим работы:</br>
	Понедельник:
	10:00 – 18:00</br>
	Вторник:
	10:00 – 18:00</br>
	Среда:
	10:00 – 18:00</br>
	Четверг:
	10:00 – 18:00</br>
	Пятница:
	10:00 – 18:00</br>
	Суббота:
	10:00 – 18:00</br>
	Воскресенье:
	10:00 – 18:00</br>
   <a href = 'index.php'><button type='button' class='btn btn-link' >Вакансии</button></a></br>
	<a href = 'index.php'><button type='button' class='btn btn-link' >Политика конфиденциальности</button></a></br>
	Электронная почта:
    <a href="mailto:BooksForExchange@gmail.com"><span class="glyphicon glyphicon-envelope"></span> Напишите нам!</a>
	</p>
</body>
</html>