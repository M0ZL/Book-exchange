-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Мар 06 2025 г., 05:34
-- Версия сервера: 8.0.39
-- Версия PHP: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `book`
--

-- --------------------------------------------------------

--
-- Структура таблицы `книги`
--

CREATE TABLE `книги` (
  `книга_id` int NOT NULL,
  `пользователь_id` int DEFAULT NULL,
  `isbn` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `название` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `автор` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `статус` enum('доступна','обменяна') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `дата_добавления` datetime DEFAULT CURRENT_TIMESTAMP,
  `жанр` text COLLATE utf8mb4_general_ci NOT NULL,
  `год_издания` date NOT NULL,
  `фото` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `книги`
--

INSERT INTO `книги` (`книга_id`, `пользователь_id`, `isbn`, `название`, `автор`, `статус`, `дата_добавления`, `жанр`, `год_издания`, `фото`) VALUES
(2, 1, '123', 'test', 'net', 'доступна', '2025-03-06 00:59:25', 'mistic', '2025-03-07', 'images/1.jpg'),
(3, 1, '22222', 'pupa', 'zapupa', 'доступна', '2025-03-06 01:11:36', 'uwu', '2025-03-02', 'images/1.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `пользователи`
--

CREATE TABLE `пользователи` (
  `пользователь_id` int NOT NULL,
  `имя_пользователя` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `электронная_почта` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `пароль` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `роль` enum('гость','участник','администратор') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `рейтинг` int DEFAULT '0',
  `дата_регистрации` datetime DEFAULT CURRENT_TIMESTAMP,
  `фамилия` text COLLATE utf8mb4_general_ci NOT NULL,
  `имя` text COLLATE utf8mb4_general_ci NOT NULL,
  `отчество` text COLLATE utf8mb4_general_ci NOT NULL,
  `адрес` text COLLATE utf8mb4_general_ci NOT NULL,
  `возраст` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `пользователи`
--

INSERT INTO `пользователи` (`пользователь_id`, `имя_пользователя`, `электронная_почта`, `пароль`, `роль`, `рейтинг`, `дата_регистрации`, `фамилия`, `имя`, `отчество`, `адрес`, `возраст`) VALUES
(1, 'test1', 'dedkovanton20@yandex.ru', '123', 'гость', 0, '2025-03-06 00:06:23', 'Дедков', 'Антон', 'Геннадьевичь', '446660, обл. Самарская, р-н. Борский, с. Борское, ул. Песочная, д. 1', 21);

-- --------------------------------------------------------

--
-- Структура таблицы `заявки_на_обмен`
--

CREATE TABLE `заявки_на_обмен` (
  `заявка_id` int NOT NULL,
  `пользователь_id` int DEFAULT NULL,
  `книга_id` int DEFAULT NULL,
  `параметры_поиска` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `статус` enum('ожидание','завершена','отменена') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `дата_создания` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `заявки_на_обмен`
--

INSERT INTO `заявки_на_обмен` (`заявка_id`, `пользователь_id`, `книга_id`, `параметры_поиска`, `статус`, `дата_создания`) VALUES
(2, 1, 2, NULL, 'ожидание', '2025-03-06 01:00:06');

-- --------------------------------------------------------

--
-- Структура таблицы `обмены`
--

CREATE TABLE `обмены` (
  `обмен_id` int NOT NULL,
  `заявка_id` int DEFAULT NULL,
  `предложенная_книга_id` int DEFAULT NULL,
  `трек_номер` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `статус` enum('ожидание','получена','завершена') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `дата_создания` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `обмены`
--

INSERT INTO `обмены` (`обмен_id`, `заявка_id`, `предложенная_книга_id`, `трек_номер`, `статус`, `дата_создания`) VALUES
(2, 2, 2, '5555', 'ожидание', '2025-03-06 01:00:18');

-- --------------------------------------------------------

--
-- Структура таблицы `отзывы`
--

CREATE TABLE `отзывы` (
  `отзыв_id` int NOT NULL,
  `пользователь_id` int DEFAULT NULL,
  `обмен_id` int DEFAULT NULL,
  `оценка` int DEFAULT NULL,
  `комментарий` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `дата_создания` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `отзывы`
--

INSERT INTO `отзывы` (`отзыв_id`, `пользователь_id`, `обмен_id`, `оценка`, `комментарий`, `дата_создания`) VALUES
(2, 1, 2, 5, 'tupo', '2025-03-06 01:00:35');

-- --------------------------------------------------------

--
-- Структура таблицы `сообщения`
--

CREATE TABLE `сообщения` (
  `сообщение_id` int NOT NULL,
  `отправитель_id` int DEFAULT NULL,
  `получатель_id` int DEFAULT NULL,
  `содержание` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `дата_отправки` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `книги`
--
ALTER TABLE `книги`
  ADD PRIMARY KEY (`книга_id`),
  ADD KEY `пользователь_id` (`пользователь_id`);

--
-- Индексы таблицы `пользователи`
--
ALTER TABLE `пользователи`
  ADD PRIMARY KEY (`пользователь_id`),
  ADD UNIQUE KEY `электронная_почта` (`электронная_почта`);

--
-- Индексы таблицы `заявки_на_обмен`
--
ALTER TABLE `заявки_на_обмен`
  ADD PRIMARY KEY (`заявка_id`),
  ADD KEY `пользователь_id` (`пользователь_id`),
  ADD KEY `книга_id` (`книга_id`);

--
-- Индексы таблицы `обмены`
--
ALTER TABLE `обмены`
  ADD PRIMARY KEY (`обмен_id`),
  ADD KEY `заявка_id` (`заявка_id`),
  ADD KEY `предложенная_книга_id` (`предложенная_книга_id`);

--
-- Индексы таблицы `отзывы`
--
ALTER TABLE `отзывы`
  ADD PRIMARY KEY (`отзыв_id`),
  ADD KEY `пользователь_id` (`пользователь_id`),
  ADD KEY `обмен_id` (`обмен_id`);

--
-- Индексы таблицы `сообщения`
--
ALTER TABLE `сообщения`
  ADD PRIMARY KEY (`сообщение_id`),
  ADD KEY `отправитель_id` (`отправитель_id`),
  ADD KEY `получатель_id` (`получатель_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `книги`
--
ALTER TABLE `книги`
  MODIFY `книга_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `пользователи`
--
ALTER TABLE `пользователи`
  MODIFY `пользователь_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `заявки_на_обмен`
--
ALTER TABLE `заявки_на_обмен`
  MODIFY `заявка_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `обмены`
--
ALTER TABLE `обмены`
  MODIFY `обмен_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `отзывы`
--
ALTER TABLE `отзывы`
  MODIFY `отзыв_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `сообщения`
--
ALTER TABLE `сообщения`
  MODIFY `сообщение_id` int NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `книги`
--
ALTER TABLE `книги`
  ADD CONSTRAINT `книги_ibfk_1` FOREIGN KEY (`пользователь_id`) REFERENCES `пользователи` (`пользователь_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `заявки_на_обмен`
--
ALTER TABLE `заявки_на_обмен`
  ADD CONSTRAINT `заявки_на_обмен_ibfk_1` FOREIGN KEY (`пользователь_id`) REFERENCES `пользователи` (`пользователь_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `заявки_на_обмен_ibfk_2` FOREIGN KEY (`книга_id`) REFERENCES `книги` (`книга_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `обмены`
--
ALTER TABLE `обмены`
  ADD CONSTRAINT `обмены_ibfk_1` FOREIGN KEY (`заявка_id`) REFERENCES `заявки_на_обмен` (`заявка_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `обмены_ibfk_2` FOREIGN KEY (`предложенная_книга_id`) REFERENCES `книги` (`книга_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `отзывы`
--
ALTER TABLE `отзывы`
  ADD CONSTRAINT `отзывы_ibfk_1` FOREIGN KEY (`пользователь_id`) REFERENCES `пользователи` (`пользователь_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `отзывы_ibfk_2` FOREIGN KEY (`обмен_id`) REFERENCES `обмены` (`обмен_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `сообщения`
--
ALTER TABLE `сообщения`
  ADD CONSTRAINT `сообщения_ibfk_1` FOREIGN KEY (`отправитель_id`) REFERENCES `пользователи` (`пользователь_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `сообщения_ibfk_2` FOREIGN KEY (`получатель_id`) REFERENCES `пользователи` (`пользователь_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
