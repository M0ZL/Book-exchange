<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Подключение к базе данных
    $dbuser = 'mysql';
    $dbpass = 'mysql';
    $dbserver = 'localhost';
    $dbname = 'book';
    $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname);

    if (!$mysql) {
        die("Ошибка подключения к базе данных: " . mysqli_connect_error());
    }

    // Получение данных из формы
    $offered_book_id = $_POST['offered_book_id'];
    $desired_genre = $_POST['desired_genre'];
    $desired_condition = $_POST['desired_condition'];
    $desired_other = $_POST['desired_other'];
    $user_id = $_SESSION['пользователь_id']; // ID пользователя из сессии

    // Проверка существования книги
    $check_query = "SELECT книга_id FROM книги WHERE книга_id = ?";
    $check_stmt = $mysql->prepare($check_query);
    $check_stmt->bind_param("i", $offered_book_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows === 0) {
        die("Ошибка: Книга с ID $offered_book_id не найдена.");
    }

    // Вставка данных в таблицу запросов на обмен
    $query = "INSERT INTO запросы_на_обмен (
        offered_book_id, desired_genre, desired_condition, desired_other, пользователь_id
    ) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysql->prepare($query);
    $stmt->bind_param(
        "isssi", 
        $offered_book_id, 
        $desired_genre, 
        $desired_condition, 
        $desired_other, 
        $user_id
    );

    if ($stmt->execute()) {
        // Перенаправление на главную страницу
        header("Location: index.php"); // Замените "index.php" на URL вашей главной страницы
        exit(); // Завершаем выполнение скрипта
    } else {
        echo "Ошибка при отправке запроса: " . $stmt->error;
    }

    $stmt->close();
    $check_stmt->close();
    $mysql->close();
}
?>