<?php
session_start(); // Начинаем сессию

// Проверяем, обновлен ли пароль в сессии
if (isset($_SESSION['user_pass'])) {
    // Если пароль был обновлен, обновляем куки
    if (isset($_COOKIE['pass']) && $_COOKIE['pass'] !== $_SESSION['user_pass']) {
        setcookie('pass', $_SESSION['user_pass'], time() + 60 * 60 * 24 * 30, '/');
    }
}

// Проверяем, выбрал ли пользователь "Запомнить меня" при входе
if (!isset($_SESSION['remember_me']) || $_SESSION['remember_me'] !== true) {
    // Если "Запомнить меня" не выбрано, удаляем куки
    setcookie('login', '', time() - 3600, '/');
    setcookie('pass', '', time() - 3600, '/');
    setcookie('last_activity', '', time() - 3600, '/');
} else {
    // Если "Запомнить меня" выбрано, сохраняем куки на 30 дней
    if (isset($_SESSION['logged_user'])) {
        setcookie('login', $_SESSION['logged_user'], time() + 60 * 60 * 24 * 30, '/'); // Сохраняем логин
        setcookie('pass', $_SESSION['user_pass'], time() + 60 * 60 * 24 * 30, '/'); // Сохраняем пароль
        setcookie('last_activity', time(), time() + 60 * 60 * 24 * 30, '/'); // Сохраняем время последней активности
    }
}

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
