-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Мар 05 2025 г., 13:17
-- Версия сервера: 8.0.39
-- Версия PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `книги`
--

-- --------------------------------------------------------

--
-- Структура таблицы `книги`
--

CREATE TABLE `книги` (
  `книга_id` int NOT NULL,
  `пользователь_id` int DEFAULT NULL,
  `isbn` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `название` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `автор` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `статус` enum('доступна','обменяна') COLLATE utf8mb4_general_ci NOT NULL,
  `дата_добавления` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `пользователи`
--

CREATE TABLE `пользователи` (
  `пользователь_id` int NOT NULL,
  `имя_пользователя` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `электронная_почта` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `пароль` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `роль` enum('гость','участник','администратор') COLLATE utf8mb4_general_ci NOT NULL,
  `рейтинг` int DEFAULT '0',
  `дата_регистрации` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `заявки_на_обмен`
--

CREATE TABLE `заявки_на_обмен` (
  `заявка_id` int NOT NULL,
  `пользователь_id` int DEFAULT NULL,
  `книга_id` int DEFAULT NULL,
  `параметры_поиска` text COLLATE utf8mb4_general_ci,
  `статус` enum('ожидание','завершена','отменена') COLLATE utf8mb4_general_ci NOT NULL,
  `дата_создания` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `обмены`
--

CREATE TABLE `обмены` (
  `обмен_id` int NOT NULL,
  `заявка_id` int DEFAULT NULL,
  `предложенная_книга_id` int DEFAULT NULL,
  `трек_номер` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `статус` enum('ожидание','получена','завершена') COLLATE utf8mb4_general_ci NOT NULL,
  `дата_создания` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `отзывы`
--

CREATE TABLE `отзывы` (
  `отзыв_id` int NOT NULL,
  `пользователь_id` int DEFAULT NULL,
  `обмен_id` int DEFAULT NULL,
  `оценка` int DEFAULT NULL,
  `комментарий` text COLLATE utf8mb4_general_ci,
  `дата_создания` datetime DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Структура таблицы `сообщения`
--

CREATE TABLE `сообщения` (
  `сообщение_id` int NOT NULL,
  `отправитель_id` int DEFAULT NULL,
  `получатель_id` int DEFAULT NULL,
  `содержание` text COLLATE utf8mb4_general_ci NOT NULL,
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
  MODIFY `книга_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `пользователи`
--
ALTER TABLE `пользователи`
  MODIFY `пользователь_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `заявки_на_обмен`
--
ALTER TABLE `заявки_на_обмен`
  MODIFY `заявка_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `обмены`
--
ALTER TABLE `обмены`
  MODIFY `обмен_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `отзывы`
--
ALTER TABLE `отзывы`
  MODIFY `отзыв_id` int NOT NULL AUTO_INCREMENT;

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
