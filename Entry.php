<?php
    session_start();
    $login = $_POST['login'];
    $pass = $_POST['pass'];
?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<meta  content="charset=utf-8">
<title>Авторизация</title>
<style type="text/css">
  </style>
</head>
<body background="images/background.jpg">
<p align=center><img width="600" height="340" src="images/logobooks.png" /></p>
    <h2 align=center>Войти</h2>
    <div class='container'>
	<form action="Entry.php" method="post"><div align=center><div class='form-group'>
 <label for="login">Ваш логин: </label></br><input type = "text" value="<?php echo @$login; ?>"
 name="login" size="20" step="any" required></br></br></div><div class='form-group'>
 <label for="pass">Ваш пароль: </label></br><input type = "password" value="<?php echo @$pass; ?>"
 name="pass" size="20" step="any" required></br></br></div><div class='btn-group'>
<input type="submit" class='btn btn-primary' style="width:140px"
value="Войти">
<input type="reset" class='btn btn-default' style="width:140px" value="Очистить данные"> <br>
<div align=center>
<input type="button"  onclick="window.location.href = 'index.php';" class="btn btn-link"  value="На главную страницу"><br><br></div></div></div>
</div></form>
<?php 
    $dbuser = 'mysql';
	$dbpass = 'mysql';
	$dbserver = 'localhost';
	$dbname = '';
	$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
    or die ('Ошибка ' . mysqli_error($mysql));
    if(isset($login) && isset($pass)){
        $errors= array();
        $a = mysqli_query($mysql, "SELECT * FROM `visitors` where `Login` = '$login' and `Password` = '$pass'");
        
        if(mysqli_num_rows($a) > 0) {
            $_SESSION['logged_user'] = $a;
            echo '<script>location.replace("index.php");</script>'; 
            foreach($a as $row){
                $_SESSION['acc_user'] = $row['isAdmin'];
                $_SESSION['acc_id'] = $row['id_visitor'];
                $_SESSION['prof_user'] = "<div>Логин: " . $row['Login'] . "</br></br> Пароль: " . $row['Password'] . " </br></br> Фамилия: " . $row['Surname'] . 
                "</br></br> Имя: " . $row['Name'] . "</br></br> Отчество: " . $row['Patronymic'] . " </br></br> Возраст: " . $row['Age'] . "</br></br> Адрес: " . $row['Address'] . "</br></br> Эл. почта: " . $row['Email'] . "</br></br></div>";
                $_SESSION['log_user'] = "<div class='container'><form action='ProfileEdit.php' method='post'><div align=center><div class='form-group'>
                <label for='login'>Ваш логин: </label></br><input type = 'text' value=". $row['Login'] ."
                name='login' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='pass'>Ваш текущий пароль: </label></br><input type = 'password' value=". $row['Password'] ."
                name='pass' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='pass2'>Новый пароль: </label></br><input type = 'password' value=". $row['Password'] ."
                name='pass2' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='pass3'>Подтвердите пароль: </label></br><input type = 'password'
                name='pass3' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='surname'>Фамилия:</label></br><input type = 'text' value=". $row['Surname'] ."
                name='surname' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='name'>Имя: </label></br><input type = 'text' value=". $row['Name'] ."
                name='name' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='patronymic'>Отчество: </label></br><input type = 'text' value=". $row['Patronymic'] ."
                name='patronymic' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='age'>Возраст:</label></br><input type = 'text' value=". $row['Age'] ."
                name='age' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='address'>Адрес (страна, город, улица, номер дома):</label></br><input type = 'text' value='". $row['Address'] ."'
                name='address' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='email'>Ваша эл. почта: </label></br><input type = 'email' value=". $row['Email'] ."
                name='email' size='20' step='any'></br></br></div><div class='btn-group'>
                <input type='submit' class='btn btn-primary' style='width:180px'
                value='Редактировать данные'>
                <input type='reset' class='btn btn-default' style='width:140px' value='Очистить данные'></div> </div>
                </form></div>";
            }
        } else{
            $errors[] = 'Неверный логин или пароль!';
        }

        if (! empty($errors)){
            echo '<div style="color: red;">'. array_shift($errors). '</div><hr>';
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