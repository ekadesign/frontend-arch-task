-- phpMyAdmin SQL Dump
-- version 4.0.10.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 05 2015 г., 02:16
-- Версия сервера: 5.5.45
-- Версия PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `bd1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `couriers`
--

CREATE TABLE IF NOT EXISTS `couriers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `courier` varchar(32) NOT NULL,
  `busy` int(1) DEFAULT NULL,
  `busytime` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `couriers`
--

INSERT INTO `couriers` (`id`, `courier`, `busy`, `busytime`) VALUES
(1, 'Валера', 1, '2015-10-21'),
(2, 'Алексей', 1, '2015-09-22'),
(3, 'Дмитрий', 1, '2015-10-01'),
(4, 'Семен', NULL, '0000-00-00');

-- --------------------------------------------------------

--
-- Структура таблицы `leftlist`
--

CREATE TABLE IF NOT EXISTS `leftlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region` varchar(32) NOT NULL,
  `courier` varchar(32) NOT NULL,
  `start` varchar(32) NOT NULL,
  `toregion` varchar(32) NOT NULL,
  `back` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `leftlist`
--

INSERT INTO `leftlist` (`id`, `region`, `courier`, `start`, `toregion`, `back`) VALUES
(1, 'Cанкт-Петербург', '1', '2015-10-17', '2015-10-19', '20151021'),
(2, 'Уфа', '2', '2015-9-29', '2015-10-2', '20151005'),
(3, 'Cанкт-Петербург', '3', '2015-9-27', '2015-9-29', '20151001'),
(4, 'Владимир', '2', '2015-9-10', '2015-9-12', '20150914'),
(5, 'Уфа', '1', '2015-9-4', '2015-9-7', '20150910'),
(6, 'Cанкт-Петербург', '1', '2015-9-18', '2015-9-20', '20150922'),
(7, 'Cанкт-Петербург', '2', '2015-9-18', '2015-9-20', '20150922');

-- --------------------------------------------------------

--
-- Структура таблицы `regions`
--

CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region` varchar(32) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `regions`
--

INSERT INTO `regions` (`id`, `region`, `time`) VALUES
(1, 'Cанкт-Петербург', 2),
(2, 'Уфа', 3),
(3, 'Нижний Новгород', 1),
(4, 'Владимир', 1),
(5, 'Кострома', 2),
(6, 'Екатеринбург', 3),
(7, 'Ковров', 1),
(8, 'Воронеж', 3),
(9, 'Самара', 1),
(10, 'Астрахань', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
