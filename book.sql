-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 09 2025 г., 21:09
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
-- Структура таблицы `книги`
--

CREATE TABLE `книги` (
  `книга_id` int(11) NOT NULL,
  `пользователь_id` int(11) NOT NULL,
  `isbn` varchar(100) DEFAULT NULL,
  `название` varchar(255) NOT NULL,
  `автор` varchar(255) DEFAULT NULL,
  `статус` enum('доступна','обменяна') NOT NULL,
  `дата_добавления` date DEFAULT current_timestamp(),
  `жанр` varchar(255) DEFAULT NULL,
  `год_издания` int(11) DEFAULT NULL,
  `фото` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `книги`
--

INSERT INTO `книги` (`книга_id`, `пользователь_id`, `isbn`, `название`, `автор`, `статус`, `дата_добавления`, `жанр`, `год_издания`, `фото`) VALUES
(2, 1, '978-5-17-118103-1', 'Война и мир', 'Л.Н. Толстой', 'доступна', '2025-03-06', 'Роман-эпопея', 1869, 'images/1.jpg'),
(3, 4, '978-5-386-10742-0', 'Уличный кот по имени Боб. Как человек и кот обрели надежду на улицах Лондона', 'Джеймс Боуэн', 'доступна', '2025-03-06', 'Роман', 2018, 'images/2.webp'),
(4, 3, '978-5-17-163435-3', 'Дикий зверь', 'Жоэль Диккер', 'доступна', '2025-03-04', 'Роман', 2025, '/images/3.webp'),
(5, 2, '978-5-00214-025-1', 'The Book. Как создать цивилизацию заново', 'Коллектив авторов', 'доступна', '2025-03-05', NULL, 2023, '/images/4.webp'),
(6, 6, '978-5-00195-984-7', 'Египетская «Книга мертвых»', 'Коллектив авторов', 'доступна', '2025-03-02', 'Мифы и легенды', 2024, '/images/5.webp');

-- --------------------------------------------------------

--
-- Структура таблицы `пользователи`
--

CREATE TABLE `пользователи` (
  `пользователь_id` int(11) NOT NULL,
  `ник_пользователя` varchar(255) NOT NULL,
  `электронная_почта` varchar(255) NOT NULL,
  `пароль` varchar(255) NOT NULL,
  `роль` enum('участник','администратор') NOT NULL,
  `рейтинг` int(11) DEFAULT 0,
  `дата_регистрации` date DEFAULT current_timestamp(),
  `фамилия` varchar(100) NOT NULL,
  `имя` varchar(100) NOT NULL,
  `отчество` varchar(100) DEFAULT NULL,
  `адрес` varchar(255) DEFAULT NULL,
  `телефон` varchar(15) NOT NULL,
  `возраст` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `пользователи`
--

INSERT INTO `пользователи` (`пользователь_id`, `ник_пользователя`, `электронная_почта`, `пароль`, `роль`, `рейтинг`, `дата_регистрации`, `фамилия`, `имя`, `отчество`, `адрес`, `телефон`, `возраст`) VALUES
(1, 'test1', 'dedkovanton20@yandex.ru', '123', 'участник', 0, '2025-03-06', 'Дедков', 'Антон', 'Геннадьевич', '446660, обл. Самарская, р-н. Борский, с. Борское, ул. Песочная, д. 1', '+7701111111', 21),
(2, 'test2', 'Nikita@example.com', '789', 'администратор', 0, '2025-03-01', 'Лавренко', 'Никита', NULL, NULL, '+77200000000', 22),
(3, 'test3', 'Grin@example.com', '456', 'участник', 0, '2025-03-05', 'Гринцова', 'Дарья', 'Витальевна', NULL, '+77300000000', 23),
(4, 'test4', 'Kurkina@example.com', '4444', 'участник', 0, '2025-03-05', 'Куркина', 'Юлия', NULL, NULL, '+77400004589', 22),
(5, 'test5', 'Mamykin@example.com', '8888', 'участник', 0, '2025-03-05', 'Мамыкин', 'Глеб', 'Павлович', NULL, '+77500000893', 23),
(6, 'test6', 'Aparin@example.com', '6969', 'участник', 0, '2025-03-05', 'Апарин', 'Александр', NULL, NULL, '+77600000000', 23),
(7, 'test7', 'Zhanatov@example.com', '5151', 'участник', 0, '2025-03-05', 'Жанатов', 'Айсултан', NULL, NULL, '+77700000231', 22);

-- --------------------------------------------------------

--
-- Структура таблицы `заявки_на_обмен`
--

CREATE TABLE `заявки_на_обмен` (
  `заявка_id` int(11) NOT NULL,
  `пользователь_id` int(11) DEFAULT NULL,
  `книга_id` int(11) DEFAULT NULL,
  `параметры_поиска` text DEFAULT NULL,
  `статус` enum('ожидание','завершена','отменена') NOT NULL,
  `дата_создания` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `заявки_на_обмен`
--

INSERT INTO `заявки_на_обмен` (`заявка_id`, `пользователь_id`, `книга_id`, `параметры_поиска`, `статус`, `дата_создания`) VALUES
(2, 1, 2, NULL, 'ожидание', '2025-03-06');

-- --------------------------------------------------------

--
-- Структура таблицы `обмены`
--

CREATE TABLE `обмены` (
  `обмен_id` int(11) NOT NULL,
  `заявка_id` int(11) DEFAULT NULL,
  `предложенная_книга_id` int(11) DEFAULT NULL,
  `трек_номер` varchar(50) DEFAULT NULL,
  `статус` enum('ожидание','получена','завершена') NOT NULL,
  `дата_создания` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `отзыв_id` int(11) NOT NULL,
  `пользователь_id` int(11) DEFAULT NULL,
  `обмен_id` int(11) DEFAULT NULL,
  `оценка` int(11) DEFAULT NULL,
  `комментарий` text DEFAULT NULL,
  `дата_создания` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `отзывы`
--

INSERT INTO `отзывы` (`отзыв_id`, `пользователь_id`, `обмен_id`, `оценка`, `комментарий`, `дата_создания`) VALUES
(2, 1, 2, 5, 'Спасибо за отличный обмен книг! Очень доволен сервисом.', '2025-03-06'),
(3, 2, 2, 5, 'Отличный сервис!', '2025-03-07');

-- --------------------------------------------------------

--
-- Структура таблицы `сообщения`
--

CREATE TABLE `сообщения` (
  `сообщение_id` int(11) NOT NULL,
  `отправитель_id` int(11) DEFAULT NULL,
  `получатель_id` int(11) DEFAULT NULL,
  `содержание` text NOT NULL,
  `дата_отправки` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  MODIFY `книга_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `пользователи`
--
ALTER TABLE `пользователи`
  MODIFY `пользователь_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `заявки_на_обмен`
--
ALTER TABLE `заявки_на_обмен`
  MODIFY `заявка_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `обмены`
--
ALTER TABLE `обмены`
  MODIFY `обмен_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `отзывы`
--
ALTER TABLE `отзывы`
  MODIFY `отзыв_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `сообщения`
--
ALTER TABLE `сообщения`
  MODIFY `сообщение_id` int(11) NOT NULL AUTO_INCREMENT;

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
