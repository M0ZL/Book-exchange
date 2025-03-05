<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Новости</title>
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
    .order-panel {
        background-color: #444;
        color: #fff;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .order-panel input[type="text"], .order-panel input[type="number"] {
        width: 100%;
        padding: 8px;
        margin: 5px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .order-panel input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .order-panel input[type="submit"]:hover {
        background-color: #218838;
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
    <img src="images/logobooks.png" alt="Логотип" width="300" height="300"/>
</header>
<div class="container">
    <h2 align="center">Все отзывы:</h2>
    <?php
    $dbuser = 'mysql';
    $dbpass = 'mysql';
    $dbserver = 'localhost';
    $dbname = 'book';
    $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
    or die ('Ошибка ' . mysqli_error($mysql));
    $query1 = mysqli_query($mysql, "SELECT s.Имя, k.Комментарий, k.Дата FROM комментарии k INNER JOIN сотрудники s ON k.Сотрудник_ID = s.ID Order by k.Дата desc");

    while($row=mysqli_fetch_array($query1))
    {
        echo " 
        <div class='news-item'>
            <h2 align='left'>" .  $row['Имя'] . "</h2>
            <p align='center'>" . $row['Комментарий'] . "</p>
            <h5 align='right'> Дата написания: " . $row['Дата'] . "</h5>  
        </div>
        ";
    }

    mysqli_close($mysql);
    ?>

    <br>
    <?php
    $dbuser = 'mysql';
    $dbpass = 'mysql';
    $dbserver = 'localhost';
    $dbname = 'book';
    $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
    or die ('Ошибка ' . mysqli_error($mysql));
    if(!empty($_SESSION['acc_user'])){
        echo '<div align="center">
        <a href="AddNews.php" class="btn">Добавить новость</a>
        <br><br>
        <a href="EditNews.php" class="btn">Редактировать новости</a>
        </div>';

        echo "<form action='News.php' method='post'><div align='center'> 
        <table>
        <tr>
        <td>Список:<br><select class='form-control' name='list' size='1'>";
        
        $stmt = mysqli_query($mysql, "SELECT * FROM news");
        while ($row = mysqli_fetch_array($stmt))
            echo '<option value="' . $row["id_news"] . '">' . $row["id_news"] ." ". $row["Name_news"] ." ". $row["Date_news"] . '</option>';
        echo "</select><br><br>";
        
        $list =$_POST["list"];
        if (isset($_POST['delete'])) {
            $strSQL2 = mysqli_query($mysql, "DELETE FROM `news` WHERE id_news = $list") 
            or die (mysqli_error($mysql));
        }
        
        echo "</td>
        </tr>
        </table>

        <div align='center'>
            <input type='submit' class='btn' name='delete' value='Удалить новость'></br>
        </div>
        </div></form>";
    }
    mysqli_close($mysql);
    ?>
    <div align='center'>
        <a href='index.php' class='btn'>На главную страницу</a>
    </div>
</div>
<footer>
    <p>Контактная информация:</p>
    <p>Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)</p>
    <p>Наш режим работы: Понедельник – Воскресенье: 10:00 – 18:00</p>
    <p>Электронная почта: <a href="mailto:Productsforfutureuse@gmail.com">Напишите нам!</a></p>
</footer>
</body>
</html>