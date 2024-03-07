-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 07 2024 г., 09:19
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `Museum`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tbAction`
--

CREATE TABLE `tbAction` (
  `idAction` int NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Price` int NOT NULL,
  `NumberTicket` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tbAction`
--

INSERT INTO `tbAction` (`idAction`, `Name`, `Price`, `NumberTicket`) VALUES
(1, 'Выставка «Ракурсы реальности»', 100, 199),
(2, 'Выставка «Анимализм в искусстве»', 200, 290);

-- --------------------------------------------------------

--
-- Структура таблицы `tbApplication`
--

CREATE TABLE `tbApplication` (
  `idApplication` int NOT NULL,
  `idClient` int NOT NULL,
  `idAction` int NOT NULL,
  `NumClients` int NOT NULL DEFAULT '1',
  `FullPrice` int NOT NULL,
  `Date` date NOT NULL,
  `Status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tbApplication`
--

INSERT INTO `tbApplication` (`idApplication`, `idClient`, `idAction`, `NumClients`, `FullPrice`, `Date`, `Status`) VALUES
(4, 1, 2, 1, 200, '2024-01-10', 1),
(5, 1, 2, 10, 2000, '2024-01-12', 3),
(6, 2, 1, 1, 100, '2024-01-09', 2),
(7, 3, 2, 10, 2000, '2024-01-09', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `tbClient`
--

CREATE TABLE `tbClient` (
  `idClient` int NOT NULL,
  `FIO` varchar(100) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `role` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tbClient`
--

INSERT INTO `tbClient` (`idClient`, `FIO`, `login`, `password`, `mail`, `role`) VALUES
(1, 'Ларькин Виктор Александрович', 'login', '$2y$10$7DVcjk.9EZ6XUMSWlYvxCuCXdP6zXjH4uPEbaF9dq0qJ04xZK.qcS', 'mail@mail.ru', 'admin'),
(2, 'Пупкин Иван Петрович', 'pupkin', '$2y$10$2zeI8huJWJzb9Z1mNpv.tOHZuUtXEfR/AK80fTobtgOy9Dxqhau9u', 'pupkin@mail.com', 'user'),
(3, 'Ларькин Виктор Александрович', 'larkin', '$2y$10$GikPHPADAd.CU8m2kkzi0OUPrFIgPNdJja4VNtizMfM/6wAyW9KiG', 'larkin@mail.com', 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `tbReservation`
--

CREATE TABLE `tbReservation` (
  `idReservation` int NOT NULL,
  `idApplication` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tbStatus`
--

CREATE TABLE `tbStatus` (
  `idStatus` int NOT NULL,
  `StatusName` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tbStatus`
--

INSERT INTO `tbStatus` (`idStatus`, `StatusName`) VALUES
(1, 'Открыта'),
(2, 'Принята'),
(3, 'Отклонена');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tbAction`
--
ALTER TABLE `tbAction`
  ADD PRIMARY KEY (`idAction`);

--
-- Индексы таблицы `tbApplication`
--
ALTER TABLE `tbApplication`
  ADD PRIMARY KEY (`idApplication`),
  ADD KEY `idClient` (`idClient`),
  ADD KEY `idAction` (`idAction`),
  ADD KEY `Status` (`Status`);

--
-- Индексы таблицы `tbClient`
--
ALTER TABLE `tbClient`
  ADD PRIMARY KEY (`idClient`);

--
-- Индексы таблицы `tbReservation`
--
ALTER TABLE `tbReservation`
  ADD PRIMARY KEY (`idReservation`),
  ADD KEY `idApplication` (`idApplication`);

--
-- Индексы таблицы `tbStatus`
--
ALTER TABLE `tbStatus`
  ADD PRIMARY KEY (`idStatus`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tbAction`
--
ALTER TABLE `tbAction`
  MODIFY `idAction` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `tbApplication`
--
ALTER TABLE `tbApplication`
  MODIFY `idApplication` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `tbClient`
--
ALTER TABLE `tbClient`
  MODIFY `idClient` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `tbReservation`
--
ALTER TABLE `tbReservation`
  MODIFY `idReservation` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbStatus`
--
ALTER TABLE `tbStatus`
  MODIFY `idStatus` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tbApplication`
--
ALTER TABLE `tbApplication`
  ADD CONSTRAINT `tbapplication_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `tbClient` (`idClient`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `tbapplication_ibfk_2` FOREIGN KEY (`idAction`) REFERENCES `tbAction` (`idAction`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `tbapplication_ibfk_3` FOREIGN KEY (`Status`) REFERENCES `tbStatus` (`idStatus`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `tbReservation`
--
ALTER TABLE `tbReservation`
  ADD CONSTRAINT `tbreservation_ibfk_1` FOREIGN KEY (`idApplication`) REFERENCES `tbApplication` (`idApplication`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
