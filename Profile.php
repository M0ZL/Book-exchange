<?php
    session_start();

    $dbuser = 'mysql';
    $dbpass = 'mysql';
    $dbserver = 'localhost';
    $dbname = 'book';
    $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
    or die ('Ошибка ' . mysqli_error($mysql));

    $id = $_SESSION['пользователь_id'];

    // Запрос для получения роли пользователя
    $query = "SELECT роль FROM пользователи WHERE пользователь_id = '$id'";
    $result = mysqli_query($mysql, $query) or die(mysqli_error($mysql));

    if ($user = mysqli_fetch_assoc($result)) {
        $_SESSION['роль'] = $user['роль']; // Сохраняем роль в сессии
    }

    if (isset($_POST['y'])){
        if(isset($_SESSION['prof_user'])){
            // Удаление связанных данных из таблицы `сообщения`
            $strSQL1 = mysqli_query($mysql, "DELETE FROM `сообщения` WHERE отправитель_id = '$id' OR получатель_id = '$id'") 
                or die (mysqli_error($mysql));

            // Удаление связанных данных из таблицы `отзывы`
            $strSQL2 = mysqli_query($mysql, "DELETE FROM `отзывы` WHERE пользователь_id = '$id'") 
                or die (mysqli_error($mysql));

            // Удаление связанных данных из таблицы `обмены`
            $strSQL3 = mysqli_query($mysql, "DELETE FROM `обмены` WHERE заявка_id IN (SELECT заявка_id FROM `заявки_на_обмен` WHERE пользователь_id = '$id')") 
                or die (mysqli_error($mysql));

            // Удаление связанных данных из таблицы `заявки_на_обмен`
            $strSQL4 = mysqli_query($mysql, "DELETE FROM `заявки_на_обмен` WHERE пользователь_id = '$id'") 
                or die (mysqli_error($mysql));

            // Удаление связанных данных из таблицы `книги`
            $strSQL5 = mysqli_query($mysql, "DELETE FROM `книги` WHERE пользователь_id = '$id'") 
                or die (mysqli_error($mysql));

            // Удаление пользователя из таблицы `пользователи`
            $strSQL6 = mysqli_query($mysql, "DELETE FROM `пользователи` WHERE пользователь_id = '$id'") 
                or die (mysqli_error($mysql));

            // Перенаправление на Logout.php для выхода
            header("Location: Logout.php");
            exit();
        }
    }

    // Путь к директории, где будут храниться аватары
    $avatarDir = 'uploads/';

    // Если директории нет, создаем ее
    if (!file_exists($avatarDir)) {
        mkdir($avatarDir, 0777, true);
    }

    $id = $_SESSION['пользователь_id'];

    // Обработка загрузки аватара
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['avatar'])) {
        $avatar = $_FILES['avatar'];
        if ($avatar['error'] == UPLOAD_ERR_OK) {
            $tmp_name = $avatar['tmp_name'];
            $name = $id . '.png'; // Генерируем имя файла на основе ID пользователя
            $avatarPath = $avatarDir . $name;

        // Если у пользователя уже есть аватар, удаляем его
        if (file_exists($avatarPath)) {
            unlink($avatarPath); // Удаляем старый аватар
        }

        // Перемещаем новый аватар в папку uploads
        move_uploaded_file($avatar['tmp_name'], $avatarPath);
        }
    }

    // Получаем путь к аватару
    $avatarPath = $avatarDir . $id . '.png';
    if (!file_exists($avatarPath)) {
        $avatarPath = 'uploads/avatar.png'; // Стандартный аватар, если своего нет
    }

?>

<!DOCTYPE HTML>
<html>
<head>
<meta content="charset=utf-8">
<link rel="icon" type="image/png" sizes="32x32" href="images/ico.png">
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
        margin-top: 10px; /* Отступ между кнопками и рамкой аватарки */
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
    .fixed-gif {
        position: fixed;
        right: 40px;
        top: 50%; /* Начальная позиция по вертикали */
        transform: translateY(-50%); /* Центрирование по вертикали */
        z-index: 1000; /* Убедитесь, что гифка находится поверх других элементов */
        width: 150px; /* Ширина гифки */
        height: auto; /* Высота подстраивается автоматически */
    }
    .fixed-gif1 {
        position: fixed;
        left: 0px;
        top: 50%; /* Начальная позиция по вертикали */
        transform: translateY(-50%); /* Центрирование по вертикали */
        z-index: 1000; /* Убедитесь, что гифка находится поверх других элементов */
        width: 220px; /* Ширина гифки */
        height: auto; /* Высота подстраивается автоматически */
    }
    .avatar-container {
        width: 150px; /* Ширина рамки */
        height: 150px; /* Высота рамки */
        border-radius: 50%; /* Круглая рамка */
        margin: 20px auto; /* Центрирование по горизонтали */
        border: 3px solid #333; /* Рамка */
        display: flex; /* Для центрирования аватарки */
        justify-content: center; /* Центрирование по горизонтали */
        align-items: center; /* Центрирование по вертикали */
        overflow: hidden; /* Обрезаем изображение, если оно выходит за рамки */
    }

    .avatar {
        height: 100%; /* Высота аватарки равна высоте рамки */
        width: auto; /* Ширина подстраивается автоматически */
        object-fit: cover; /* Сохраняем пропорции и обрезаем изображение */
    }
</style>
</head>
<body>
<header>
    <img src="images/l.png" alt="Логотип">
    <img src="images/logobooks.png" alt="Логотип">
    <img src="images/r.png" alt="Логотип">
</header>
<img src="images/GamerGIF_PORNO.gif" alt="Анимация" class="fixed-gif">
<img src="images/chebyrashka.gif" alt="Анимация" class="fixed-gif1">
<script>
    function confirmDelete() {
        return confirm("Вы уверены, что хотите удалить свой аккаунт? Это действие нельзя отменить.");
    }
</script>
<div class='container'>
    <h2 align = "center">Профиль</h2>

    <form action="Profile.php" method="post" enctype="multipart/form-data">
    <div align="center" class="avatar-container">
        <img src="<?php echo $avatarPath; ?>" alt="Аватар" class="avatar">
    </div>
    <div align="center">
        <input class="btn" type="file" name="avatar" accept="image/*">
        <input class="btn" type="submit" value="Загрузить аватар"></br></br>
    </div>
</form>
   
    <form action="Profile.php" method="post" onsubmit="return confirmDelete()">
    <?php

        if (isset($_SESSION['prof_user'])) {
            echo "<h3>Вы вошли как: " . $_SESSION['роль'] . "</h3>"; // Отображаем роль пользователя
            echo  $_SESSION['prof_user'];
        }

        echo "<div align='center'>
        <input type='submit' class='btn' name='y' value='Удалить аккаунт'></br></br>    
        <a href='ProfileEdit.php' class='btn'>Редактировать аккаунт</a>
        <a href='Logout.php' class='btn'>Выйти из аккаунта</a></br></br>
        <a href='MyBooks.php' class='btn'>Мои книги</a>
        <a href='SubmitRequest.php' class='btn'>Создать заявку на обмен</a>
        <a href='MyExchanges.php' class='btn'>Мои обмены</a></br>
        <p><a href='index.php' class='btn'>На главную страницу</a><br><br></div>";
        
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