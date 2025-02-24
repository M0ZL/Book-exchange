<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Обмен книгами</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style type="text/css">
  </style>
</head>
<body background="images/background.jpg">
<p align=center><img width="600" height="340" src="images/logobooks.png" /></p>
    <div class="container">
        <h1>Создание заявки на обмен книгами</h1>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Получаем данные из формы
            $bookTitle = htmlspecialchars($_POST['bookTitle']);
            $author = htmlspecialchars($_POST['author']);
            $userName = htmlspecialchars($_POST['userName']);
            $userEmail = htmlspecialchars($_POST['userEmail']);
            $userPhone = htmlspecialchars($_POST['userPhone']);

            // Здесь можно добавить код для сохранения данных в базу данных или отправки по email

            // Выводим сообщение об успешной отправке
            echo "<div class='alert alert-success'>Спасибо, $userName! Ваша заявка на обмен книги '$bookTitle' принята.</div>";
        }
        ?>

        <form action="" method="post">
            <div class="form-group">
                <label for="bookTitle">Название книги:</label>
                <input type="text" class="form-control" id="bookTitle" name="bookTitle" required>
            </div>
            <div class="form-group">
                <label for="author">Автор:</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>
            <div class="form-group">
                <label for="userName">Ваше имя:</label>
                <input type="text" class="form-control" id="userName" name="userName" required>
            </div>
            <div class="form-group">
                <label for="userEmail">Ваш email:</label>
                <input type="email" class="form-control" id="userEmail" name="userEmail" required>
            </div>
            <div class="form-group">
                <label for="userPhone">Ваш телефон:</label>
                <input type="tel" class="form-control" id="userPhone" name="userPhone" required>
            </div>
            <button type="submit" class="btn btn-primary">Отправить заявку</button>
        </form>
    </div>
    <div align="center"><a href = 'index.php'><button type='button' class='btn btn-link' >На главную страницу</button></a></div>
	</p></div>
	</form><br>
	<div align="center">
    <p>Контактная информация:</br>
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
	Электронная почта: 
	<a href="mailto:BooksForExchange@gmail.com"><span class="glyphicon glyphicon-envelope"></span> Напишите нам!</a>
	</p>
	</div>
</body>
</html>