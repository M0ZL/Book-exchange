-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Фев 23 2025 г., 23:12
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
-- База данных: `обмен с книгами`
--

-- --------------------------------------------------------

--
-- Структура таблицы `сотрудники`
--

CREATE TABLE `сотрудники` (
  `ID` int NOT NULL,
  `Имя` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Фамилия` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Телефон` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `сотрудники`
--

INSERT INTO `сотрудники` (`ID`, `Имя`, `Фамилия`, `Email`, `Телефон`) VALUES
(1, 'Никита', 'Сергеевич', 'Nikita@example.com', '1234567890'),
(2, 'Дарья', 'Гринцова', 'Grin@example.com', '0987654321'),
(3, 'Антон', 'Дедков', 'Dedkov@example.com', '1122334455'),
(4, 'Юлия', 'Куркина', 'Kurkina@example.com', '2233445566'),
(5, 'Глеб', 'Мамыкин', 'Mamykin@example.com', '3344556677'),
(6, 'Александр', 'Апарин', 'Aparin@example.com', '4455667788'),
(7, 'Айсултан', 'Жанатов', 'Zhanatov@example.com', '5566778899');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `сотрудники`
--
ALTER TABLE `сотрудники`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `сотрудники`
--
ALTER TABLE `сотрудники`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
