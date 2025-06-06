<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" sizes="32x32" href="images/ico.png">
<title>Добавление книг</title>
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
    }
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
        flex: 1;
    }
    header {
        background-color: #333;
        color: #fff;
        padding: 10px 0;
        text-align: center;
        display: flex;
        justify-content: space-between; /* Распределяем пространство между изображениями */
        align-items: center; /* Центрируем изображения по вертикали */
        flex-wrap: nowrap; /* Запрещаем перенос на новую строку */
    }
    header img {
        max-height: 200px; /* Ограничиваем высоту изображений */
        width: auto; /* Ширина подстраивается автоматически */
        flex: 0 0 auto; /* Запрещаем изображениям растягиваться или сжиматься */
    }
    @media (max-width: 768px) {
        header img {
            flex: 1 1 45%;
        }
    }
    @media (max-width: 480px) {
        header img {
            flex: 1 1 100%;
        }
    }
    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        flex: 1;
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
        padding: 20px 27px 15px 15px; /* Отступы: верх, право, низ, лево */
    }
    .order-panel input[type="text"], .order-panel input[type="number"] {
        width: 98%;
        padding: 8px;
        margin: 5px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .order-panel select {
        width: 100%;
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
        margin-top: auto; /* Прижимаем footer к низу */
    }
    .fixed-gif {
        position: fixed;
        right: 40px;
        top: 50%; /* Начальная позиция по вертикали */
        transform: translateY(-50%); /* Центрирование по вертикали */
        z-index: 1000; /* Убедитесь, что гифка находится поверх других элементов */
        width: 150px; /* Ширина гифки */
        height: auto; /* Высота подстраивается автоматически */
    }
</style>
<script>
    function validateISBN(isbn) {
        // Проверка длины ISBN на 17 символов
        return isbn.length === 17; // ISBN должен состоять из 17 символов
    }

    function validateForm() {
        let title = document.getElementById("title");
        let author = document.getElementById("author");
        let genre = document.getElementById("genre");
        let year = document.getElementById("year");
        let isbn = document.getElementById("isbn");
        let isValid = true;

        // Скрываем предыдущие сообщения об ошибках
        document.querySelectorAll(".error").forEach(function(el) {
            el.style.display = "none";
        });

        // Проверка года издания
        // let yearPattern = /^(0[1-9]|[12][0-9]|3[01])\.(0[1-9]|1[0-2])\.[0-9]{4}$/;
        //if (!yearPattern.test(year.value)) {
        //    document.getElementById("yearError").style.display = "block";
        //    isValid = false;
        //}

        // Проверка ISBN
        if (!validateISBN(isbn.value)) {
            document.getElementById("isbnError").style.display = "block";
            isValid = false;
        }

        // Проверка на начало с цифры
        // if (/^\d/.test(title.value)) {
        //     document.getElementById("titleError").style.display = "block";
        //     isValid = false;
        // }
        if (/^\d/.test(author.value)) {
            document.getElementById("authorError").style.display = "block";
            isValid = false;
        }
        if (/^\d/.test(genre.value)) {
            document.getElementById("genreError").style.display = "block";
            isValid = false;
        }

        return isValid; // Возвращаем результат проверки
    }

    // Привязываем обработчики события на ввод, чтобы скрывать ошибки при корректировке
    window.onload = function() {
        let inputs = document.querySelectorAll(".order-panel input[type='text']");
        inputs.forEach(input => {
            input.addEventListener("input", function() {
                document.querySelectorAll(".error").forEach(el => {
                    el.style.display = "none";
                });
            });
        });
    };
</script>
<title>Добавить книгу</title>
</head>
<body>
<header>
        <img src="images/l.png" alt="Логотип">
        <img src="images/logobooks.png" alt="Логотип">
        <img src="images/r.png" alt="Логотип">
    </header>
    
    
    <div class="container">
        <h1>Добавить книгу</h1>
        <form action="insert_book.php" method="POST" enctype="multipart/form-data" class="order-panel" onsubmit="return validateForm();">
            <label for="title">Название:</label>
            <input type="text" id="title" name="title" required>
            <div class="error" id="titleError">Название не должно начинаться с цифры.</div><br>

            <label for="author">Автор:</label>
            <input type="text" id="author" name="author" required>
            <div class="error" id="authorError">Автор не должен начинаться с цифры.</div><br>

            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn" required>
            <div class="error" id="isbnError">ISBN должен состоять из 17 символов.</div><br>

            <label for="genre">Жанр:</label>
            <select name="genre" id="genre">
                <option value="Фантастика">Фантастика</option>
                <option value="Роман">Роман</option>
                <option value="Мистика">Мистика</option>
            <option value="Детектив">Детектив</option>
            </select><br><br>
            <label for="year">Год издания:</label>
            <input type="text" id="year" name="year" required>
            <div class="error" id="yearError">Введите год издания</div><br>

            <label for="photo">Фото:</label>
            <input type="file" id="photo" name="photo" required><br>

            <input type="submit" class="btn" value="Добавить">
        </form>
    </div>
    <div align="center">
        <a href="Profile.php" class="btn">Назад</a><br><br>
    </div>
    <footer>
        <p>Контактная информация:<br>
        Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)<br>
        Наш режим работы: Понедельник - Воскресенье: 10:00 – 18:00<br>
        Электронная почта: <a href="mailto:BooksForExchange@gmail.com">Напишите нам!</a><br><br>
        &copy; 2025 Все права защищены.</p>
    </footer>
</body>
</html>
