<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta content="charset=utf-8">
<title>Профиль</title>
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
</style>
</head>
<body>
<header>
    <img src="images/l.png" alt="Логотип">
    <img src="images/logobooks.png" alt="Логотип">
    <img src="images/r.png" alt="Логотип">
</header>
<div class='container'>
    <h2>Профиль</h2>
    <form action="Profile.php" method="post">
    <?php
        $dbuser = 'mysql';
        $dbpass = 'mysql';
        $dbserver = 'localhost';
        $dbname = 'book';
        $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
        or die ('Ошибка ' . mysqli_error($mysql));
        $id = $_SESSION['пользователь_id'];
        if(isset($_SESSION['prof_user'])){
            echo $_SESSION['prof_user'];    
        }

        if (isset($_POST['y'])){
            if(isset($_SESSION['acc_id'])){
                $strSQL2 = mysqli_query($mysql, "DELETE FROM `пользователи` WHERE пользователь_id = '$id'") 
                    or die (mysqli_error($mysql));
                echo "<a href='Logout.php' class='btn'>Выйти из аккаунта</a></br>";
            }
        }
        else{
            echo "<div><input type='submit' class='btn' name='y' value='Удалить аккаунт'></br></br>    
            <a href='ProfileEdit.php' class='btn'>Редактировать аккаунт</a>
            <a href='Logout.php' class='btn'>Выйти из аккаунта</a></br></br>
            <a href='MyBooks.php' class='btn'>Мои книги</a>
            <a href='SubmitRequest.php' class='btn'>Создать заявку на обмен</a>
            <a href='MyExchanges.php' class='btn'>Мои обмены</a></br>
            <p><a href='index.php' class='btn'>На главную страницу</a><br><br></div>";
        }
        mysqli_close($mysql);
    ?>
    </form>
</div>
<footer>
    Контактная информация:</br>
    Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)</br>
	<p>Наш режим работы: Понедельник – Воскресенье: 10:00 – 18:00</p>
    <p>Электронная почта: <a href="mailto:BooksForExchange@gmail.com">Напишите нам!</a></p>
</footer>
</body>
</html>