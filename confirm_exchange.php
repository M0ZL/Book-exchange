<?php
session_start();
if (!isset($_SESSION['пользователь_id']) || !isset($_GET['offer_id']) || !isset($_GET['action'])) {
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

$offer_id = $_GET['offer_id'];
$action = $_GET['action'];
$user_id = $_SESSION['пользователь_id'];

// Проверяем, что пользователь является стороной Б
$stmt = $mysql->prepare("SELECT предложение_id FROM предложения_на_обмен 
                        WHERE предложение_id = ? AND сторона_б = ?");
if (!$stmt) {
    $mysql->close();
    die("Ошибка подготовки запроса: " . $mysql->error);
}
$stmt->bind_param("ii", $offer_id, $user_id);
$stmt->execute();

if ($stmt->get_result()->num_rows == 0) {
    $mysql->close();
    die("Недостаточно прав для выполнения этого действия");
}

// Обновляем статус подтверждения
$confirmation = ($action == 'confirm') ? 1 : 0;
$stmt = $mysql->prepare("UPDATE предложения_на_обмен SET подтверждение = ? WHERE предложение_id = ?");
if (!$stmt) {
    $mysql->close();
    die("Ошибка подготовки запроса: " . $mysql->error);
}
$stmt->bind_param("ii", $confirmation, $offer_id);
$stmt->execute();

$mysql->close();
header("Location: my_exchanges.php");
exit();
?>