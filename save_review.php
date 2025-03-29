<?php
session_start();

// Проверяем авторизацию пользователя
if (!isset($_SESSION['пользователь_id'])) {
    die("Ошибка: Пользователь не авторизован");
}

// Проверяем данные формы
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['offer_id'], $_POST['комментарий'])) {
    // Данные для подключения к БД
    $dbuser = 'mysql';
    $dbpass = 'mysql';
    $dbserver = 'localhost';
    $dbname = 'book';
    
    // Подключаемся к БД
    $mysql = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
    
    if ($mysql->connect_error) {
        die("Ошибка подключения: " . $mysql->connect_error);
    }
    
    // Получаем ID пользователя из сессии
    $user_id = $_SESSION['пользователь_id'];
    $exchange_id = $_POST['offer_id'];
    $comment = $_POST['комментарий'];
    $estimation = $_POST['оценка'];
    
    // Подготовка запроса с параметрами
    $stmt = $mysql->prepare("INSERT INTO отзывы (пользователь_id, обмен_id, комментарий, оценка) VALUES (?, ?, ?, ?)");
    
    if ($stmt === false) {
        die("Ошибка подготовки запроса: " . $mysql->error);
    }
    
    // Привязываем параметры
    $stmt->bind_param("iisi", $user_id, $exchange_id, $comment, $estimation);
    
    // Выполняем запрос
    if ($stmt->execute()) {
        // Закрываем соединения
        $stmt->close();
        $mysql->close();
        
        // Перенаправляем на подтверждение доставки
        header("Location: confirm_delivery.php?offer_id=" . $exchange_id);
        exit();
    } else {
        die("Ошибка при сохранении отзыва: " . $stmt->error);
    }
} else {
    // Если данные не переданы, перенаправляем обратно
    header("Location: index.php");
    exit();
}
?>