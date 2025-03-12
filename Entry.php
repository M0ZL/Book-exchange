<?php
session_start();
$login = $_POST['login'];
$pass = $_POST['pass'];

$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
or die ('Ошибка ' . mysqli_error($mysql));

if(isset($login) && isset($pass)){
    $errors = array();
    $a = mysqli_query($mysql, "SELECT * FROM `пользователи` where `ник_пользователя` = '$login' and `пароль` = '$pass'");
    
    if(mysqli_num_rows($a) > 0) {
        $user = mysqli_fetch_assoc($a);
        $_SESSION['logged_user'] = $user['ник_пользователя'];
        $_SESSION['пользователь_id'] = $user['пользователь_id']; // Добавляем ID пользователя в сессию
        echo '<script>location.replace("index.php");</script>'; 
    } else {
        $errors[] = 'Неверный логин или пароль!';
    }

    if (!empty($errors)){
        echo '<div style="color: red;">'. array_shift($errors). '</div><hr>';
    }
}
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
</style>
</head>
<body>
<header>
    <img src="images/l.png" alt="Логотип">
    <img src="images/logobooks.png" alt="Логотип">
    <img src="images/r.png" alt="Логотип">
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
        <div class="form-actions">
            <input type="submit" class="btn btn-primary" value="Войти">
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
            foreach($a as $row){
                //$_SESSION['acc_user'] = $row['isAdmin'];
                //$_SESSION['acc_id'] = $row['id_visitor'];
                $_SESSION['prof_user'] = "<div>Ник пользователя: " . $row['ник_пользователя'] . "</br></br> Пароль: " . $row['пароль'] . "</br></br> Рейтинг: " . $row['рейтинг'] . "</br></br> Дата регистрации: " . $row['дата_регистрации'] . " </br></br> Фамилия: " . $row['фамилия'] . 
                "</br></br> Имя: " . $row['имя'] . "</br></br> Отчество: " . $row['отчество'] . "</br></br> Адрес: " . $row['адрес'] . "</br></br> Эл. почта: " . $row['электронная_почта'] . "</br></br> Возраст: " . $row['возраст'] . "</br></br> Телефон: " . $row['телефон'] . "</br></br></div>";
                $_SESSION['log_user'] = "<div class='container'><form action='ProfileEdit.php' method='post'><div align=center><div class='form-group'>
                <label for='login'>Ваш логин: </label></br><input type = 'text' value=". $row['ник_пользователя'] ."
                name='login' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='pass'>Ваш текущий пароль: </label></br><input type = 'password' value=". $row['пароль'] ."
                name='pass' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='pass2'>Новый пароль: </label></br><input type = 'password' value=". $row['пароль'] ."
                name='pass2' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='pass3'>Подтвердите пароль: </label></br><input type = 'password'
                name='pass3' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='reit'>Рейтинг: </label></br><input type = 'password' value=". $row['рейтинг'] ."
                name='reit' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='date'>Дата регистрации: </label></br><input type = 'password' value=". $row['дата_регистрации'] ."
                name='date' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='surname'>Фамилия:</label></br><input type = 'text' value=". $row['фамилия'] ."
                name='surname' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='name'>Имя: </label></br><input type = 'text' value=". $row['имя'] ."
                name='name' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='patronymic'>Отчество: </label></br><input type = 'password' value=". $row['отчество'] ."
                name='patronymic' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='address'>Адрес:</label></br><input type = 'text' value='". $row['адрес'] ."'
                name='address' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='email'>Ваша эл. почта: </label></br><input type = 'email' value=". $row['электронная_почта'] ."
                name='email' size='20' step='any'></br></br></div>
                <label for='age'>Возраст:</label></br><input type = 'text' value='". $row['возраст'] ."'
                name='age' size='20' step='any'></br></br></div><div class='form-group'>
                <label for='tel'>Телефон:</label></br><input type = 'text' value='". $row['телефон'] ."'
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