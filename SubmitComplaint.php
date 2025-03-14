<?php
session_start();
$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
or die ('Ошибка ' . mysqli_error($mysql));

// Проверка, залогинен ли пользователь
if (!isset($_SESSION['logged_user'])) {
    die("Вы должны быть залогинены, чтобы подать жалобу.");
}

// Проверка, что данные были отправлены
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем ID залогиненного пользователя
    $logged_user_id =  $id = $_SESSION['пользователь_id'];

    // Получаем ID пользователя, на которого подается жалоба
    $complaint_user_id = intval($_POST['user_id']);

    // Получаем описание жалобы
    $description = mysqli_real_escape_string($mysql, $_POST['description']);

    // Проверяем, что пользователь не подает жалобу на самого себя
    if ($logged_user_id === $complaint_user_id) {
        die("Вы не можете подать жалобу на самого себя.");
    }

    // Вставка жалобы в базу данных
    $query = "INSERT INTO жалобы (пользователь_id, жалоба_на, описание) VALUES ($logged_user_id, $complaint_user_id, '$description')";
    if (mysqli_query($mysql, $query)) {
        echo "Жалоба успешно подана.";
    } else {
        echo "Ошибка: " . mysqli_error($mysql);
    }
} else {
    echo "Некорректный запрос.";
}

mysqli_close($mysql);
?>