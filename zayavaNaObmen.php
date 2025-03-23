<?php
session_start();
$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
or die ('Ошибка ' . mysqli_error($mysql));

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Запрос на обмен</title>
</head>
<body>
    <h1>Запрос на обмен</h1>
    <form action="zaprosForm.php" method="post">
        <h2>Книга предлагаемая к обмену</h2>
        <select name="offered_book_id" required>
            <?php
            if (isset($_SESSION['пользователь_id'])) {
                $user_id = $_SESSION['пользователь_id'];
            echo "User ID: " . $user_id; // Проверьте, выводится ли правильный ID
            // Подключение к базе данных
            

            // Запрос для получения книг пользователя
            $query = "SELECT книга_id, название, isbn FROM книги WHERE пользователь_id = ? AND статус = 'доступна'";
            $stmt = $mysql->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                echo "User ID: " . $user_id; // Проверьте, выводится ли правильный ID
                echo "<option value=''>Нет доступных книг</option>";
            } else {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['книга_id']}'>{$row['название']} (ISBN: {$row['isbn']})</option>";
                }
            }
            $stmt->close();
            $mysql->close();
        } else {
            echo "<p>Не указан идентификатор пользователя.</p>";
        }
            ?>
        </select>

        <h2>Данные по книге, запрашиваемой к обмену</h2>
        Жанр: <input type="text" name="desired_genre"><br>
        Состояние книги: 
        <select name="desired_condition">
            <option value="не имеет значения">Не имеет значения</option>
            <option value="новое">Новое</option>
            <option value="отличное">Отличное</option>
            <option value="хорошее">Хорошее</option>
            <option value="удовлетворительное">Удовлетворительное</option>
        </select><br>
        Другие характеристики: <textarea name="desired_other"></textarea><br>

        <h2>Адрес и ФИО куда доставить</h2>
        Адрес: <input type="text" name="delivery_address" required><br>
        ФИО получателя: <input type="text" name="recipient_name" required><br>

        <input type="checkbox" name="agree" required> Подтверждаю правильность введенных данных и согласие на обмен<br>
        <input type="submit" value="Отправить запрос">
    </form>
</body>
</html>