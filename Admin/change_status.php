<?php
// Подключение к базе данных
$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';

$conn = new mysqli($dbserver, $dbuser, $dbpass, $dbname); 

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получение данных из POST-запроса
$user_id = $_POST['user_id'];
$new_status = $_POST['new_status'];

// Подготовка SQL-запроса для обновления статуса
$sql = "UPDATE пользователи SET статус = ? WHERE пользователь_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $new_status, $user_id);

// Выполнение запроса
if ($stmt->execute()) {
    echo "Статус пользователя успешно изменен.";
} else {
    echo "Ошибка при изменении статуса: " . $stmt->error;
}

// Закрытие соединения
$stmt->close();
$conn->close();
?>