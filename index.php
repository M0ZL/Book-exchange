<?php
session_start();
$c = $_GET['c'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <style type="text/css">
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
            padding: 10px 0;
            text-align: center;
        }
        header img {
            max-width: 100%;
            height: auto;
        }
        nav {
            display: flex;
            justify-content: center;
            background-color: #444;
            padding: 10px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        nav a:hover {
            background-color: #555;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .carousel {
            position: relative;
            width: 100%;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .carousel img {
            width: 100%;
            height: auto;
        }
        .carousel-control {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 10px;
            cursor: pointer;
            border-radius: 50%;
            user-select: none;
        }
        .carousel-control.prev {
            left: 10px;
        }
        .carousel-control.next {
            right: 10px;
        }
        .tbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .tbl td, .tbl th {
            border: 1px solid #ddd;
            padding: 8px;
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
        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
            margin-top: 20px;
        }
		.carousel {
    position: relative;
    width: 100%;
    overflow: hidden;
    margin-bottom: 20px;
}

.carousel-inner {
    display: flex;
    transition: transform 0.5s ease-in-out; /* Плавный переход */
}

.carousel-item {
    min-width: 100%; /* Каждый слайд занимает 100% ширины */
    box-sizing: border-box;
}

.carousel-control {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: #fff;
    padding: 10px;
    cursor: pointer;
    border-radius: 50%;
    user-select: none;
    z-index: 10;
}

.carousel-control.prev {
    left: 10px;
}

.carousel-control.next {
    right: 10px;
}
    </style>
</head>
<body>
    <header>
        <img src="images/logobooks.png" alt="Логотип">
    </header>
    <nav>
        <a href="index.php">Новости</a>
        <a href="index.php">Обратная связь</a>
        <a href="index.php">О нас</a>
        <a href="index.php">Вакансии</a>
        <a href="index.php">Схема проезда</a>
        <a href="index.php">Справочная информация</a>
        <a href="index.php">Доставка</a>
        <a href="index.php">Сертификаты</a>
        <a href="index.php">Прайс-лист</a>
        <a href="index.php">Политика конфиденциальности</a>
        <a href="index.php">История фирмы</a>
    </nav>
    <div class="container">
    <div class="carousel">
        <div class="carousel-inner">
            <img src="images/books1.jpg" alt="Книги 1" class="carousel-item">
            <img src="images/books2.jpg" alt="Книги 2" class="carousel-item">
            <img src="images/books3.jpg" alt="Книги 3" class="carousel-item">
            <img src="images/books4.jpg" alt="Книги 4" class="carousel-item">
            <img src="images/books5.jpg" alt="Книги 5" class="carousel-item">
        </div>
        <div class="carousel-control prev" onclick="prevSlide()">&#10094;</div>
        <div class="carousel-control next" onclick="nextSlide()">&#10095;</div>
    </div>
</div>
		<script>
    let currentSlide = 0;
const carouselInner = document.querySelector('.carousel-inner');
const slides = document.querySelectorAll('.carousel-item');
const totalSlides = slides.length;

// Функция для перехода к конкретному слайду
function goToSlide(index) {
    if (index < 0) {
        index = totalSlides - 1; // Переход к последнему слайду, если индекс меньше 0
    } else if (index >= totalSlides) {
        index = 0; // Переход к первому слайду, если индекс больше общего количества
    }
    currentSlide = index;
    const offset = -currentSlide * 100; // Сдвиг на 100% ширины для каждого слайда
    carouselInner.style.transform = `translateX(${offset}%)`;
}

// Функция для перехода к предыдущему слайду
function prevSlide() {
    goToSlide(currentSlide - 1);
}

// Функция для перехода к следующему слайду
function nextSlide() {
    goToSlide(currentSlide + 1);
}

// Автоматическая смена слайдов
function autoSlide() {
    nextSlide();
}

// Показываем первый слайд при загрузке страницы
goToSlide(currentSlide);

// Запускаем автоматическую смену слайдов
setInterval(autoSlide, 5000); // Интервал 5000 мс (5 секунд)
</script>
        <?php
        if(isset($_SESSION['logged_user'])){
            echo '
            <div align="right">
                <a href="Profile.php" class="btn">Личный аккаунт</a>
                <a href="Logout.php" class="btn">Выйти из аккаунта</a>
            </div>';
        } else {
            echo '
            <div align="right">
                <a href="Entry.php" class="btn">Вход</a>
                <a href="Registration.php" class="btn">Регистрация</a>
            </div>';
        }
        ?>
        <h2>Книги для обмена:</h2>
        <table class="tbl">
            <?php
            $dbuser = 'mysql';
            $dbpass = 'mysql';
            $dbserver = 'localhost';
            $dbname = '';
            $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
            or die ('Ошибка ' . mysqli_error($mysql));
            $query1 = mysqli_query($mysql, "SELECT Name, Image, Image2, Price FROM products LIMIT 0, 3");
            while($row=mysqli_fetch_array($query1)) {
                echo "<tr><td><b>" .  $row['Name'], "</b></br><br><a href='{$row['Image2']}'><img width='350' height='300' src='{$row['Image']}' /></a></br> Цена: ",
                $row['Price'], " руб.</br>" . "<br />" . "</td></tr>";
            }
            mysqli_close($mysql);
            ?>
        </table>
        <a href="Books.php" class="btn">Полный список книг для обмена</a>
        <h2>Последние новости:</h2>
        <?php
        $mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
        or die ('Ошибка ' . mysqli_error($mysql));
        $query1 = mysqli_query($mysql, "SELECT Name_news, Description, Date_news FROM news Order by Date_news desc LIMIT 0, 3");
        while($row=mysqli_fetch_array($query1)) {
            echo "
            <div class='news-item'>
                <h3>" .  $row['Name_news'],"</h3>
                <p>", $row['Description'],"</p>
                <h5>Дата публикации: ", $row['Date_news'],"</h5>
            </div>";
        }
        mysqli_close($mysql);
        ?>
        <a href="index.php" class="btn">Все новости</a>
    </div>
    <footer>
        <p>Контактная информация:</p>
        <p>Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)</p>
        <p>Наш режим работы:</p>
        <p>Понедельник - Воскресенье: 10:00 – 18:00</p>
        <a href="index.php" class="btn">Вакансии</a>
        <a href="index.php" class="btn">Политика конфиденциальности</a>
        <p>Электронная почта: <a href="mailto:BooksForExchange@gmail.com">Напишите нам!</a></p>
        <p><? echo "Сайт посетили уже ".sprintf ("%0"."$digits"."d",$content)." человек!";?></p>
    </footer>
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel img');
        const totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.display = i === index ? 'block' : 'none';
            });
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(currentSlide);
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }

        showSlide(currentSlide);
    </script>
</body>
</html>
