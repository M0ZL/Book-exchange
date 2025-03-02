<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Обмен книгами</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
        header img {
            max-width: 100%;
            height: auto;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .tbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .tbl td, .tbl th {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .tbl th {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #555;
        }
        .order-panel {
            background-color: #444;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .order-panel input[type="text"], .order-panel input[type="number"] {
            width: 98%;
            padding: 8px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .order-panel input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color:rgb(46, 44, 44);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .order-panel input[type="submit"]:hover {
            background-color:rgb(46, 44, 44);
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <img src="images/logobooks1.png" alt="Логотип" width="300" height="300">
    </header>
    <div class="container">
        <h1>Создание заявки на обмен книгами</h1>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Получаем данные из формы
            $bookTitle = htmlspecialchars($_POST['bookTitle']);
            $author = htmlspecialchars($_POST['author']);
            $userName = htmlspecialchars($_POST['userName']);
            $userEmail = htmlspecialchars($_POST['userEmail']);
            $userPhone = htmlspecialchars($_POST['userPhone']);

            // Здесь можно добавить код для сохранения данных в базу данных или отправки по email

            // Выводим сообщение об успешной отправке
            echo "<div class='alert-success'>Спасибо, $userName! Ваша заявка на обмен книги '$bookTitle' принята.</div>";
        }
        ?>

<script>
function validateForm() {
    const bookTitle = document.getElementById('bookTitle').value;
    const author = document.getElementById('author').value;
    const userName = document.getElementById('userName').value;
    const userEmail = document.getElementById('userEmail').value;
    const userPhone = document.getElementById('userPhone').value;

    if (bookTitle.trim() === "") {
        alert("Пожалуйста, введите название книги.");
        return false;
    }

    if (author.trim() === "") {
        alert("Пожалуйста, введите автора книги.");
        return false;
    }

    if (userName.trim() === "") {
        alert("Пожалуйста, введите ваше имя.");
        return false;
    }

    if (!validateEmail(userEmail)) {
        alert("Пожалуйста, введите корректный email.");
        return false;
    }

    if (!validatePhone(userPhone)) {
        alert("Пожалуйста, введите корректный номер телефона.");
        return false;
    }

    return true;
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}

function validatePhone(phone) {
    const re = /\+7\s?[\(]{0,1}9[0-9]{2}[\)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}/;
    return re.test(String(phone));
}
</script>

        <div class="order-panel">
            <form action="" method="post" onsubmit="return validateForm()">
                <label for="bookTitle">Название книги:</label>
                <input type="text" id="bookTitle" name="bookTitle" required>

                <label for="author">Автор:</label>
                <input type="text" id="author" name="author" required>

                <label for="userName">Ваше имя:</label>
                <input type="text" id="userName" name="userName" required>

                <label for="userEmail">Ваш email:</label>
                <input type="email" id="userEmail" name="userEmail" required>

                <label for="userPhone">Ваш телефон:</label>
                <input type="tel" id="userPhone" name="userPhone" required><br><br>

                <input type="submit" class="btn" value="Отправить заявку">
            </form><br>
            <div align="center">
            <a href="index.php" class="btn">На главную страницу</a>
        </div>
        </div>
    </div>
    <footer>
        <p>Контактная информация:</p>
        <p>Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)</p>
        <p>Наш режим работы: Понедельник – Воскресенье: 10:00 – 18:00</p>
        <p>Электронная почта: <a href="mailto:BooksForExchange@gmail.com">Напишите нам!</a></p>
    </footer>
</body>
</html>