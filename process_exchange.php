<?php
session_start();
$user_id = $_SESSION['пользователь_id']; // ID текущего пользователя
$request_id = $_POST['request_id']; // ID запроса на обмен
$book_id = $_POST['book_id']; // ID книги, которую предлагают для обмена

// Подключение к базе данных
$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname);

if (!$mysql) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}
$queryB = "SELECT `пользователь_id` FROM `запросы_на_обмен` WHERE `запрос_id` = $request_id";
$queryA = "SELECT `пользователь_id` FROM `книги` WHERE `книга_id` =$book_id";
// Выполнение запроса
$resultB = $mysql->query($queryB);
$resultA = $mysql->query($queryA);

// Проверка результата
if ($resultB->num_rows > 0) {
    // Получение данных
    $rowB = $resultB->fetch_assoc();
    $rowA = $resultA->fetch_assoc();
    $user_id_B = $rowB["пользователь_id"]; // Сохранение значения в переменной
    $user_id_A = $rowA["пользователь_id"]; // Сохранение значения в переменной
    echo "ID пользователяB: " . $user_id_B; // Вывод значения (для проверки)
    echo "ID пользователяA: " . $user_id_A; // Вывод значения (для проверки)
} else {
    echo "Запись не найдена.";
}


// Сохранение предложения обмена
$query = "INSERT INTO предложения_на_обмен (запрос_id, книга_id, сторона_а, сторона_б) VALUES (?, ?, ?, ?)";
$stmt = $mysql->prepare($query);
$stmt->bind_param("iiii", $request_id, $book_id,$user_id_A,$user_id_B);
$stmt->execute();

// Перенаправление на страницу обмена
header("Location: index.php");
exit();
?>