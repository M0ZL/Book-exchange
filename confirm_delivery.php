<?php
session_start();
// if (!isset($_SESSION['пользователь_id']) || !isset($_POST['offer_id'])) {
//     header("Location: login.php");
//     exit();
// }

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
if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['offer_id'])){
    $offer_id = $_POST['offer_id']?? $_GET['offer_id'];
    $user_id = $_SESSION['пользователь_id'];
}
// $offer_id = $_POST['offer_id'];
// $user_id = $_SESSION['пользователь_id'];

// Начинаем транзакцию
$mysql->begin_transaction();

try {
    // Определяем сторону
    $stmt = $mysql->prepare("SELECT сторона_а FROM предложения_на_обмен WHERE предложение_id = ?");
    if (!$stmt) die("Ошибка подготовки запроса: " . $mysql->error);
    $stmt->bind_param("i", $offer_id);
    $stmt->execute();
    $is_side_a = ($stmt->get_result()->fetch_assoc()['сторона_а'] == $user_id);
    
    // Обновляем статус доставки
    $field = $is_side_a ? 'доставка_подтверждена_а' : 'доставка_подтверждена_б';
    $stmt = $mysql->prepare("UPDATE предложения_на_обмен SET $field = TRUE WHERE предложение_id = ?");
    if (!$stmt) die("Ошибка подготовки запроса: " . $mysql->error);
    $stmt->bind_param("i", $offer_id);
    $stmt->execute();
    
    // Проверяем, подтвердили ли обе стороны
    $stmt = $mysql->prepare("SELECT доставка_подтверждена_а, доставка_подтверждена_б, сторона_а, сторона_б 
                            FROM предложения_на_обмен WHERE предложение_id = ?");
    if (!$stmt) die("Ошибка подготовки запроса: " . $mysql->error);
    $stmt->bind_param("i", $offer_id);
    $stmt->execute();
    $status = $stmt->get_result()->fetch_assoc();
    
    if ($status['доставка_подтверждена_а'] && $status['доставка_подтверждена_б']) {
        // Увеличиваем рейтинг
        $stmt = $mysql->prepare("UPDATE пользователи SET рейтинг = рейтинг + 1 
                                WHERE пользователь_id IN (?, ?)");
        if (!$stmt) die("Ошибка подготовки запроса: " . $mysql->error);
        $stmt->bind_param("ii", $status['сторона_а'], $status['сторона_б']);
        $stmt->execute();
        
        //Изменяет статус завершенный обмен
        $stmt = $mysql->prepare("UPDATE `предложения_на_обмен` SET `статус_завершения`= 1 WHERE `предложение_id`= ?");
        if (!$stmt) die("Ошибка подготовки запроса: " . $mysql->error);
        $stmt->bind_param("i", $offer_id);
        $stmt->execute();

        //Изменяем статус запрос на обмен
        $stmt = $mysql->prepare("UPDATE `запросы_на_обмен` з
                                            JOIN `предложения_на_обмен` п ON з.запрос_id = п.запрос_id
                                            SET з.статус = 'подтвержден'
                                            WHERE п.предложение_id = ?;");
        if (!$stmt) die("Ошибка подготовки запроса: " . $mysql->error);
        $stmt->bind_param("i", $offer_id);
        $stmt->execute();

        //Меняем статус книги
        $stmt = $mysql->prepare("UPDATE `книги` к 
        JOIN `запросы_на_обмен` з ON к.книга_id = з.offered_book_id 
        JOIN `предложения_на_обмен` п ON (п.сторона_б = з.пользователь_id OR п.книга_id = к.книга_id) 
        SET к.статус = 'обменяна' WHERE п.предложение_id = ?");
        if (!$stmt) die("Ошибка подготовки запроса: " . $mysql->error);
        $stmt->bind_param("i", $offer_id);
        $stmt->execute();

    }
    
    $mysql->commit();
} catch (Exception $e) {
    $mysql->rollback();
    die("Ошибка: " . $e->getMessage());
}

$mysql->close();
header("Location: my_exchanges.php");
exit();
?>