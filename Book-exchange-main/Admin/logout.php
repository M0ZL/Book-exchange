<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Выход</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
            padding: 20% 0;
        }

        h2 {
            color: #007BFF;
        }
        
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #007BFF;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }

        a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Вы вышли из системы</h2>
    <a href="login.php">Войти снова</a>
</body>
</html>
