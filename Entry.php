<?php
    session_start();
    $login = $_POST['login'];
    $pass = $_POST['pass'];
?>

<!DOCTYPE HTML>
<html>
<head>
<meta content="charset=utf-8">
<title>Авторизация</title>
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
        display: block;
        margin-bottom: 5px;
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
    <h2 align="center">Войти</h2>
    <form action="Entry.php" method="post">
        <div class="form-group">
            <label for="login">Ваш логин:</label>
            <input type="text" name="login" value="<?php echo @$login; ?>" required>
        </div>
        <div class="form-group">
            <label for="pass">Ваш пароль:</label>
            <input type="password" name="pass" value="<?php echo @$pass; ?>" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Войти"><br><br>
            <input type="reset" class="btn btn-default" value="Очистить данные">
        </div>
        <div align="center">
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
        $a = mysqli_query($mysql, "SELECT * FROM `сотрудники` where `логин` = '$login' and `пароль` = '$pass'");
        
        if(mysqli_num_rows($a) > 0) {
            $_SESSION['logged_user'] = $a;
            echo '<script>location.replace("index.php");</script>'; 
            foreach($a as $row){
                //$_SESSION['acc_user'] = $row['isAdmin'];
                //$_SESSION['acc_id'] = $row['id_visitor'];
                $_SESSION['prof_user'] = "<div>Логин: " . $row['логин'] . "</br></br> Пароль: " . $row['пароль'] . " </br></br> Фамилия: " . $row['Фамилия'] . 
                "</br></br> Имя: " . $row['Имя'] . "</br></br> Адрес: " . $row['address'] . "</br></br> Эл. почта: " . $row['Email'] . "</br></br> Телефон: " . $row['Телефон'] . "</br></br></div>";
                $_SESSION['log_user'] = "<div class='container'><form action='ProfileEdit.php' method='post'><div align=center><div class='form-group'>
                <label for='login'>Ваш логин: </label></br><input type = 'text' value=". $row['логин'] ."
                name='login' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='pass'>Ваш текущий пароль: </label></br><input type = 'password' value=". $row['пароль'] ."
                name='pass' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='pass2'>Новый пароль: </label></br><input type = 'password' value=". $row['пароль'] ."
                name='pass2' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='pass3'>Подтвердите пароль: </label></br><input type = 'password'
                name='pass3' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='surname'>Фамилия:</label></br><input type = 'text' value=". $row['Фамилия'] ."
                name='surname' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='name'>Имя: </label></br><input type = 'text' value=". $row['Имя'] ."
                name='name' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='address'>Адрес (страна, город, улица, номер дома):</label></br><input type = 'text' value='". $row['address'] ."'
                name='address' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='email'>Ваша эл. почта: </label></br><input type = 'email' value=". $row['Email'] ."
                name='email' size='20' step='any'></br></br></div>
                <label for='tel'>Телефон:</label></br><input type = 'text' value='". $row['Телефон'] ."'
                name='tel' size='20' step='any'></br></br></div><div class='btn-group'>
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

<footer>
    <p>Контактная информация:</p>
    <p>Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)</p>
    <p>Наш режим работы: Понедельник – Воскресенье: 10:00 – 18:00</p>
    <p>Электронная почта: <a href="mailto:BooksForExchange@gmail.com">Напишите нам!</a></p>
</footer>
</body>
</html>