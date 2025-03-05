-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 05 2025 г., 20:59
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

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
-- Структура таблицы `комментарии`
--

CREATE TABLE `комментарии` (
  `ID` int(11) NOT NULL,
  `Сотрудник_ID` int(11) NOT NULL,
  `Комментарий` text NOT NULL,
  `Дата` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `комментарии`
--

INSERT INTO `комментарии` (`ID`, `Сотрудник_ID`, `Комментарий`, `Дата`) VALUES
(2, 1, 'Спасибо за отличный обмен книг! Очень доволен сервисом.', '2025-03-02'),
(3, 2, 'Отличный сервис!', '2025-03-04');

-- --------------------------------------------------------

--
-- Структура таблицы `книги`
--

CREATE TABLE `книги` (
  `ID` int(11) NOT NULL,
  `Название` varchar(255) NOT NULL,
  `ISBN` varchar(100) DEFAULT NULL,
  `Фото` text NOT NULL,
  `Автор` varchar(100) DEFAULT NULL,
  `Жанр` varchar(50) DEFAULT NULL,
  `Год_издания` int(11) DEFAULT NULL,
  `Наличие` enum('Есть','Нет') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `книги`
--

INSERT INTO `книги` (`ID`, `Название`, `ISBN`, `Фото`, `Автор`, `Жанр`, `Год_издания`, `Наличие`) VALUES
(1, 'Война и мир', '978-5-17-118103-1', '/images/1.jpg', 'Л.Н. Толстой ', 'Роман-эпопея', 1869, 'Есть'),
(2, 'Уличный кот по имени Боб. Как человек и кот обрели надежду на улицах Лондона', '978-5-386-10742-0', '/images/2.webp', 'Джеймс Боуэн', 'Роман', 2018, 'Есть'),
(3, 'Дикий зверь', '978-5-17-163435-3', '/images/3.webp', 'Жоэль Диккер', 'Роман', 2025, 'Есть'),
(4, 'The Book. Как создать цивилизацию заново', '978-5-00214-025-1', '/images/4.webp', 'Коллектив авторов', NULL, 2023, 'Есть'),
(5, 'Египетская «Книга мертвых»', '978-5-00195-984-7', '/images/5.webp', 'Коллектив авторов', 'Мифы и легенды', 2024, 'Есть');

-- --------------------------------------------------------

--
-- Структура таблицы `пользователи`
--

CREATE TABLE `пользователи` (
  `ID` int(11) NOT NULL,
  `Имя` varchar(100) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Пароль` varchar(255) NOT NULL,
  `Дата_регистрации` datetime DEFAULT current_timestamp(),
  `Статус` varchar(50) DEFAULT 'Активный'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `предложения`
--

CREATE TABLE `предложения` (
  `ID` int(11) NOT NULL,
  `Пользователь_ID` int(11) NOT NULL,
  `Книга_ID` int(11) NOT NULL,
  `Дата_предложения` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `заявки_на_обмен`
--

CREATE TABLE `заявки_на_обмен` (
  `ID` int(11) NOT NULL,
  `Пользователь_ID` int(11) NOT NULL,
  `Книга_для_обмена_ID` int(11) NOT NULL,
  `Книга_в_обмен_ID` int(11) NOT NULL,
  `Дата_заявки` datetime DEFAULT current_timestamp(),
  `Статус` enum('Ожидает','Принята','Отклонена') DEFAULT 'Ожидает'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `обмен`
--

CREATE TABLE `обмен` (
  `ID` int(11) NOT NULL,
  `Сотрудник_ID` int(11) DEFAULT NULL,
  `Книга_ID` int(11) DEFAULT NULL,
  `Дата_взятия` date DEFAULT NULL,
  `Дата_возврата` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `сотрудники`
--

CREATE TABLE `сотрудники` (
  `ID` int(11) NOT NULL,
  `логин` varchar(255) NOT NULL,
  `пароль` varchar(255) NOT NULL,
  `Имя` varchar(100) DEFAULT NULL,
  `Фамилия` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Телефон` varchar(15) DEFAULT NULL,
  `Статус` varchar(50) DEFAULT NULL,
  `Роль` enum('Пользователь','Администратор') DEFAULT 'Пользователь'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `сотрудники`
--

INSERT INTO `сотрудники` (`ID`, `логин`, `пароль`, `Имя`, `Фамилия`, `Email`, `Телефон`, `Статус`, `Роль`) VALUES
(1, '123', '123', 'Никита', 'Лавренко', 'Nikita@example.com', '+77011111111', 'Активный', 'Администратор'),
(2, '456', '456', 'Дарья', 'Гринцова', 'Grin@example.com', '+77200000000', 'Активный', 'Пользователь'),
(3, '789', '789', 'Антон', 'Дедков', 'Dedkov@example.com', '+77300000000', 'Активный', 'Пользователь'),
(4, '4444', '4444', 'Юлия', 'Куркина', 'Kurkina@example.com', '+77400004589', 'Активный', 'Пользователь'),
(5, '8888', '8888', 'Глеб', 'Мамыкин', 'Mamykin@example.com', '+77500000893', 'Активный', 'Пользователь'),
(6, '6969', '6969', 'Александр', 'Апарин', 'Aparin@example.com', '+77600000000', 'Активный', 'Пользователь'),
(7, '5151', '5151', 'Айсултан', 'Жанатов', 'Zhanatov@example.com', '+77700000231', 'Активный', 'Пользователь');

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
-- Индексы таблицы `пользователи`
--
ALTER TABLE `пользователи`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `предложения`
--
ALTER TABLE `предложения`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Пользователь_ID` (`Пользователь_ID`),
  ADD KEY `Книга_ID` (`Книга_ID`);

--
-- Индексы таблицы `заявки_на_обмен`
--
ALTER TABLE `заявки_на_обмен`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Пользователь_ID` (`Пользователь_ID`),
  ADD KEY `Книга_для_обмена_ID` (`Книга_для_обмена_ID`),
  ADD KEY `Книга_в_обмен_ID` (`Книга_в_обмен_ID`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `книги`
--
ALTER TABLE `книги`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `пользователи`
--
ALTER TABLE `пользователи`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `предложения`
--
ALTER TABLE `предложения`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `заявки_на_обмен`
--
ALTER TABLE `заявки_на_обмен`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `обмен`
--
ALTER TABLE `обмен`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `сотрудники`
--
ALTER TABLE `сотрудники`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `комментарии`
--
ALTER TABLE `комментарии`
  ADD CONSTRAINT `комментарии_ibfk_1` FOREIGN KEY (`Сотрудник_ID`) REFERENCES `сотрудники` (`ID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `предложения`
--
ALTER TABLE `предложения`
  ADD CONSTRAINT `предложения_ibfk_1` FOREIGN KEY (`Пользователь_ID`) REFERENCES `пользователи` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `предложения_ibfk_2` FOREIGN KEY (`Книга_ID`) REFERENCES `книги` (`ID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `заявки_на_обмен`
--
ALTER TABLE `заявки_на_обмен`
  ADD CONSTRAINT `заявки_на_обмен_ibfk_1` FOREIGN KEY (`Пользователь_ID`) REFERENCES `пользователи` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `заявки_на_обмен_ibfk_2` FOREIGN KEY (`Книга_для_обмена_ID`) REFERENCES `книги` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `заявки_на_обмен_ibfk_3` FOREIGN KEY (`Книга_в_обмен_ID`) REFERENCES `книги` (`ID`) ON DELETE CASCADE;

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
