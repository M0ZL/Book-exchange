<?php
    session_start(); // Начинаем сессию

    // Очищаем все данные сессии
    $_SESSION = array();

    // Если необходимо уничтожить сессию, также удаляем сессионные cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Уничтожаем сессию
    session_destroy();

    // Очищаем кеш браузера
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Дата в прошлом

    // Перенаправляем пользователя на главную страницу или страницу входа
    header("Location: index.php");
    exit();
?>