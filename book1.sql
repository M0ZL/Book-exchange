-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 29 2025 г., 23:55
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
(2, 1, '978-5-17-118103-1', 'Война и мир', 'Л.Н. Толстой', 'обменяна', '2025-03-06', 'Роман', 1869, 'images/1.jpg'),
(3, 4, '978-5-386-10742-0', 'Уличный кот по имени Боб. Как человек и кот обрели надежду на улицах Лондона', 'Джеймс Боуэн', 'доступна', '2025-03-06', 'Роман', 2018, 'images/2.webp'),
(4, 3, '978-5-17-163435-3', 'Дикий зверь', 'Жоэль Диккер', 'доступна', '2025-03-04', 'Роман', 2025, 'images/3.webp'),
(5, 2, '978-5-00214-025-1', 'The Book. Как создать цивилизацию заново', 'Коллектив авторов', 'обменяна', '2025-03-05', NULL, 2023, 'images/4.webp'),
(6, 6, '978-5-00195-984-7', 'Египетская «Книга мертвых»', 'Коллектив авторов', 'доступна', '2025-03-02', 'Мифы и легенды', 2024, 'images/5.webp'),
(7, 1, '978-5-17-170204-5', 'Самая страшная книга. Заступа: Чернее черного', 'Иван Белов', 'обменяна', '2025-03-10', 'Отечественная фантастика', 2025, 'images/6.jpg'),
(8, 2, '978-5-10214-025-1', 'PAIN', 'NAGATO', 'доступна', NULL, 'Роман', 2025, 'images/1.jpg'),
(9, 2, '978-5-10314-025-1', 'PAIN ПРАВА ЧЕЛОВЕКА', 'NAGATO', 'доступна', '2025-03-30', 'Фантастика', 2025, 'images/6.webp'),
(10, 2, '978-5-13214-025-1', 'PAIN ПРАВА ЧЕЛОВЕКА2', 'NAGATO', 'доступна', '2025-03-30', 'Фантастика', 2025, 'images/6.webp'),
(11, 2, '978-5-17214-025-1', '2025 PAIN ПРАВА ЧЕЛОВЕКА3', 'ТОМАС ПЕЙН', 'доступна', '2025-03-30', 'Фантастика', 2025, 'images/7.webp');

-- --------------------------------------------------------

--
-- Структура таблицы `пользователи`
--

