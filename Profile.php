<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta content="charset=utf-8">
<title>Профиль</title>
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
    <img width="300" height="300" src="images/logobooks.png" />
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
        $id = $_SESSION['acc_id'].['id_visitor'];
        if(isset($_SESSION['prof_user'])){
            echo $_SESSION['prof_user'];    
        }

        if (isset($_POST['y'])){
            if(isset($_SESSION['acc_id'])){
                $strSQL2 = mysqli_query($mysql, "DELETE FROM `visitors` WHERE id_visitor = '$id'") 
                    or die (mysqli_error($mysql));
                echo "<a href='Logout.php' class='btn'>Выйти из аккаунта</a></br>";
            }
        }
        else{
            echo "<div><input type='submit' class='btn' name='y' value='Удалить аккаунт'></br></br>    
            <a href='ProfileEdit.php' class='btn'>Редактировать аккаунт</a>
            <a href='Logout.php' class='btn'>Выйти из аккаунта</a></br>
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