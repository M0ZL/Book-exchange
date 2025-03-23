<?php
session_start();
$user_id = $_SESSION['пользователь_id']; // ID текущего пользователя

// Подключение к базе данных
$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname);

if (!$mysql) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Получение предложенных обменов (где текущий пользователь — сторона А)
$query_proposed = "
    SELECT 
        п.предложение_id, п.запрос_id, п.книга_id, п.подтверждение,
        п.трек_номер_а, п.трек_номер_б,
        п.доставка_подтверждена_а, п.доставка_подтверждена_б,
        к.название AS offered_book_name,
        ю.ник_пользователя AS сторона_б_ник
    FROM предложения_на_обмен п
    JOIN книги к ON п.книга_id = к.книга_id
    JOIN пользователи ю ON п.сторона_б = ю.пользователь_id
    WHERE п.сторона_а = ? AND п.статус_завершения = FALSE
";
$stmt_proposed = $mysql->prepare($query_proposed);
$stmt_proposed->bind_param("i", $user_id);
$stmt_proposed->execute();
$result_proposed = $stmt_proposed->get_result();

// Получение полученных обменов (где текущий пользователь — сторона Б)
$query_received = "
    SELECT 
        п.предложение_id, п.запрос_id, п.книга_id, п.подтверждение,
        п.трек_номер_а, п.трек_номер_б,
        п.доставка_подтверждена_а, п.доставка_подтверждена_б,
        к.название AS offered_book_name,
        ю.ник_пользователя AS сторона_а_ник
    FROM предложения_на_обмен п
    JOIN книги к ON п.книга_id = к.книга_id
    JOIN пользователи ю ON п.сторона_а = ю.пользователь_id
    WHERE п.сторона_б = ? AND п.статус_завершения = FALSE
";
$stmt_received = $mysql->prepare($query_received);
$stmt_received->bind_param("i", $user_id);
$stmt_received->execute();
$result_received = $stmt_received->get_result();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои обмены</title>
</head>
<body>
    <h1>Мои обмены</h1>

    <!-- Предложенные обмены -->
    <h2>Предложенные обмены</h2>
    <ul>
        <?php while ($row = $result_proposed->fetch_assoc()): ?>
            <li>
                <strong>Книга:</strong> <?= $row['offered_book_name'] ?><br>
                <strong>Получатель:</strong> <?= $row['сторона_б_ник'] ?><br>
                <strong>Статус:</strong> <?= $row['подтверждение'] ? 'Подтвержден' : 'Ожидание' ?><br>
                <?php if ($row['подтверждение']): ?>
                    <?php if (empty($row['трек_номер_а'])): ?>
                        <form method="POST" action="track_delivery.php">
                            <input type="hidden" name="offer_id" value="<?= $row['предложение_id'] ?>">
                            <label for="track_number">Введите трек-номер:</label>
                            <input type="text" name="track_number" id="track_number" required>
                            <button type="submit">Отправить</button>
                        </form>
                    <?php elseif (empty($row['трек_номер_б'])): ?>
                        <p>Ожидание трек-номера от получателя.</p>
                    <?php else: ?>
                        <p><strong>Ваш трек-номер:</strong> <?= $row['трек_номер_а'] ?></p>
                        <p><strong>Трек-номер получателя:</strong> <?= $row['трек_номер_б'] ?></p>
                        <?php if (!$row['доставка_подтверждена_а']): ?>
                            <form method="POST" action="confirm_delivery.php">
                                <input type="hidden" name="offer_id" value="<?= $row['предложение_id'] ?>">
                                <button type="submit">Товар пришел</button>
                            </form>
                        <?php else: ?>
                            <p>Ожидание подтверждения от получателя.</p>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Ожидание подтверждения от получателя.</p>
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>

    <!-- Полученные обмены -->
    <h2>Полученные обмены</h2>
    <ul>
        <?php while ($row = $result_received->fetch_assoc()): ?>
            <li>
                <strong>Книга:</strong> <?= $row['offered_book_name'] ?><br>
                <strong>Отправитель:</strong> <?= $row['сторона_а_ник'] ?><br>
                <strong>Статус:</strong> <?= $row['подтверждение'] ? 'Подтвержден' : 'Ожидание' ?><br>
                <?php if ($row['подтверждение']): ?>
                    <?php if (empty($row['трек_номер_б'])): ?>
                        <form method="POST" action="track_delivery.php">
                            <input type="hidden" name="offer_id" value="<?= $row['предложение_id'] ?>">
                            <label for="track_number">Введите трек-номер:</label>
                            <input type="text" name="track_number" id="track_number" required>
                            <button type="submit">Отправить</button>
                        </form>
                    <?php else: ?>
                        <p><strong>Ваш трек-номер:</strong> <?= $row['трек_номер_б'] ?></p>
                        <p><strong>Трек-номер отправителя:</strong> <?= $row['трек_номер_а'] ?></p>
                        <?php if (!$row['доставка_подтверждена_б']): ?>
                            <form method="POST" action="confirm_delivery.php">
                                <input type="hidden" name="offer_id" value="<?= $row['предложение_id'] ?>">
                                <button type="submit">Товар пришел</button>
                            </form>
                        <?php else: ?>
                            <p>Ожидание подтверждения от отправителя.</p>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="confirm_exchange.php?offer_id=<?= $row['предложение_id'] ?>&action=confirm">Принять</a>
                    <a href="confirm_exchange.php?offer_id=<?= $row['предложение_id'] ?>&action=reject">Отклонить</a>
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>