CREATE TABLE `пользователи` (
  `пользователь_id` int(11) NOT NULL,
  `ник_пользователя` varchar(255) NOT NULL,
  `электронная_почта` varchar(255) NOT NULL,
  `пароль` varchar(255) NOT NULL,
  `роль` enum('гость','участник','администратор') NOT NULL,
  `статус` enum('активный','бан') NOT NULL,
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

INSERT INTO `пользователи` (`пользователь_id`, `ник_пользователя`, `электронная_почта`, `пароль`, `роль`, `статус`, `рейтинг`, `дата_регистрации`, `фамилия`, `имя`, `отчество`, `адрес`, `телефон`, `возраст`) VALUES
(1, 'test1', 'dedkovanton20@yandex.ru', '123', 'участник', 'активный', 5, '2025-03-06', 'Дедков', 'Антон', 'Геннадьевич', '446660, обл. Самарская, р-н. Борский, с. Борское, ул. Песочная, д. 1', '+79011111111', 21),
(2, 'test2', 'Nikita@example.com', '789', 'администратор', 'активный', 5, '2025-03-01', 'Лавренко', 'Никита', NULL, NULL, '+79200000000', 22),
(3, 'test3', 'Grin@example.com', '456', 'участник', 'активный', 0, '2025-03-05', 'Гринцова', 'Дарья', 'Витальевна', NULL, '+79300000000', 23),
(4, 'test4', 'Kurkina@example.com', '4444', 'участник', 'активный', 0, '2025-03-05', 'Куркина', 'Юлия', NULL, NULL, '+79400004589', 22),
(5, 'test5', 'Mamykin@example.com', '8888', 'участник', 'активный', 0, '2025-03-05', 'Мамыкин', 'Глеб', 'Павлович', NULL, '+79500000893', 23),
(6, 'test6', 'Aparin@example.com', '6969', 'участник', 'бан', 0, '2025-03-05', 'Апарин', 'Александр', NULL, NULL, '+79600000000', 23),
(7, 'test7', 'Zhanatov@example.com', '5151', 'участник', 'активный', 0, '2025-03-05', 'Жанатов', 'Айсултан', NULL, NULL, '+797000000231', 22),
(8, 'test8', 'boyagin68@gmail.com', '098', 'участник', 'активный', 0, '2025-03-13', 'Боягин', 'Владислав', 'Алексеевич', '', '+79564873291', 23),
(9, 'test9', 'gareevd@gmail.com', '691', 'участник', 'бан', 0, '2025-03-13', 'Гареев', 'Дамир', 'Дмитриевич', '', '+79564874098', 23),
(10, 'test10', 'kozlova45@gmail.com', '234', 'участник', 'активный', 0, '2025-03-13', 'Козлова', 'Валентина', 'Дмитриевна', '', '+79588873291', 23),
(14, 'testbag1', 'dedexeption@gmail.ru', '123', 'участник', 'активный', 0, '2025-03-30', 'Дед', 'Антон', 'Гений', 'тютю', '+79297777777', 50);

-- --------------------------------------------------------

--
-- Структура таблицы `предложения_на_обмен`
--

CREATE TABLE `предложения_на_обмен` (
  `предложение_id` int(13) NOT NULL,
  `запрос_id` int(13) NOT NULL,
  `книга_id` int(13) NOT NULL,
  `подтверждение` tinyint(1) NOT NULL DEFAULT 0,
  `сторона_а` int(13) NOT NULL,
  `сторона_б` int(13) NOT NULL,
  `трек_номер_а` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `трек_номер_б` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `доставка_подтверждена_а` tinyint(1) DEFAULT 0,
  `доставка_подтверждена_б` tinyint(1) DEFAULT 0,
  `статус_завершения` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `предложения_на_обмен`
--

INSERT INTO `предложения_на_обмен` (`предложение_id`, `запрос_id`, `книга_id`, `подтверждение`, `сторона_а`, `сторона_б`, `трек_номер_а`, `трек_номер_б`, `доставка_подтверждена_а`, `доставка_подтверждена_б`, `статус_завершения`) VALUES
(3, 2, 5, 1, 2, 1, '123', '123', 1, 1, 1),
(4, 6, 7, 1, 1, 2, '123', '789', 1, 1, 1),
(5, 6, 7, 1, 1, 2, '00000000000000000000', '00000000000000000000', 1, 1, 1),
(6, 2, 8, 1, 2, 1, '00000000000000000000', '00000000000000000000', 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `жалобы`
--

CREATE TABLE `жалобы` (
  `жалоба_id` int(11) NOT NULL,
  `пользователь_id` int(11) NOT NULL,
  `жалоба_на` int(11) NOT NULL,
  `описание` text NOT NULL,
  `дата_создания` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `жалобы`
--

INSERT INTO `жалобы` (`жалоба_id`, `пользователь_id`, `жалоба_на`, `описание`, `дата_создания`) VALUES
(1, 1, 1, 'Этот чел УткаГамер', '2025-03-14 21:15:12'),
(2, 1, 4, 'Не люблю котов', '2025-03-14 21:15:50');

-- --------------------------------------------------------

--
-- Структура таблицы `запросы_на_обмен`
--

CREATE TABLE `запросы_на_обмен` (
  `запрос_id` int(11) NOT NULL,
  `offered_book_id` int(11) NOT NULL,
  `desired_genre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desired_condition` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desired_other` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `пользователь_id` int(11) NOT NULL,
  `статус` enum('ожидание','подтвержден','отклонен') COLLATE utf8mb4_unicode_ci DEFAULT 'ожидание',
  `дата_создания` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `запросы_на_обмен`
--

INSERT INTO `запросы_на_обмен` (`запрос_id`, `offered_book_id`, `desired_genre`, `desired_condition`, `desired_other`, `delivery_address`, `recipient_name`, `пользователь_id`, `статус`, `дата_создания`) VALUES
(2, 2, 'Фантастика', 'не имеет значения', '-', 'Я фигею 24', 'Дедков Антон Геннадьевич', 1, 'подтвержден', '2025-03-22 21:55:59'),
(3, 2, 'Фантастика', 'не имеет значения', '-', 'Я фигею 24', 'Дедков Антон Геннадьевич', 1, 'ожидание', '2025-03-22 21:58:01'),
(4, 2, 'Фантастика', 'не имеет значения', '-', 'Я фигею 24', 'Дедков Антон Геннадьевич', 1, 'ожидание', '2025-03-22 22:02:38'),
(5, 7, 'Фантастика', 'не имеет значения', '=', 'Я фигею 24', 'Дедков Антон Геннадьевич', 1, 'ожидание', '2025-03-22 22:02:59'),
(6, 5, 'Фантастика', 'не имеет значения', '-', 'Я фигею 24', 'Никита', 2, 'подтвержден', '2025-03-23 02:25:06');

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
  `дата_создания` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `отзывы`
--

INSERT INTO `отзывы` (`отзыв_id`, `пользователь_id`, `обмен_id`, `оценка`, `комментарий`, `дата_создания`) VALUES
(4, 1, 5, 5, 'test', '2025-03-29 22:51:44'),
(5, 2, 5, NULL, '123', '2025-03-29 23:17:14'),
(6, 2, 5, 4, '123', '2025-03-29 23:25:44'),
(7, 2, 5, 4, '123', '2025-03-29 23:27:33'),
(8, 2, NULL, 4, '123', '2025-03-29 23:32:25'),
(9, 2, 5, 1, 'test2', '2025-03-29 23:35:54'),
(10, 2, 5, 1, 'test2', '2025-03-29 23:36:27');

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
-- Индексы таблицы `предложения_на_обмен`
--
ALTER TABLE `предложения_на_обмен`
  ADD PRIMARY KEY (`предложение_id`),
  ADD KEY `запрос_id` (`запрос_id`),
  ADD KEY `книга_id` (`книга_id`),
  ADD KEY `сторона_а` (`сторона_а`),
  ADD KEY `сторона_б` (`сторона_б`);

--
-- Индексы таблицы `жалобы`
--
ALTER TABLE `жалобы`
  ADD PRIMARY KEY (`жалоба_id`),
  ADD KEY `пользователь_id` (`пользователь_id`),
  ADD KEY `жалоба_на` (`жалоба_на`);

--
-- Индексы таблицы `запросы_на_обмен`
--
ALTER TABLE `запросы_на_обмен`
  ADD PRIMARY KEY (`запрос_id`),
  ADD KEY `offered_book_id` (`offered_book_id`),
  ADD KEY `пользователь_id` (`пользователь_id`);

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
  MODIFY `книга_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `пользователи`
--
ALTER TABLE `пользователи`
  MODIFY `пользователь_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `предложения_на_обмен`
--
ALTER TABLE `предложения_на_обмен`
  MODIFY `предложение_id` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `жалобы`
--
ALTER TABLE `жалобы`
  MODIFY `жалоба_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `запросы_на_обмен`
--
ALTER TABLE `запросы_на_обмен`
  MODIFY `запрос_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `отзывы`
--
ALTER TABLE `отзывы`
  MODIFY `отзыв_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- Ограничения внешнего ключа таблицы `предложения_на_обмен`
--
ALTER TABLE `предложения_на_обмен`
  ADD CONSTRAINT `предложения_на_обмен_ibfk_1` FOREIGN KEY (`запрос_id`) REFERENCES `запросы_на_обмен` (`запрос_id`),
  ADD CONSTRAINT `предложения_на_обмен_ibfk_2` FOREIGN KEY (`книга_id`) REFERENCES `книги` (`книга_id`);

--
-- Ограничения внешнего ключа таблицы `жалобы`
--
ALTER TABLE `жалобы`
  ADD CONSTRAINT `жалобы_ibfk_1` FOREIGN KEY (`пользователь_id`) REFERENCES `пользователи` (`пользователь_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `жалобы_ibfk_2` FOREIGN KEY (`жалоба_на`) REFERENCES `пользователи` (`пользователь_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `запросы_на_обмен`
--
ALTER TABLE `запросы_на_обмен`
  ADD CONSTRAINT `запросы_на_обмен_ibfk_1` FOREIGN KEY (`offered_book_id`) REFERENCES `книги` (`книга_id`),
  ADD CONSTRAINT `запросы_на_обмен_ibfk_2` FOREIGN KEY (`пользователь_id`) REFERENCES `пользователи` (`пользователь_id`);

--
-- Ограничения внешнего ключа таблицы `отзывы`
--
ALTER TABLE `отзывы`
  ADD CONSTRAINT `отзывы_ibfk_1` FOREIGN KEY (`пользователь_id`) REFERENCES `пользователи` (`пользователь_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `отзывы_ibfk_2` FOREIGN KEY (`обмен_id`) REFERENCES `предложения_на_обмен` (`предложение_id`);

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
