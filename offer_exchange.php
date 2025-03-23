<?php
session_start();
$user_id = $_SESSION['пользователь_id']; // ID текущего пользователя
$request_id = $_GET['request_id']; // ID запроса на обмен

// Подключение к базе данных
$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname);

if (!$mysql) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Получение списка книг текущего пользователя
$query = "SELECT книга_id, название FROM книги WHERE пользователь_id = ? AND статус = 'доступна'";
$stmt = $mysql->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Предложить обмен</title>
</head>
<body>
    <h1>Предложить обмен</h1>
    <form method="POST" action="process_exchange.php">
        <input type="hidden" name="request_id" value="<?= $request_id ?>">
        
        <label for="book_id">Выберите книгу для обмена:</label>
        <select name="book_id" id="book_id" required>
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?= $row['книга_id'] ?>"><?= $row['название'] ?></option>
            <?php endwhile; ?>
        </select><br>

        <button type="submit">Предложить обмен</button>
    </form>
</body>
</html>