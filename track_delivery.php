<?php
session_start();
$offer_id = $_POST['offer_id'];
$track_number = $_POST['track_number'];

// Подключение к базе данных
$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname);

if (!$mysql) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Определение, кто вводит трек-номер (сторона А или Б)
$user_id = $_SESSION['пользователь_id'];
$query = "SELECT сторона_а, сторона_б FROM предложения_на_обмен WHERE предложение_id = ?";
$stmt = $mysql->prepare($query);
$stmt->bind_param("i", $offer_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['сторона_а'] == $user_id) {
    $field = 'трек_номер_а';
} else {
    $field = 'трек_номер_б';
}

// Обновление трек-номера
$query = "UPDATE предложения_на_обмен SET $field = ? WHERE предложение_id = ?";
$stmt = $mysql->prepare($query);
$stmt->bind_param("si", $track_number, $offer_id);
$stmt->execute();

header("Location: my_exchanges.php");
exit();
?>