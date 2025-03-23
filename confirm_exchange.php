<?php
session_start();
$offer_id = $_GET['offer_id'];
$action = $_GET['action']; // confirm или reject

// Подключение к базе данных
$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname);

if (!$mysql) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Обновление статуса подтверждения
$confirmation = ($action == 'confirm') ? 1 : 0;
$query = "UPDATE предложения_на_обмен SET подтверждение = ? WHERE предложение_id = ?";
$stmt = $mysql->prepare($query);
$stmt->bind_param("ii", $confirmation, $offer_id);
$stmt->execute();

header("Location: my_exchanges.php");
exit();
?>