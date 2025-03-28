<?php
session_start();
if (!isset($_SESSION['пользователь_id']) || !isset($_POST['offer_id']) || !isset($_POST['track_number'])) {
    header("Location: login.php");
    exit();
}

// Подключение к базе данных
$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}
$mysql->set_charset("utf8mb4");

$offer_id = $_POST['offer_id'];
$track_number = trim($_POST['track_number']);
$user_id = $_SESSION['пользователь_id'];

// Проверяем длину трек-номера
if (strlen($track_number) < 10) {
    $mysql->close();
    die("Трек-номер должен содержать минимум 10 символов");
}

// Определяем сторону
$stmt = $mysql->prepare("SELECT сторона_а FROM предложения_на_обмен WHERE предложение_id = ?");
if (!$stmt) {
    $mysql->close();
    die("Ошибка подготовки запроса: " . $mysql->error);
}
$stmt->bind_param("i", $offer_id);
$stmt->execute();
$is_side_a = ($stmt->get_result()->fetch_assoc()['сторона_а'] == $user_id);

// Обновляем трек-номер
$field = $is_side_a ? 'трек_номер_а' : 'трек_номер_б';
$stmt = $mysql->prepare("UPDATE предложения_на_обмен SET $field = ? WHERE предложение_id = ?");
if (!$stmt) {
    $mysql->close();
    die("Ошибка подготовки запроса: " . $mysql->error);
}
$stmt->bind_param("si", $track_number, $offer_id);
$stmt->execute();

$mysql->close();
header("Location: my_exchanges.php");
exit();
?>