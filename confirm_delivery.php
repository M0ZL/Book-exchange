<?php
session_start();
$offer_id = $_POST['offer_id'];

// Подключение к базе данных
$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname);

if (!$mysql) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Определение, кто подтверждает доставку (сторона А или Б)
$user_id = $_SESSION['пользователь_id'];
$query = "SELECT сторона_а, сторона_б FROM предложения_на_обмен WHERE предложение_id = ?";
$stmt = $mysql->prepare($query);
$stmt->bind_param("i", $offer_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['сторона_а'] == $user_id) {
    $field = 'доставка_подтверждена_а';
} else {
    $field = 'доставка_подтверждена_б';
}

// Обновление статуса доставки
$query = "UPDATE предложения_на_обмен SET $field = TRUE WHERE предложение_id = ?";
$stmt = $mysql->prepare($query);
$stmt->bind_param("i", $offer_id);
$stmt->execute();

// Проверка, подтвердили ли обе стороны доставку
$query = "SELECT доставка_подтверждена_а, доставка_подтверждена_б FROM предложения_на_обмен WHERE предложение_id = ?";
$stmt = $mysql->prepare($query);
$stmt->bind_param("i", $offer_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['доставка_подтверждена_а'] && $row['доставка_подтверждена_б']) {
    // Увеличение рейтинга пользователей
    $query = "
        UPDATE пользователи 
        SET рейтинг = рейтинг + 1 
        WHERE пользователь_id IN (
            SELECT сторона_а FROM предложения_на_обмен WHERE предложение_id = ?
            UNION
            SELECT сторона_б FROM предложения_на_обмен WHERE предложение_id = ?
        )
    ";
    $stmt = $mysql->prepare($query);
    $stmt->bind_param("ii", $offer_id, $offer_id);
    $stmt->execute();

    // Установка статуса завершения обмена
    $query = "UPDATE предложения_на_обмен SET статус_завершения = TRUE WHERE предложение_id = ?";
    $stmt = $mysql->prepare($query);
    $stmt->bind_param("i", $offer_id);
    $stmt->execute();
}

header("Location: my_exchanges.php");
exit();
?>