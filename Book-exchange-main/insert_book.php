<?php
session_start();

if (!isset($_SESSION['пользователь_id'])) {
    echo "<script>location.replace('Entry.php');</script>"; // Перенаправляем на страницу входа, если пользователь не авторизован
    exit();
}

$user_id = $_SESSION['пользователь_id'];

$dbuser = 'mysql';
$dbpass = 'mysql';
$dbserver = 'localhost';
$dbname = 'book';

// Подключаемся к базе данных
$conn = new mysqli($dbserver, $dbuser, $dbpass, $dbname); 

// Проверяем соединение
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем данные из формы
$название = $conn->real_escape_string($_POST['title']);
$автор = $conn->real_escape_string($_POST['author']);
$isbn = $conn->real_escape_string($_POST['isbn']);
$жанр = $conn->real_escape_string($_POST['genre']);
$год_издания = intval($_POST['year']);
$пользователь_id = $_SESSION['пользователь_id'];

// Проверка на наличие одинакового ISBN
$isbn_check_query = "SELECT * FROM книги WHERE isbn='$isbn'";
$result = $conn->query($isbn_check_query);

if ($result->num_rows > 0) {
    echo "Книга с таким ISBN уже существует.";
} else {
    // Обработка загрузки фото
    $фото = $_FILES['photo']['name'];
    $target_dir = "images/"; // Директория для сохранения фото
    $target_file = $target_dir . basename($фото);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Проверка на наличие изображений
    if (isset($_POST['submit'])) {
        $check = getimagesize($_FILES['photo']['tmp_name']);
        if ($check !== false) {
            echo "Файл - изображение. ";
        } else {
            echo "Файл не является изображением. ";
            $uploadOk = 0;
        }
    }

    // // Проверка на существование файла
    // if (file_exists($target_file)) {
    //     echo "Извините, файл уже существует.";
    //     $uploadOk = 0;
    // }

    // Ограничение на размер файла
    if ($_FILES['photo']['size'] > 500000) {
        echo "Извините, файл слишком большой.";
        $uploadOk = 0;
    }

    // Допустимые форматы файла
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Извините, только JPG, JPEG, PNG & GIF файлы разрешены.";
        $uploadOk = 0;
    }

    // Проверка на успешность загрузки файла
    if ($uploadOk == 0) {
        echo "Извините, файл не был загружен.";
    } else {
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            // Вставка книги в базу данных только с путем к фото
            $sql = "INSERT INTO книги (название, автор, isbn, жанр, год_издания, фото, пользователь_id) 
                    VALUES ('$название', '$автор', '$isbn', '$жанр', '$год_издания', '$target_file', '$пользователь_id')";
            
            if ($conn->query($sql) === TRUE) {
                header("Location: MyBooks.php");
                exit();
            } else {
                echo "Ошибка: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Извините, произошла ошибка при загрузке вашего файла.";
        }
    }
}

// Закрытие соединения
$conn->close();
?>