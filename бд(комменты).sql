-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Мар 02 2025 г., 10:02
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
-- Структура таблицы `комментарии`
--

CREATE TABLE `комментарии` (
  `ID` int NOT NULL,
  `Сотрудник_ID` int NOT NULL,
  `Комментарий` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Дата` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `комментарии`
--

INSERT INTO `комментарии` (`ID`, `Сотрудник_ID`, `Комментарий`, `Дата`) VALUES
(2, 1, 'Спасибо за отличный обмен книг! Очень доволен сервисом.', '2025-03-02 14:00:48');

-- --------------------------------------------------------

--
-- Структура таблицы `книги`
--

CREATE TABLE `книги` (
  `ID` int NOT NULL,
  `Название` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Автор` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Жанр` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Год_издания` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `обмен`
--

CREATE TABLE `обмен` (
  `ID` int NOT NULL,
  `Сотрудник_ID` int DEFAULT NULL,
  `Книга_ID` int DEFAULT NULL,
  `Дата_взятия` date DEFAULT NULL,
  `Дата_возврата` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `сотрудники`
--

CREATE TABLE `сотрудники` (
  `ID` int NOT NULL,
  `Имя` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Фамилия` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Телефон` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Статус` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Роль` enum('Пользователь','Администратор') COLLATE utf8mb4_general_ci DEFAULT 'Пользователь'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `сотрудники`
--

INSERT INTO `сотрудники` (`ID`, `Имя`, `Фамилия`, `Email`, `Телефон`, `Статус`, `Роль`) VALUES
(1, 'Никита', 'Сергеевич', 'Nikita@example.com', '870111111', 'Активный', 'Администратор'),
(2, 'Дарья', 'Гринцова', 'Grin@example.com', '87200000', 'Активный', 'Пользователь'),
(3, 'Антон', 'Дедков', 'Dedkov@example.com', '87300000', 'Активный', 'Пользователь'),
(4, 'Юлия', 'Куркина', 'Kurkina@example.com', '87400004', 'Активный', 'Пользователь'),
(5, 'Глеб', 'Мамыкин', 'Mamykin@example.com', '87500000', 'Активный', 'Пользователь'),
(6, 'Александр', 'Апарин', 'Aparin@example.com', '87600000', 'Активный', 'Пользователь'),
(7, 'Айсултан', 'Жанатов', 'Zhanatov@example.com', '87700000', 'Активный', 'Пользователь');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `комментарии`
--
ALTER TABLE `комментарии`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Сотрудник_ID` (`Сотрудник_ID`);

--
-- Индексы таблицы `книги`
--
ALTER TABLE `книги`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `обмен`
--
ALTER TABLE `обмен`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Сотрудник_ID` (`Сотрудник_ID`),
  ADD KEY `Книга_ID` (`Книга_ID`);

--
-- Индексы таблицы `сотрудники`
--
ALTER TABLE `сотрудники`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `комментарии`
--
ALTER TABLE `комментарии`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `книги`
--
ALTER TABLE `книги`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `обмен`
--
ALTER TABLE `обмен`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `сотрудники`
--
ALTER TABLE `сотрудники`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `комментарии`
--
ALTER TABLE `комментарии`
  ADD CONSTRAINT `комментарии_ibfk_1` FOREIGN KEY (`Сотрудник_ID`) REFERENCES `сотрудники` (`ID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `обмен`
--
ALTER TABLE `обмен`
  ADD CONSTRAINT `обмен_ibfk_1` FOREIGN KEY (`Сотрудник_ID`) REFERENCES `сотрудники` (`ID`),
  ADD CONSTRAINT `обмен_ibfk_2` FOREIGN KEY (`Книга_ID`) REFERENCES `книги` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
