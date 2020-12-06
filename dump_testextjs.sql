-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Дек 07 2020 г., 01:52
-- Версия сервера: 5.7.32-0ubuntu0.18.04.1
-- Версия PHP: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testextjs`
--

-- --------------------------------------------------------

--
-- Структура таблицы `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `education`
--

INSERT INTO `education` (`id`, `name`) VALUES
(1, 'дошкольное'),
(2, 'начальное общее'),
(3, 'основное общее'),
(4, 'среднее общее'),
(5, 'среднее профессиональное'),
(6, 'высшее образование - бакалавриат'),
(7, 'высшее образование - специалитет, магистратура'),
(8, 'высшее образование - кадры высшей квалификации');

-- --------------------------------------------------------

--
-- Структура таблицы `sities`
--

CREATE TABLE `sities` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sities`
--

INSERT INTO `sities` (`id`, `name`) VALUES
(1, 'Москва'),
(2, 'Санкт-Петербург'),
(3, 'Новосибирск'),
(4, 'Екатеринбург'),
(5, 'Казань'),
(6, 'Нижний Новгород'),
(7, 'Челябинск'),
(8, 'Самара'),
(9, 'Омск'),
(10, 'Ростов-на-Дону'),
(11, 'Уфа'),
(12, 'Красноярск'),
(13, 'Воронеж'),
(14, 'Пермь'),
(15, 'Волгоград'),
(16, 'Краснодар'),
(17, 'Саратов'),
(18, 'Тюмень'),
(19, 'Тольятти'),
(20, 'Ижевск');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `education_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `education_id`, `name`) VALUES
(1, 1, 'Джефф Безос'),
(2, 5, 'Билл Гейтс'),
(3, 2, 'Бернар Арно'),
(4, 6, 'Уоррен Баффет'),
(5, 4, 'Ларри Эллисон'),
(6, 2, 'Амансио Ортега'),
(7, 1, 'Марк Цукерберг'),
(8, 2, 'Джим Уолтон');

-- --------------------------------------------------------

--
-- Структура таблицы `user_sity`
--

CREATE TABLE `user_sity` (
  `user_id` int(11) NOT NULL,
  `sity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_sity`
--

INSERT INTO `user_sity` (`user_id`, `sity_id`) VALUES
(1, 3),
(1, 6),
(2, 1),
(3, 5),
(3, 15),
(3, 12),
(4, 20),
(5, 8),
(5, 17),
(6, 1),
(7, 13),
(8, 16);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Индексы таблицы `sities`
--
ALTER TABLE `sities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `education_id` (`education_id`);

--
-- Индексы таблицы `user_sity`
--
ALTER TABLE `user_sity`
  ADD KEY `sity_id` (`sity_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `sities`
--
ALTER TABLE `sities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`education_id`) REFERENCES `education` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `user_sity`
--
ALTER TABLE `user_sity`
  ADD CONSTRAINT `user_sity_ibfk_1` FOREIGN KEY (`sity_id`) REFERENCES `sities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_sity_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
