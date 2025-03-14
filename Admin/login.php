<?php
session_start();

$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';
$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
or die ('Ошибка ' . mysqli_error($mysql));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Экранирование входных данных для предотвращения SQL-инъекций
    $username = mysqli_real_escape_string($mysql, $username);
    $password = mysqli_real_escape_string($mysql, $password);

    // Запрос для проверки пользователя
    $query = "SELECT `фамилия`, `имя`, `отчество`,`роль` FROM пользователи WHERE электронная_почта = '$username' AND пароль = '$password'";
    $result = mysqli_query($mysql, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Проверка роли пользователя
        if ($user['роль'] === 'администратор') {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_full_name'] = $user['фамилия'] . ' ' . $user['имя'] . ' ' . $user['отчество'];
            header('Location: index.php');
            exit();
        } else {
            $error = "У вас нет прав администратора.";
        }
    } else {
        $error = "Неверный логин или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход администратора</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            color: #007BFF;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            background: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Вход администратора</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="login.php">
            <input type="text" name="username" id="username" placeholder="Электронная почта" required>
            <input type="password" name="password" id="password" placeholder="Пароль" required>
            <input type="submit" value="Войти">
        </form>
    </div>
</body>
</html>