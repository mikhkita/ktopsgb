-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 12, 2018 at 10:21 PM
-- Server version: 5.6.35
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `tlt`
--

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

CREATE TABLE `board` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `plant_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `board`
--

INSERT INTO `board` (`id`, `date`, `plant_id`) VALUES
(21, '2018-01-03 21:00:00', 2),
(22, '2018-01-03 21:00:00', 2),
(23, '2018-01-03 21:00:00', 2),
(24, '2018-01-03 21:00:00', 2),
(25, '2018-01-05 21:00:00', 2),
(26, '2018-01-05 21:00:00', 2),
(27, '2018-01-05 21:00:00', 2),
(28, '2018-01-05 21:00:00', 2),
(29, '2018-01-05 21:00:00', 2),
(30, '2018-01-05 21:00:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `board_item`
--

CREATE TABLE `board_item` (
  `id` int(10) UNSIGNED NOT NULL,
  `board_id` int(10) UNSIGNED NOT NULL,
  `thickness` float NOT NULL,
  `width` float NOT NULL,
  `length` float NOT NULL,
  `count` float NOT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `board_item`
--

INSERT INTO `board_item` (`id`, `board_id`, `thickness`, `width`, `length`, `count`, `price`) VALUES
(9, 13, 2.3, 123.213, 2, 2, NULL),
(23, 12, 2.2, 2.2, 2.2, 1.1, NULL),
(24, 12, 1, 1, 1, 50, NULL),
(25, 12, 2, 2.123, 0.23, 60, NULL),
(26, 12, 3, 0.1, 3, 70, NULL),
(27, 12, 4, 4, 4, 4, NULL),
(28, 1, 2.2, 0.26, 2.6, 63, NULL),
(29, 1, 2, 0.15, 3.5, 40, NULL),
(30, 1, 1.5, 0.5, 5, 20, NULL),
(31, 1, 3.7, 0.3, 4, 50, NULL),
(32, 10, 2.4, 0.21, 2.5, 50, NULL),
(33, 10, 2.1, 0.5, 5, 30, NULL),
(34, 10, 1.8, 0.3, 3, 40, NULL),
(39, 14, 1.8, 0.4, 4, 67, NULL),
(40, 14, 1.1, 0.3, 3.78, 87, NULL),
(44, 11, 2.3, 2.1, 1, 89, NULL),
(45, 11, 2.1, 0.3, 3, 12, NULL),
(46, 11, 4.3, 1, 2, 30, NULL),
(60, 16, 1, 2, 3, 5, 1800),
(61, 16, 2, 1.5, 2.3, 10, 2300),
(62, 15, 12, 2, 2.3, 10, 320),
(63, 15, 2.1, 6, 3, 20, 1900),
(64, 17, 12, 323, 323, 3, 232),
(65, 18, 2, 3, 4, 10, NULL),
(66, 19, 0.033, 0.103, 3.6, 300, NULL),
(67, 19, 0.033, 1, 3.6, 30, NULL),
(68, 19, 0.033, 0.178, 3.6, 180, NULL),
(69, 19, 0.033, 0.178, 3.6, 180, NULL),
(70, 19, 0.019, 0.078, 2.4, 520, NULL),
(71, 19, 0.019, 0.095, 3.6, 440, NULL),
(72, 19, 0.033, 0.153, 3.6, 210, NULL),
(80, 20, 0.019, 0.103, 3.6, 400, NULL),
(81, 20, 0.033, 0.103, 3.6, 300, NULL),
(82, 20, 0.033, 0.128, 3.6, 240, NULL),
(83, 20, 0.033, 0.128, 2.4, 240, NULL),
(84, 20, 0.033, 0.153, 3.6, 210, NULL),
(85, 20, 0.033, 0.128, 3.6, 240, NULL),
(86, 20, 0.019, 0.078, 3.6, 520, NULL),
(92, 21, 0.033, 0.153, 3.6, 210, NULL),
(93, 21, 0.033, 1, 3.6, 30, NULL),
(94, 21, 0.033, 0.103, 2, 300, NULL),
(95, 21, 0.033, 0.103, 2, 300, NULL),
(96, 21, 0.033, 0.178, 3.6, 180, NULL),
(97, 21, 0.033, 0.128, 2.4, 240, NULL),
(98, 21, 0.033, 0.178, 2.4, 180, NULL),
(99, 21, 0.033, 0.178, 3.6, 180, NULL),
(105, 22, 0.019, 0.103, 3.6, 400, NULL),
(106, 22, 0.033, 0.103, 3.6, 300, NULL),
(107, 22, 0.033, 0.128, 3.6, 240, NULL),
(108, 22, 0.033, 0.128, 2.4, 240, NULL),
(109, 22, 0.033, 0.153, 3.6, 210, NULL),
(110, 22, 0.033, 0.128, 3.6, 240, NULL),
(111, 22, 0.019, 0.078, 3.6, 520, NULL),
(128, 23, 0.033, 0.178, 3.6, 180, NULL),
(129, 23, 0.033, 0.103, 3.6, 300, NULL),
(130, 23, 0.033, 0.103, 2.4, 300, NULL),
(131, 23, 0.019, 0.095, 2.4, 440, NULL),
(132, 23, 0.019, 1, 3.6, 40, NULL),
(133, 23, 0.033, 0.153, 3.6, 210, NULL),
(134, 23, 0.033, 0.153, 2.4, 210, NULL),
(135, 23, 0.033, 0.178, 2.4, 180, NULL),
(136, 24, 0.033, 0.103, 3.6, 300, NULL),
(137, 24, 0.033, 1, 3.6, 30, NULL),
(138, 24, 0.033, 0.178, 3.6, 180, NULL),
(139, 24, 0.033, 0.178, 3.6, 180, NULL),
(140, 24, 0.019, 0.078, 2.4, 520, NULL),
(141, 24, 0.019, 0.095, 3.6, 440, NULL),
(142, 24, 0.033, 0.153, 3.6, 210, NULL),
(150, 25, 0.033, 0.153, 3.6, 210, NULL),
(151, 25, 0.033, 0.178, 3.6, 180, NULL),
(152, 25, 0.033, 0.128, 3.6, 240, NULL),
(153, 25, 0.033, 0.178, 2.4, 180, NULL),
(154, 25, 0.033, 0.103, 3.6, 300, NULL),
(155, 25, 0.033, 0.103, 3.6, 300, NULL),
(156, 25, 0.033, 0.178, 3.6, 180, NULL),
(157, 26, 0.033, 0.178, 3.6, 180, NULL),
(158, 26, 0.033, 1, 3.6, 31, NULL),
(159, 26, 0.019, 1, 3.6, 41, NULL),
(160, 26, 0.033, 0.153, 2.4, 210, NULL),
(161, 26, 0.033, 0.103, 3.6, 300, NULL),
(162, 26, 0.033, 0.103, 3.6, 300, NULL),
(163, 26, 0.019, 1, 3.6, 45, NULL),
(164, 27, 0.033, 0.103, 3.6, 300, NULL),
(165, 27, 0.033, 0.153, 3.6, 210, NULL),
(166, 27, 0.033, 0.153, 3.6, 210, NULL),
(167, 27, 0.033, 0.178, 3.6, 180, NULL),
(168, 27, 0.033, 0.128, 3.6, 240, NULL),
(169, 27, 0.019, 0.095, 3.6, 440, NULL),
(170, 27, 0.033, 0.178, 2.4, 180, NULL),
(171, 28, 0.033, 0.178, 3.6, 180, NULL),
(172, 28, 0.033, 0.128, 3.6, 240, NULL),
(173, 28, 0.019, 1, 2.4, 40, NULL),
(174, 28, 0.033, 0.153, 2.4, 210, NULL),
(175, 28, 0.033, 0.128, 3.6, 240, NULL),
(176, 28, 0.033, 0.128, 3.6, 240, NULL),
(177, 28, 0.019, 1, 2.4, 39, NULL),
(178, 28, 0.033, 0.103, 2.4, 300, NULL),
(188, 29, 0.033, 0.153, 3.6, 210, NULL),
(189, 29, 0.019, 1, 3.6, 39, NULL),
(190, 29, 0.033, 1, 2.4, 30, NULL),
(191, 29, 0.033, 1, 2.4, 30, NULL),
(192, 29, 0.033, 0.103, 2.4, 300, NULL),
(193, 29, 0.033, 0.103, 2.4, 300, NULL),
(194, 29, 0.033, 0.128, 2.4, 240, NULL),
(195, 29, 0.033, 0.153, 2.4, 210, NULL),
(196, 29, 0.033, 0.153, 2.4, 210, NULL),
(204, 30, 0.033, 0.178, 3.6, 180, NULL),
(205, 30, 0.033, 0.103, 3.6, 300, NULL),
(206, 30, 0.033, 0.103, 3.6, 300, NULL),
(207, 30, 0.033, 0.128, 2.4, 240, NULL),
(208, 30, 0.033, 0.178, 2.4, 180, NULL),
(209, 30, 0.033, 0.153, 3.6, 210, NULL),
(210, 30, 0.033, 0.153, 3.6, 210, NULL),
(211, 31, 1, 2, 1, 1, NULL),
(212, 31, 1, 4, 2, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `name`) VALUES
(1, 'Томск/Клещиха'),
(2, 'Красноярск'),
(3, 'Базаиха'),
(4, 'Тальцы');

-- --------------------------------------------------------

--
-- Table structure for table `cargo`
--

CREATE TABLE `cargo` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `type_id` smallint(5) UNSIGNED NOT NULL,
  `length` float NOT NULL,
  `thickness` float NOT NULL,
  `cubage` float NOT NULL,
  `count` smallint(5) UNSIGNED NOT NULL,
  `price` float NOT NULL,
  `container_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cargo`
--

INSERT INTO `cargo` (`id`, `type_id`, `length`, `thickness`, `cubage`, `count`, `price`, `container_id`) VALUES
(5, 1, 2.7, 20, 50, 30, 2900, 1),
(8, 2, 2.6, 3, 36, 10, 1900, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cargo_type`
--

CREATE TABLE `cargo_type` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cargo_type`
--

INSERT INTO `cargo_type` (`id`, `name`) VALUES
(1, 'Ель, пихта'),
(2, 'Береза');

-- --------------------------------------------------------

--
-- Table structure for table `carrier`
--

CREATE TABLE `carrier` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `carrier`
--

INSERT INTO `carrier` (`id`, `name`) VALUES
(2, 'ЛФ'),
(3, 'СК-Транс'),
(4, 'Магистраль');

-- --------------------------------------------------------

--
-- Table structure for table `cash`
--

CREATE TABLE `cash` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type_id` tinyint(3) UNSIGNED NOT NULL,
  `reason` varchar(512) DEFAULT NULL,
  `sum` int(11) NOT NULL,
  `comment` varchar(512) DEFAULT NULL,
  `cheque` tinyint(1) NOT NULL DEFAULT '0',
  `negative` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cash`
--

INSERT INTO `cash` (`id`, `date`, `type_id`, `reason`, `sum`, `comment`, `cheque`, `negative`) VALUES
(1, '2017-12-31 21:00:00', 1, 'Остаток с 2017 года', 1385526, '', 0, 0),
(2, '2018-01-01 21:00:00', 1, 'Руслан', 400000, '', 0, 0),
(3, '2018-01-02 21:00:00', 1, 'Проданы дрова', 4500, '3 пачки', 0, 0),
(4, '2018-01-03 21:00:00', 1, 'Руслан', 260000, '', 0, 0),
(5, '2018-01-03 21:00:00', 1, 'Проданы дрова', 16500, '11 пачек', 0, 0),
(6, '2018-01-04 21:00:00', 1, 'Проданы дрова', 4500, '3 пачки', 0, 0),
(7, '2018-01-05 21:00:00', 1, 'Продана черная доска', 134400, '48 м.куб', 0, 0),
(8, '2018-01-05 21:00:00', 1, 'Проданы дрова', 12000, '8 пачек', 0, 0),
(9, '2018-01-06 21:00:00', 1, 'Проданы дрова', 4500, '3 пачки', 0, 0),
(10, '2018-01-07 21:00:00', 1, 'Проданы дрова', 12000, '8 пачек', 0, 0),
(11, '2018-01-08 21:00:00', 1, 'Проданы дрова', 15000, '10 пачек', 0, 0),
(12, '2018-01-09 21:00:00', 1, 'Проданы дрова', 19500, '13 пачек', 0, 0),
(13, '2018-01-09 21:00:00', 1, 'Продана черная доска', 134400, '48 м.куб', 0, 0),
(14, '2018-01-10 21:00:00', 1, 'Проданы дрова', 15000, '10 пачек', 0, 0),
(15, '2018-01-12 21:00:00', 1, 'Проданы дрова', 18000, '12 пачек', 0, 0),
(16, '2018-01-12 21:00:00', 1, 'Ван', 1731000, '', 0, 0),
(17, '2018-01-13 21:00:00', 1, 'Проданы дрова', 4500, '3 пачки', 0, 0),
(18, '2018-01-14 21:00:00', 1, 'Проданы дрова', 13500, '9 пачек', 0, 0),
(19, '2018-01-15 21:00:00', 1, 'Проданы дрова', 16500, '11 пачек', 0, 0),
(20, '2018-01-16 21:00:00', 1, 'Проданы дрова', 9000, '6 пачек', 0, 0),
(21, '2018-01-17 21:00:00', 1, 'Проданы дрова', 9000, '6 пачек', 0, 0),
(22, '2018-01-18 21:00:00', 1, 'Руслан', 499500, '', 0, 0),
(23, '2018-01-18 21:00:00', 1, 'Проданы дрова', 6000, '4 пачки', 0, 0),
(24, '2018-01-22 21:00:00', 1, 'Заняли китайцам', 110000, '', 0, 1),
(25, '2018-01-24 21:00:00', 1, 'Аванс', 640390, '', 0, 1),
(26, '2018-01-04 21:00:00', 2, 'РВД 5шт.', 4900, 'чек', 0, 1),
(27, '2018-01-04 21:00:00', 2, 'Операция киргизу(доктор)', 5000, 'чек', 0, 1),
(28, '2018-01-04 21:00:00', 2, 'Бензин 20 л.', 792, 'чек', 0, 1),
(29, '2018-01-05 21:00:00', 2, 'Ремонт машины хонда(свечи,аккумулятор)', 7650, 'чек', 0, 1),
(30, '2018-01-06 21:00:00', 2, 'Солярка', 57600, 'чека нет', 0, 1),
(31, '2018-01-07 21:00:00', 2, 'Ремонт погрузчика', 2500, 'чек', 0, 1),
(32, '2018-01-08 21:00:00', 2, 'Доставка ленты металической и медный провод', 1400, 'чека нет', 0, 1),
(33, '2018-01-10 21:00:00', 2, 'Доставка грузовая газель', 1000, 'чека нет', 0, 1),
(34, '2018-01-10 21:00:00', 2, 'Продукты и хоз.товары', 7334, 'чек', 0, 1),
(35, '2018-01-10 21:00:00', 2, 'Шприц нагнетательный + насадки на него', 1749, 'чек', 0, 1),
(36, '2018-01-10 21:00:00', 2, 'Мясо', 10550, 'чека нет', 0, 1),
(37, '2018-01-10 21:00:00', 2, 'Костюм+сапоги Стас', 7170, 'чек', 0, 1),
(38, '2018-01-10 21:00:00', 2, 'Проточка маховика на кару', 6000, 'чека нет', 0, 1),
(39, '2018-01-11 21:00:00', 2, 'Тросик сантехнический', 290, 'да', 0, 1),
(40, '2018-01-11 21:00:00', 2, 'Веревка 12шт*35', 420, 'чек', 0, 1),
(41, '2018-01-11 21:00:00', 2, 'Солярка', 72000, 'чека нет', 0, 1),
(42, '2018-01-11 21:00:00', 2, 'Бензин Дима', 2600, 'чек', 0, 1),
(43, '2018-01-11 21:00:00', 2, 'Телефон Дима', 2000, 'чек', 0, 1),
(44, '2018-01-13 21:00:00', 2, 'Такси', 3100, 'чека нет', 0, 1),
(45, '2018-01-13 21:00:00', 2, 'Бензин пилорама', 5900, 'чек', 0, 1),
(46, '2018-01-13 21:00:00', 2, 'Преобр.ржавчины,винт,гайка,шайба', 283, 'чек', 0, 1),
(47, '2018-01-13 21:00:00', 2, 'Винт,гайка,шайба', 144, 'чек', 0, 1),
(48, '2018-01-13 21:00:00', 2, 'Гвозди', 115, 'чек', 0, 1),
(49, '2018-01-14 21:00:00', 2, 'Ремонт камеры(кара)', 1100, 'чек', 0, 1),
(50, '2018-01-14 21:00:00', 2, 'Провод,выключатель,тумблер,штекер', 249, 'чек', 0, 1),
(51, '2018-01-14 21:00:00', 2, 'Рукав высокого давления', 1505, 'чек', 0, 1),
(52, '2018-01-15 21:00:00', 2, 'Солярка', 72000, 'чека нет', 0, 1),
(53, '2018-01-15 21:00:00', 2, 'Языковой сертификат', 14000, 'чека нет', 0, 1),
(54, '2018-01-15 21:00:00', 2, 'Подшипник выжимной 2 шт.', 3450, 'чек', 0, 1),
(55, '2018-01-16 21:00:00', 2, 'Корм для Юки', 2277, 'чек', 0, 1),
(56, '2018-01-16 21:00:00', 2, 'Бензин Дима', 1901, 'чек', 0, 1),
(57, '2018-01-16 21:00:00', 2, 'Мясо', 20055, 'чека нет', 0, 1),
(58, '2018-01-16 21:00:00', 2, 'Доставка грузовая газель', 1000, 'чека нет', 0, 1),
(59, '2018-01-17 21:00:00', 2, 'Снятие швов киргизу(доктор)', 557, 'чек', 0, 1),
(60, '2018-01-18 21:00:00', 2, 'Расчет с погрузчиком Женя 314,9*100', 31400, 'чека нет', 0, 1),
(61, '2018-01-18 21:00:00', 2, 'Солярка', 72000, 'чека нет', 0, 1),
(62, '2018-01-18 21:00:00', 2, 'Доставка грузовая газель', 1000, 'чека нет', 0, 1),
(63, '2018-01-18 21:00:00', 2, 'Доставка грузовая газель', 1500, 'чека нет', 0, 1),
(64, '2018-01-18 21:00:00', 2, 'Овощи', 3221, 'чек', 0, 1),
(65, '2018-01-18 21:00:00', 2, 'Рис,мука', 4800, 'чек', 0, 1),
(66, '2018-01-18 21:00:00', 2, 'Курица', 3540, 'чек', 0, 1),
(67, '2018-01-18 21:00:00', 2, 'Таз 2шт.', 987, 'чек', 0, 1),
(68, '2018-01-22 21:00:00', 2, 'Пена д/пилорамы', 340, 'чек', 0, 1),
(69, '2018-01-22 21:00:00', 2, 'Колесо Дима', 590, 'чек', 0, 1),
(70, '2018-01-22 21:00:00', 2, 'Плитка электрическая', 500, 'чек', 0, 1),
(71, '2018-01-23 21:00:00', 2, 'Солярка', 72000, 'чека нет', 0, 1),
(72, '2018-01-23 21:00:00', 2, 'Аренда Инкино', 25000, 'чека нет', 0, 1),
(73, '2018-01-23 21:00:00', 2, 'Бензин Дима', 1791, 'чек', 0, 1),
(74, '2018-01-23 21:00:00', 2, 'Автомат, сверло по металлу 2шт. д/сушилки', 1725, 'чек', 0, 1),
(75, '2018-01-24 17:00:00', 2, 'Рукав высокого давления', 2125, 'чек', 1, 1),
(76, '2018-01-24 17:00:00', 2, 'Для пилорамы', 1700, 'чека нет', 0, 1),
(77, '2017-12-10 17:00:00', 1, '', 10000000, '', 0, 1),
(78, '2018-02-06 17:00:00', 1, 'Заняли китайцы', 100000, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cash_type`
--

CREATE TABLE `cash_type` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cash_type`
--

INSERT INTO `cash_type` (`id`, `name`) VALUES
(1, 'Ван'),
(2, 'Финансы');

-- --------------------------------------------------------

--
-- Table structure for table `china`
--

CREATE TABLE `china` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `china`
--

INSERT INTO `china` (`id`, `name`) VALUES
(1, 'Рабочий 1'),
(2, 'Рабочий 2'),
(3, 'Рабочий 3'),
(4, 'Рабочий 4'),
(5, 'Рабочий 5'),
(6, 'Рабочий 6'),
(7, 'Рабочий 7');

-- --------------------------------------------------------

--
-- Table structure for table `consignee`
--

CREATE TABLE `consignee` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `consignee`
--

INSERT INTO `consignee` (`id`, `name`, `email`) VALUES
(3, 'Тестовый грузополучатель', ''),
(4, 'Сергей', '');

-- --------------------------------------------------------

--
-- Table structure for table `container`
--

CREATE TABLE `container` (
  `id` int(10) UNSIGNED NOT NULL,
  `exporter_group_id` tinyint(4) UNSIGNED NOT NULL,
  `exporter_id` smallint(6) UNSIGNED DEFAULT NULL,
  `station_id` tinyint(4) UNSIGNED NOT NULL,
  `way_id` smallint(6) UNSIGNED NOT NULL,
  `destination_id` smallint(6) UNSIGNED NOT NULL,
  `number` varchar(15) NOT NULL,
  `owner_id` smallint(6) UNSIGNED DEFAULT NULL,
  `stamp_type_id` tinyint(4) UNSIGNED DEFAULT NULL,
  `stamp_num` varchar(15) DEFAULT NULL,
  `loading_date` timestamp NULL DEFAULT NULL,
  `loading_place_id` smallint(6) UNSIGNED DEFAULT NULL,
  `carrier_id` smallint(6) UNSIGNED DEFAULT NULL,
  `weight` int(11) UNSIGNED DEFAULT NULL,
  `dt` varchar(30) DEFAULT NULL,
  `shipment_num` varchar(15) DEFAULT NULL,
  `railway_num` varchar(15) DEFAULT NULL,
  `issue_date` timestamp NULL DEFAULT NULL,
  `consignee_id` smallint(6) UNSIGNED DEFAULT NULL,
  `border_date` timestamp NULL DEFAULT NULL,
  `arrival_date` timestamp NULL DEFAULT NULL,
  `container_date` timestamp NULL DEFAULT NULL,
  `container_place` varchar(5000) DEFAULT NULL,
  `kc` varchar(30) DEFAULT NULL,
  `st` varchar(30) DEFAULT NULL,
  `dhl_st` varchar(30) DEFAULT NULL,
  `dhl_fit` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `container`
--

INSERT INTO `container` (`id`, `exporter_group_id`, `exporter_id`, `station_id`, `way_id`, `destination_id`, `number`, `owner_id`, `stamp_type_id`, `stamp_num`, `loading_date`, `loading_place_id`, `carrier_id`, `weight`, `dt`, `shipment_num`, `railway_num`, `issue_date`, `consignee_id`, `border_date`, `arrival_date`, `container_date`, `container_place`, `kc`, `st`, `dhl_st`, `dhl_fit`) VALUES
(1, 2, 4, 1, 2, 2, 'GLLU9139618', 4, 3, '', '2017-12-07 17:00:00', 2, 4, 26000, '10611020/120117/0000438', '2207657', '51233940', '2017-12-05 17:00:00', 3, '2018-03-13 17:00:00', '2017-12-12 17:00:00', '2017-12-19 17:00:00', 'Тут может быть написано хоть что', '', '', '', ''),
(2, 1, 1, 1, 2, 2, 'G8127312F70', 3, 3, '', '2017-12-01 17:00:00', 2, 4, 0, '', '', '', '2017-12-13 17:00:00', NULL, NULL, NULL, NULL, '', '', '', '', ''),
(3, 6, 8, 3, 2, 2, 'ASD312312312', NULL, NULL, '', NULL, NULL, NULL, 0, '', '', '', NULL, NULL, NULL, NULL, NULL, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `day`
--

CREATE TABLE `day` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `day`
--

INSERT INTO `day` (`id`, `date`) VALUES
(1, '2018-01-26 17:00:00'),
(2, '2018-01-27 17:00:00'),
(3, '2018-01-28 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `destination`
--

CREATE TABLE `destination` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `destination`
--

INSERT INTO `destination` (`id`, `name`) VALUES
(2, 'Маньчжурия');

-- --------------------------------------------------------

--
-- Table structure for table `dryer`
--

CREATE TABLE `dryer` (
  `id` int(10) UNSIGNED NOT NULL,
  `number` varchar(128) NOT NULL,
  `switch` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dryer`
--

INSERT INTO `dryer` (`id`, `number`, `switch`) VALUES
(1, '1', 1),
(2, '2', 0),
(3, '3', 1),
(4, '4', 1),
(5, '5', 0),
(6, '6', 0),
(7, '7', 0),
(8, '8', 1),
(9, '9', 1),
(10, '10', 1),
(11, '11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dryer_queue`
--

CREATE TABLE `dryer_queue` (
  `id` int(10) UNSIGNED NOT NULL,
  `dryer_id` int(10) UNSIGNED NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `size` varchar(256) NOT NULL,
  `cubage` varchar(512) NOT NULL,
  `packs` varchar(128) NOT NULL,
  `rows` varchar(128) NOT NULL,
  `comment` varchar(1024) DEFAULT NULL,
  `complete_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dryer_queue`
--

INSERT INTO `dryer_queue` (`id`, `dryer_id`, `start_date`, `size`, `cubage`, `packs`, `rows`, `comment`, `complete_date`) VALUES
(12, 1, '2017-12-29 21:00:00', '0,027*2', '155,52', '75', '16 двойные', 'белая не стандартная', '2018-01-16 21:00:00'),
(13, 1, '2018-01-16 21:00:00', '0,027*2', '155,52', '75', '16 двойные', 'белая не стандартная', NULL),
(14, 2, '2017-12-20 21:00:00', '0,027*2/2,5', '114,048+41,472=155,52', '55+16=72', '16 двойные', 'белая стандартная', '2018-01-05 21:00:00'),
(15, 2, '2018-01-05 21:00:00', '0,027*2', '155,52', '75', '16 двойные', 'белая стандартная', '2018-01-22 21:00:00'),
(16, 2, '2018-01-22 21:00:00', '0,027*2', '155,52', '75', '16 двойные', 'белая стандартная', NULL),
(17, 3, '2017-12-18 21:00:00', '0,027*2', '155,52', '16+15=75', '16 двойные', 'белая,белая стандарт', '2018-01-07 21:00:00'),
(18, 3, '2018-01-08 21:00:00', '0,027*2/2,5', '124,416+31,104=155,52', '60+12=72', '16 двойные', 'белая не стандартная не работает', NULL),
(19, 4, '2017-12-23 21:00:00', '0,027*2/2,5', '124,416+31,104=155,52', '60+12=72', '16 двойные', 'белая не стандарт', '2018-01-09 21:00:00'),
(20, 4, '2018-01-10 21:00:00', '0,027*2', '155,52', '75', '16 двойные', 'белая стандартная не работает', NULL),
(21, 5, '2017-12-28 21:00:00', '0,021*2', '143,64', '75', '19 двойные', 'белая не стандартная', '2018-01-12 21:00:00'),
(22, 5, '2018-01-12 21:00:00', '0,027*2,5', '155,52', '60', '16 двойные', 'белая стандарт', NULL),
(23, 6, '2017-12-25 21:00:00', '0,027*2', '155,52', '75', '16 двойные', 'белая стандартная', '2018-01-14 21:00:00'),
(24, 6, '2018-01-14 21:00:00', '0,027*2', '155,52', '75', '16 двойные', 'белая стандартная', NULL),
(25, 7, '2017-12-24 21:00:00', '0,019*2/2,4/3,6', '46,785+49,904+53,023=149,712', '27+24+17=68', '19 двойные', 'Чен', '2018-01-11 21:00:00'),
(26, 7, '2018-01-11 21:00:00', '0,033*2,4', '156,816', '75', '22', 'Чен не работает', '2018-01-24 21:00:00'),
(27, 8, '2017-12-27 21:00:00', '0,033*2,4/3,6', '31,363+112,907=144,27', '15+36=51', '22', 'Чен', '2018-01-06 21:00:00'),
(28, 8, '2018-01-06 21:00:00', '0,033*2/3,6', '26,136+112,907=139,043', '15+36=51', '22', 'Чен', '2018-01-15 21:00:00'),
(29, 8, '2018-01-15 21:00:00', '0,033*2/2,4/3,6', '26,136+62,726+56,453=145,315', '15+30+18=63', '22', 'Чен не работает', NULL),
(30, 9, '2017-12-26 21:00:00', '0,033*3,6', '141,134', '45', '22', 'Чен', '2018-01-07 21:00:00'),
(31, 9, '2018-01-07 21:00:00', '0,033*2/3,6', '62,726+84,68=147,406', '36+27=63', '22', 'Чен', '2018-01-17 21:00:00'),
(32, 9, '2018-01-17 21:00:00', '0,019*2,4/3,6', '31,19+112,285=143,475', '15+36=41', '19 двойные', 'Чен', NULL),
(33, 10, '2017-12-29 21:00:00', '0,033*2,4', '156,816', '75', '22', 'Чен', '2018-01-08 21:00:00'),
(34, 10, '2018-01-08 21:00:00', '0,033*2,4/3,6', '94,089+56,453=150,542', '45+18=65', '22', 'Чен', '2018-01-16 21:00:00'),
(35, 10, '2018-01-16 21:00:00', '0,033*2,4/3/3,6', '18,817+2,61+119,18=140,607', '9+1+38=46', '22', 'Чен  не работает', NULL),
(36, 11, '2017-12-24 21:00:00', '0,033*3,6', '141,134', '45', '22', 'Чен', '2018-01-04 21:00:00'),
(37, 11, '2018-01-04 21:00:00', '0,033*3,6', '141,134', '45', '22', 'Чен', '2018-01-13 21:00:00'),
(38, 11, '2018-01-13 21:00:00', '0,033*2/2,4', '26,136+125,452=151,588', '15+60=75', '22', 'Чен', '2018-01-22 21:00:00'),
(39, 11, '2018-01-22 21:00:00', '0,033*2,4/3/3,6', '2,09+7,84+131,725=141,655', '1+3+42=46', '22', 'Чен', NULL),
(40, 7, '2018-01-25 21:00:00', '0,033*2/2,4', '78,408+62,726=141,134', '45+30=75', '22', 'Чен', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exporter`
--

CREATE TABLE `exporter` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `group_id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exporter`
--

INSERT INTO `exporter` (`id`, `group_id`, `name`, `email`) VALUES
(1, 1, 'ЛесКом', ''),
(2, 2, 'ТЛТ', ''),
(3, 2, 'ТЛП', ''),
(4, 2, 'ТЛИ', ''),
(5, 3, 'Вэйда', ''),
(6, 4, 'ЛяньМэн', ''),
(7, 5, 'ДаЧжун', ''),
(8, 6, 'ПромЛесЭкспорт', '');

-- --------------------------------------------------------

--
-- Table structure for table `exporter_group`
--

CREATE TABLE `exporter_group` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '500'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exporter_group`
--

INSERT INTO `exporter_group` (`id`, `name`, `sort`) VALUES
(1, 'ЛесКом', 100),
(2, 'ТЛТ/ТЛП/ТЛИ', 200),
(3, 'Вэйда', 300),
(4, 'ЛяньМэн', 500),
(5, 'ДаЧжун', 500),
(6, 'ПромЛесЭкспорт', 500);

-- --------------------------------------------------------

--
-- Table structure for table `exporter_group_branch`
--

CREATE TABLE `exporter_group_branch` (
  `branch_id` tinyint(3) UNSIGNED NOT NULL,
  `exporter_group_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exporter_group_branch`
--

INSERT INTO `exporter_group_branch` (`branch_id`, `exporter_group_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 7),
(3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `incoming`
--

CREATE TABLE `incoming` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `car` varchar(16) NOT NULL,
  `cargo` varchar(64) NOT NULL,
  `place_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `incoming_place`
--

CREATE TABLE `incoming_place` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `incoming_place`
--

INSERT INTO `incoming_place` (`id`, `name`) VALUES
(1, 'Южная 8'),
(2, 'Южная 9');

-- --------------------------------------------------------

--
-- Table structure for table `loading_place`
--

CREATE TABLE `loading_place` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loading_place`
--

INSERT INTO `loading_place` (`id`, `name`) VALUES
(2, 'Советская, 2'),
(3, 'Ленинская, 1Б'),
(4, 'Колывань');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(128) NOT NULL,
  `container_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `date`, `name`, `container_id`) VALUES
(2, '2017-12-04 09:42:00', 'Киселевск', 1),
(3, '2017-12-04 09:45:15', 'Томск, пр. Ленина 186', 2),
(4, '2017-12-04 09:45:30', 'Кемерово, площадь Пушкина', 2),
(5, '2017-12-04 09:50:13', 'Томск', 3),
(6, '2017-12-04 09:50:32', 'Междуреченск', 3),
(7, '2017-12-05 05:14:50', 'Томск, пр. Ленина 190', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_names`
--

CREATE TABLE `model_names` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `vin_name` varchar(128) NOT NULL,
  `rod_name` varchar(128) NOT NULL,
  `rule` varchar(32) DEFAULT NULL,
  `sort` smallint(6) DEFAULT '9999',
  `parent` smallint(5) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `model_names`
--

INSERT INTO `model_names` (`id`, `code`, `name`, `vin_name`, `rod_name`, `rule`, `sort`, `parent`) VALUES
(10, 'user', 'Пользователи', 'Пользователя', 'Пользователя', 'readUser', 9999, 0),
(15, 'dryer', 'Сушилки', 'Сушилку', 'Сушилки', 'readDryer', 450, 0),
(16, 'cash', 'Платежи', 'Платеж', 'Платежа', 'readCash', 200, 0),
(17, 'wood', 'Отгрузки', 'Отгрузку', 'Отгрузки', 'readWood', 300, 0),
(18, 'data', 'Справочники', 'Справочник', 'Справочника', NULL, 3000, 0),
(19, 'woodProvider', 'Поставщики леса', 'Поставщика', 'Поставщика', 'readWood', 100, 18),
(20, 'parabelProvider', 'Поставщики (парабель)', 'Поставщика', 'Поставщика', 'readParabel', 200, 18),
(21, 'parabel', 'Машины из Парабели', 'Отгрузку', 'Отгрузки', 'readParabel', 500, 0),
(22, 'incoming', 'Входящий транспорт', 'Запись', 'Записи', 'readIncoming', 600, 0),
(23, 'exporterGroup', 'Группы экспортеров', 'Группу', 'Группы', 'readContainer', 300, 38),
(24, 'exporter', 'Экспортеры', 'Экспортера', 'Экспортера', 'readContainer', 400, 38),
(25, 'branch', 'Филиалы', 'Филиал', 'Филиала', 'readContainer', 500, 38),
(26, 'station', 'Станции', 'Станцию', 'Станции', 'readContainer', 600, 38),
(27, 'way', 'Маршруты', 'Маршрут', 'Маршрута', 'readContainer', 700, 38),
(28, 'destination', 'Пункты назначения', 'Пункт', 'Пункта', 'readContainer', 800, 38),
(29, 'owner', 'Собственники', 'Собственника', 'Собственника', 'readContainer', 900, 38),
(30, 'stampType', 'Типы пломб', 'Тип', 'Типа', 'readContainer', 1000, 38),
(31, 'loadingPlace', 'Места погрузки', 'Место', 'Места', 'readContainer', 1100, 38),
(32, 'carrier', 'Перевозчики', 'Перевозчика', 'Перевозчика', 'readContainer', 1200, 38),
(33, 'consignee', 'Грузополучатели', 'Грузополучателя', 'Грузополучателя', 'readContainer', 1300, 38),
(34, 'ParabelType', 'Типы груза (парабель)', 'Тип', 'Типа', 'readParabel', 250, 18),
(35, 'container', 'Контейнеры', 'Контейнер', 'Контейнера', 'readContainer', 50, 0),
(36, 'board', 'Доски Чин', 'Отгрузку', 'Отгрузки', 'readBoard', 400, 0),
(37, 'plant', 'Заводы (доски Чин)', 'Завод', 'Завода', 'updateBoard', 280, 18),
(38, 'data', 'Справочники (контейнер)', 'Справочник', 'Справочника', NULL, 3100, 0),
(39, 'sawmill', 'Пилорамы', 'Пилораму', 'Пилорамы', 'readSaw', 400, 18),
(40, 'plankGroup', 'Группы досок', 'Группу', 'Группы', 'readSaw', 500, 18),
(41, 'plank', 'Типы досок', 'Тип', 'Типа', 'readSaw', 600, 18),
(42, 'china', 'Рабочие Китайцы', 'Рабочего', 'Рабочего', 'readChina', 700, 0),
(43, 'saw', 'Работа на пилораме', 'Рабочий день', 'Рабочего дня', 'readSaw', 650, 0),
(44, 'incomingplace', 'Места (вх. транспорт)', 'Место', 'Места', 'updateIncoming', 300, 18),
(45, 'species', 'Породы', 'Породу', 'Породы', 'readWood', 350, 18),
(46, 'stats', 'Статистика', 'Статистика', 'Статистика', NULL, 0, 0),
(47, 'woodGroup', 'Группы отгрузок', 'Группу', 'Группы', 'readWood', 110, 18),
(48, 'post', 'Должности', 'Должность', 'Должности', 'readWorker', 700, 18),
(49, 'worker', 'Рабочие', 'Рабочего', 'Рабочего', 'readWorker', 800, 0),
(50, 'relocPlank', 'Типы досок (перекладка)', 'Тип', 'Типа', 'readReloc', 800, 18),
(51, 'work', 'Работа', 'День', 'Дня', 'readWorker', 900, 0),
(52, 'reloc', 'Перекладка досок', 'День', 'Дня', 'readReloc', 1000, 0),
(53, 'cargoType', 'Типы груза', 'Тип', 'Типа', 'readContainer', 1400, 38);

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`id`, `name`) VALUES
(2, 'РИС'),
(3, 'Tez Zhol (КЗХ)'),
(4, 'СкайВэй'),
(5, 'ГКЛ');

-- --------------------------------------------------------

--
-- Table structure for table `parabel`
--

CREATE TABLE `parabel` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `parabel_cargo`
--

CREATE TABLE `parabel_cargo` (
  `parabel_id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `cubage` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parabel_cargo`
--

INSERT INTO `parabel_cargo` (`parabel_id`, `provider_id`, `cubage`) VALUES
(1, 1, 1),
(1, 2, 2),
(2, 1, 4),
(2, 2, 2),
(3, 1, 1),
(4, 1, 10),
(4, 2, 123.123),
(5, 1, 23),
(5, 2, 213),
(6, 1, 10),
(6, 2, 21),
(7, 1, 2),
(7, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `parabel_provider`
--

CREATE TABLE `parabel_provider` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '500'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parabel_provider`
--

INSERT INTO `parabel_provider` (`id`, `name`, `sort`) VALUES
(1, 'Идеал', 100),
(2, 'Олег', 200);

-- --------------------------------------------------------

--
-- Table structure for table `parabel_type`
--

CREATE TABLE `parabel_type` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parabel_type`
--

INSERT INTO `parabel_type` (`id`, `name`) VALUES
(1, 'Доски'),
(2, 'Круглый лес');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `name`) VALUES
(1, 'Покупки'),
(2, 'Поставщики');

-- --------------------------------------------------------

--
-- Table structure for table `plank`
--

CREATE TABLE `plank` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL,
  `group_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plank`
--

INSERT INTO `plank` (`id`, `name`, `group_id`) VALUES
(1, '2.2/2', 1),
(2, '2.7/2', 1),
(3, '2.7/2 стандарт', 1),
(4, '3.8/2', 1),
(5, '2.2/2.5', 1),
(6, '2.7 стандарт/2.5', 1),
(7, '2.7 стандарт', 2),
(8, '2.2/2', 2),
(9, 'Брусок', 3),
(10, 'Прокладки', 3),
(11, '2/5 стандарт', 2),
(12, '3,2*8,2*3', 4);

-- --------------------------------------------------------

--
-- Table structure for table `plank_group`
--

CREATE TABLE `plank_group` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL,
  `price` float NOT NULL,
  `short` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plank_group`
--

INSERT INTO `plank_group` (`id`, `name`, `price`, `short`) VALUES
(1, 'Белые доски', 20, 'Бел.'),
(2, 'Черные доски', 15, 'Черн.'),
(3, 'Прокладки + брусок', 25, 'П+Б'),
(4, 'Ель,пихта', 16, 'ель,пихт');

-- --------------------------------------------------------

--
-- Table structure for table `plant`
--

CREATE TABLE `plant` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `is_price` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plant`
--

INSERT INTO `plant` (`id`, `name`, `is_price`) VALUES
(1, 'Парабель', 0),
(2, 'Завод', 0),
(3, 'Завод (без сушки)', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `name`) VALUES
(1, 'Разнорабочий'),
(2, 'Кочегар');

-- --------------------------------------------------------

--
-- Table structure for table `reloc`
--

CREATE TABLE `reloc` (
  `worker_id` smallint(5) UNSIGNED NOT NULL,
  `plank_id` tinyint(3) UNSIGNED NOT NULL,
  `day_id` smallint(5) UNSIGNED NOT NULL,
  `count` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reloc`
--

INSERT INTO `reloc` (`worker_id`, `plank_id`, `day_id`, `count`) VALUES
(5, 1, 2, 1),
(5, 1, 3, 5),
(5, 2, 3, 2),
(5, 3, 2, 7),
(5, 3, 3, 10),
(5, 4, 2, 2),
(5, 5, 2, 3),
(5, 5, 3, 2),
(5, 6, 2, 4),
(6, 1, 2, 2),
(6, 3, 2, 4),
(6, 3, 3, 5),
(6, 4, 2, 6),
(6, 5, 2, 6),
(7, 2, 2, 3),
(7, 3, 3, 100),
(7, 5, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `reloc_plank`
--

CREATE TABLE `reloc_plank` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `price` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reloc_plank`
--

INSERT INTO `reloc_plank` (`id`, `name`, `price`) VALUES
(1, '2.5 береза сухая', 50),
(2, '3.5 ель сырая', 60),
(3, '1.9 пихта сухая', 35),
(4, '2.7 ель сухая', 46),
(5, '5.6 береза сухая', 70),
(6, '5.6 береза сырая', 80);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `code`, `name`) VALUES
(1, 'root', 'Создатель'),
(2, 'director', 'Директор'),
(4, 'dryerManager', 'Управляющий сушилками'),
(5, 'parabelManager', 'Ответственный за Парабель'),
(6, 'cashManager', 'Управляющий финансами'),
(7, 'woodManager', 'Управляющий отгрузками'),
(8, 'incomingManager', 'Ответственный за входящий транспорт'),
(9, 'boardManager', 'Ответственный за доски Чин'),
(10, 'sawManager', 'Управляющий пилорамами'),
(11, 'workerManager', 'Управляющий рабочими');

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `day_id` smallint(5) UNSIGNED NOT NULL,
  `worker_id` smallint(5) UNSIGNED NOT NULL,
  `calc_pay` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `day_pay` mediumint(9) NOT NULL DEFAULT '0',
  `k` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`day_id`, `worker_id`, `calc_pay`, `day_pay`, `k`) VALUES
(1, 2, 500, 500, 1),
(1, 3, 720, 120, 1.2),
(2, 2, 500, 0, 1),
(2, 3, 1200, 0, 2),
(2, 4, 3000, 0, 3),
(2, 5, 917, 100, 0),
(2, 6, 936, 0, 0),
(2, 7, 460, 0, 0),
(3, 2, 500, 0, 1),
(3, 3, 600, 0, 1),
(3, 4, 1000, 0, 1),
(3, 5, 860, 200, 0),
(3, 6, 175, 0, 0),
(3, 7, 3500, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `saw`
--

CREATE TABLE `saw` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sawmill_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `saw`
--

INSERT INTO `saw` (`id`, `date`, `sawmill_id`) VALUES
(15, '2018-01-02 17:00:00', 1),
(16, '2018-01-03 21:00:00', 1),
(17, '2018-01-04 21:00:00', 1),
(18, '2018-01-05 21:00:00', 1),
(19, '2018-01-06 21:00:00', 1),
(20, '2018-01-07 21:00:00', 1),
(21, '2018-01-08 21:00:00', 1),
(22, '2018-01-09 21:00:00', 1),
(23, '2018-01-10 21:00:00', 1),
(24, '2018-01-12 21:00:00', 1),
(25, '2018-01-13 21:00:00', 1),
(26, '2018-01-14 21:00:00', 1),
(27, '2018-01-15 21:00:00', 1),
(28, '2018-01-16 21:00:00', 1),
(29, '2018-01-02 21:00:00', 3),
(30, '2018-01-03 21:00:00', 3),
(31, '2018-01-04 21:00:00', 3),
(32, '2018-01-05 21:00:00', 3),
(33, '2018-01-06 21:00:00', 3),
(34, '2018-01-07 21:00:00', 3),
(35, '2018-01-08 21:00:00', 3),
(36, '2018-01-09 21:00:00', 3),
(37, '2018-01-10 21:00:00', 3),
(38, '2018-01-12 21:00:00', 3),
(39, '2018-01-13 21:00:00', 3),
(40, '2018-01-14 21:00:00', 3),
(41, '2018-01-15 21:00:00', 3),
(42, '2018-01-16 21:00:00', 3),
(43, '2018-01-02 21:00:00', 4),
(44, '2018-01-03 21:00:00', 4),
(45, '2018-01-04 21:00:00', 4),
(46, '2018-01-05 21:00:00', 4),
(47, '2018-01-08 21:00:00', 4),
(48, '2018-01-09 21:00:00', 4),
(49, '2018-01-10 21:00:00', 4),
(50, '2018-01-12 21:00:00', 4),
(51, '2018-01-13 21:00:00', 4),
(52, '2018-01-14 21:00:00', 4),
(53, '2018-01-15 21:00:00', 4),
(54, '2018-01-16 21:00:00', 4),
(55, '2018-01-02 21:00:00', 5),
(56, '2018-01-03 21:00:00', 5),
(57, '2018-01-04 21:00:00', 5),
(58, '2018-01-05 21:00:00', 5),
(59, '2018-01-06 21:00:00', 5),
(60, '2018-01-07 21:00:00', 5),
(61, '2018-01-08 21:00:00', 5),
(62, '2018-01-09 21:00:00', 5),
(63, '2018-01-10 21:00:00', 5),
(64, '2018-01-12 21:00:00', 5),
(65, '2018-01-13 21:00:00', 5),
(66, '2018-01-14 21:00:00', 5),
(67, '2018-01-15 21:00:00', 5),
(68, '2018-01-02 21:00:00', 6),
(69, '2018-01-03 21:00:00', 6),
(70, '2018-01-04 21:00:00', 6),
(71, '2018-01-05 21:00:00', 6),
(72, '2018-01-06 21:00:00', 6),
(73, '2018-01-07 21:00:00', 6),
(74, '2018-01-08 21:00:00', 6),
(75, '2018-01-09 21:00:00', 6),
(76, '2018-01-10 21:00:00', 6),
(77, '2018-01-12 21:00:00', 6),
(78, '2018-01-13 21:00:00', 6),
(79, '2018-01-14 21:00:00', 6),
(80, '2018-01-15 21:00:00', 6),
(81, '2018-01-16 21:00:00', 6),
(82, '2018-01-02 21:00:00', 7),
(83, '2018-01-03 21:00:00', 7),
(84, '2018-01-04 21:00:00', 7),
(85, '2018-01-05 21:00:00', 7),
(86, '2018-01-06 21:00:00', 7),
(87, '2018-01-07 21:00:00', 7),
(88, '2018-01-08 21:00:00', 7),
(89, '2018-01-10 21:00:00', 7),
(90, '2018-01-12 21:00:00', 7),
(91, '2018-01-13 21:00:00', 7),
(92, '2018-01-14 21:00:00', 7),
(93, '2018-01-17 21:00:00', 1),
(94, '2018-01-17 21:00:00', 6),
(95, '2018-01-24 21:00:00', 3),
(96, '2018-01-17 21:00:00', 4),
(97, '2018-01-18 21:00:00', 4),
(98, '2018-01-18 21:00:00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `sawmill`
--

CREATE TABLE `sawmill` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sawmill`
--

INSERT INTO `sawmill` (`id`, `name`) VALUES
(1, '五号锯ван王'),
(3, '六号锯ЧАН 张锯房出材表'),
(4, '一号锯Чжоу周'),
(5, '三号锯Юэ岳'),
(6, '四号锯МА马'),
(7, '二号锯Лю刘');

-- --------------------------------------------------------

--
-- Table structure for table `saw_china`
--

CREATE TABLE `saw_china` (
  `china_id` smallint(5) UNSIGNED NOT NULL,
  `saw_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `saw_plank`
--

CREATE TABLE `saw_plank` (
  `saw_id` int(10) UNSIGNED NOT NULL,
  `plank_id` tinyint(3) UNSIGNED NOT NULL,
  `cubage` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `saw_plank`
--

INSERT INTO `saw_plank` (`saw_id`, `plank_id`, `cubage`) VALUES
(14, 1, 1),
(14, 2, 1),
(14, 3, 1),
(14, 4, 1),
(14, 5, 1),
(14, 6, 1),
(14, 7, 1),
(14, 8, 1),
(14, 9, 1),
(14, 10, 1),
(14, 11, 1),
(15, 2, 3),
(15, 6, 7.2),
(15, 8, 3),
(16, 2, 3),
(16, 6, 4.8),
(16, 8, 3),
(17, 1, 3),
(17, 2, 6),
(17, 6, 7.2),
(18, 2, 3),
(18, 6, 5.7),
(18, 8, 3),
(19, 1, 3),
(19, 2, 3),
(19, 6, 4.8),
(20, 2, 3),
(20, 6, 7.2),
(20, 8, 3),
(21, 2, 6),
(21, 6, 7.2),
(21, 7, 3),
(22, 2, 6),
(22, 6, 7.2),
(22, 7, 3),
(23, 1, 3),
(23, 2, 3),
(23, 6, 7.2),
(24, 2, 6),
(24, 6, 7.2),
(24, 7, 3),
(25, 2, 6),
(25, 6, 7.2),
(26, 1, 3),
(26, 2, 3),
(26, 6, 7.2),
(26, 7, 3),
(27, 2, 6),
(27, 3, 7.2),
(27, 7, 3),
(28, 2, 3),
(28, 6, 4.8),
(29, 2, 6),
(29, 3, 5.7),
(29, 8, 3),
(30, 2, 6),
(30, 3, 3.8),
(30, 8, 3),
(31, 1, 3),
(31, 2, 3),
(31, 3, 5.7),
(31, 8, 6),
(32, 2, 3),
(32, 3, 5.7),
(32, 8, 3),
(33, 2, 3),
(33, 3, 5.7),
(33, 8, 3),
(34, 1, 3),
(34, 2, 6),
(34, 3, 3.8),
(34, 8, 3),
(35, 2, 3),
(35, 3, 5.7),
(35, 7, 3),
(36, 2, 6),
(36, 3, 7.6),
(37, 1, 3),
(37, 2, 3),
(37, 3, 5.7),
(37, 7, 3),
(38, 2, 9),
(38, 3, 7.6),
(38, 7, 3),
(39, 2, 6),
(39, 3, 5.7),
(40, 1, 3),
(40, 2, 3),
(40, 3, 7.6),
(40, 7, 3),
(41, 2, 3),
(41, 3, 5.7),
(41, 7, 6),
(42, 2, 6),
(42, 3, 7.6),
(42, 7, 3),
(43, 2, 3),
(43, 3, 9),
(43, 8, 3),
(44, 2, 6),
(44, 3, 6),
(44, 8, 3),
(45, 1, 3),
(45, 2, 6),
(45, 3, 6),
(45, 8, 3),
(46, 2, 6),
(46, 3, 9),
(47, 1, 3),
(47, 2, 3),
(47, 3, 9),
(47, 7, 3),
(47, 8, 3),
(48, 2, 6),
(48, 7, 3),
(49, 2, 3),
(49, 3, 12),
(49, 7, 6),
(50, 1, 3),
(50, 2, 6),
(50, 3, 6),
(50, 7, 3),
(51, 2, 3),
(51, 3, 9),
(51, 7, 3),
(52, 2, 6),
(52, 3, 6),
(52, 7, 6),
(53, 1, 3),
(53, 2, 3),
(53, 3, 12),
(53, 7, 6),
(54, 2, 3),
(54, 3, 6),
(54, 7, 3),
(55, 2, 6),
(55, 3, 3),
(55, 8, 3),
(56, 1, 3),
(56, 2, 3),
(56, 3, 6),
(56, 8, 3),
(57, 2, 3),
(57, 3, 6),
(57, 8, 6),
(58, 2, 9),
(58, 3, 6),
(58, 8, 3),
(59, 1, 3),
(59, 2, 6),
(59, 3, 6),
(59, 8, 3),
(60, 2, 3),
(60, 3, 3),
(60, 7, 3),
(61, 2, 6),
(61, 3, 9),
(62, 2, 6),
(62, 3, 6),
(62, 7, 3),
(63, 1, 3),
(63, 2, 6),
(63, 3, 6),
(63, 7, 3),
(64, 2, 6),
(64, 3, 6),
(65, 2, 6),
(65, 3, 6),
(65, 7, 3),
(66, 2, 6),
(66, 3, 6),
(66, 7, 3),
(67, 2, 6),
(67, 3, 6),
(68, 2, 6),
(68, 3, 3.8),
(68, 8, 6),
(69, 1, 3),
(69, 2, 6),
(69, 3, 3.8),
(69, 8, 6),
(70, 2, 6),
(70, 3, 3.8),
(70, 8, 6),
(71, 2, 3),
(71, 3, 3.8),
(71, 8, 6),
(72, 1, 3),
(72, 2, 3),
(72, 3, 3.8),
(72, 8, 6),
(73, 2, 3),
(73, 3, 7.6),
(73, 8, 3),
(74, 2, 6),
(74, 3, 7.6),
(74, 7, 3),
(75, 1, 3),
(75, 2, 9),
(75, 3, 7.6),
(75, 7, 3),
(76, 2, 3),
(76, 3, 7.6),
(76, 7, 3),
(77, 2, 3),
(77, 3, 7.6),
(77, 7, 6),
(78, 1, 3),
(78, 2, 6),
(78, 3, 7.6),
(78, 7, 3),
(79, 3, 5.7),
(79, 7, 3),
(80, 2, 6),
(80, 3, 7.6),
(80, 7, 6),
(81, 2, 3),
(81, 3, 7.6),
(81, 7, 3),
(82, 2, 3),
(82, 3, 9),
(82, 8, 3),
(83, 1, 3),
(83, 2, 6),
(83, 3, 3),
(83, 8, 3),
(84, 2, 3),
(84, 3, 6),
(84, 8, 3),
(85, 2, 6),
(85, 3, 6),
(85, 8, 3),
(86, 2, 3),
(86, 3, 3),
(87, 2, 3),
(87, 3, 6),
(87, 8, 3),
(88, 1, 3),
(88, 2, 6),
(88, 3, 6),
(89, 2, 3),
(89, 3, 9),
(89, 7, 3),
(90, 2, 3),
(90, 3, 6),
(91, 2, 6),
(91, 3, 6),
(91, 7, 3),
(92, 1, 3),
(92, 2, 3),
(92, 3, 6),
(93, 1, 5),
(93, 2, 3),
(93, 3, 8.7),
(93, 7, 3),
(94, 1, 3),
(94, 2, 3),
(94, 3, 1),
(94, 7, 2.3),
(94, 12, 5),
(95, 2, 4),
(95, 3, 1.5),
(95, 7, 1),
(95, 12, 5),
(96, 2, 6),
(96, 3, 6),
(96, 7, 3),
(97, 1, 3),
(97, 2, 3),
(97, 3, 9),
(98, 2, 6),
(98, 3, 6),
(98, 7, 6);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text,
  `code` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '9999'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `code`, `sort`) VALUES
(4, 'Активность парсинга', 'on', 'TOGGLE', 9999),
(5, 'Время последнего действия парсинга', '1486321792', 'TIME', 9999);

-- --------------------------------------------------------

--
-- Table structure for table `species`
--

CREATE TABLE `species` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `species`
--

INSERT INTO `species` (`id`, `name`) VALUES
(1, 'Береза'),
(2, 'Ель, пихта, сосна');

-- --------------------------------------------------------

--
-- Table structure for table `stamp_type`
--

CREATE TABLE `stamp_type` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stamp_type`
--

INSERT INTO `stamp_type` (`id`, `name`) VALUES
(3, 'Клещ 60 СЦ'),
(4, 'ВОХР');

-- --------------------------------------------------------

--
-- Table structure for table `station`
--

CREATE TABLE `station` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `branch_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `station`
--

INSERT INTO `station` (`id`, `name`, `branch_id`) VALUES
(1, 'Клещиха', 1),
(2, 'Томск', 1),
(3, 'Базаиха', 3),
(4, 'Иня', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `name`, `email`, `surname`, `active`, `token`) VALUES
(1, 'root', '85676905d35fb12da70e8cb8bc8cebb0', 'Михаил', 'beatbox787@gmail.com', 'Китаев', 1, '65d65cc279793a81d4b72294f66138c4'),
(4, 'van', '85676905d35fb12da70e8cb8bc8cebb0', 'Андрей', 'test@test.ru', 'Ван', 1, NULL),
(5, 'lera', '79cdbd83c1d2845f4ca5289b530c9722', 'Лера', 'test@test.ru', '', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_branch`
--

CREATE TABLE `user_branch` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `branch_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`user_id`, `role_id`) VALUES
(1, 1),
(4, 2),
(5, 4),
(5, 5),
(5, 6),
(5, 7),
(5, 8),
(5, 9),
(5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `user_widget`
--

CREATE TABLE `user_widget` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `widget_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_widget`
--

INSERT INTO `user_widget` (`user_id`, `widget_id`) VALUES
(1, 1),
(4, 1),
(5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `way`
--

CREATE TABLE `way` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `way`
--

INSERT INTO `way` (`id`, `name`) VALUES
(2, 'Забайкальск-Маньчжурия');

-- --------------------------------------------------------

--
-- Table structure for table `widget`
--

CREATE TABLE `widget` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `widget`
--

INSERT INTO `widget` (`id`, `code`, `name`) VALUES
(1, 'widgetStats', 'Статистика');

-- --------------------------------------------------------

--
-- Table structure for table `wood`
--

CREATE TABLE `wood` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `provider_id` int(10) UNSIGNED DEFAULT NULL,
  `cubage` float NOT NULL,
  `price` float NOT NULL,
  `sum` float NOT NULL DEFAULT '0',
  `payment_id` tinyint(4) NOT NULL DEFAULT '0',
  `car` varchar(10) NOT NULL,
  `who` varchar(128) DEFAULT NULL,
  `paid` tinyint(1) DEFAULT NULL,
  `comment` varchar(256) NOT NULL,
  `species_id` tinyint(3) UNSIGNED NOT NULL,
  `group_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wood`
--

INSERT INTO `wood` (`id`, `date`, `provider_id`, `cubage`, `price`, `sum`, `payment_id`, `car`, `who`, `paid`, `comment`, `species_id`, `group_id`) VALUES
(5, '2018-01-04 21:00:00', NULL, 13, 3200, 41600, 1, 'Е962ТК', '', NULL, 'Лебедев', 1, 1),
(6, '2018-01-04 21:00:00', NULL, 14, 2600, 36400, 1, 'Е962ТК', '', NULL, 'Лебедев', 1, 1),
(7, '2018-01-04 21:00:00', NULL, 12.8, 3200, 40960, 1, 'Е718СХ', '', NULL, 'Лебедев', 1, 1),
(8, '2018-01-04 21:00:00', NULL, 13.2, 2600, 34320, 1, 'Е718СХ', '', NULL, 'Лебедев', 1, 1),
(9, '2018-01-04 21:00:00', NULL, 12.9, 3200, 41280, 1, 'С734ВН', '', NULL, 'Лебедев', 1, 1),
(10, '2018-01-04 21:00:00', NULL, 9.554, 2600, 24840.4, 1, 'С734ВН', '', NULL, 'Лебедев', 1, 1),
(11, '2018-01-05 21:00:00', NULL, 20.5, 3300, 67500, 1, 'У963ВС', '', NULL, '', 1, 1),
(12, '2018-01-05 21:00:00', NULL, 6, 3000, 18000, 1, 'Е609РУ', '', NULL, '', 1, 1),
(13, '2018-01-06 21:00:00', NULL, 9, 2900, 26000, 1, 'м086кк', '', NULL, '', 1, 1),
(14, '2018-01-06 21:00:00', NULL, 11, 3000, 33000, 1, 'Е969КЕ', '', NULL, '', 1, 1),
(15, '2018-01-06 21:00:00', NULL, 5, 3000, 15000, 1, 'Е148ММ', '', NULL, '', 1, 1),
(16, '2018-01-06 21:00:00', NULL, 9, 2900, 26000, 1, 'м086кк', '', NULL, '', 1, 1),
(17, '2018-01-07 21:00:00', NULL, 5.7, 3000, 17000, 1, 'Е609РУ', '', NULL, '', 1, 1),
(18, '2018-01-07 21:00:00', NULL, 4, 3000, 12000, 1, 'Е148ММ', '', NULL, '', 1, 1),
(19, '2018-01-07 21:00:00', NULL, 6, 3000, 18000, 1, 'Е148ММ', '', NULL, '', 1, 1),
(20, '2018-01-08 21:00:00', NULL, 21, 3300, 69300, 1, 'У963ВС', '', NULL, '', 1, 1),
(21, '2018-01-08 21:00:00', NULL, 26, 3000, 78000, 1, 'р955сх', '', NULL, '', 1, 1),
(22, '2018-01-08 21:00:00', NULL, 26, 3100, 80500, 1, 'к537нр', '', NULL, '', 1, 1),
(23, '2018-01-08 21:00:00', NULL, 6.3, 3000, 19000, 1, 'Е148ММ', '', NULL, '', 1, 1),
(24, '2018-01-09 21:00:00', NULL, 20, 3300, 66000, 1, 'У963ВС', '', NULL, '', 1, 1),
(25, '2018-01-09 21:00:00', NULL, 19, 2800, 53200, 1, 'Е383ТК', '', NULL, '', 1, 1),
(26, '2018-01-09 21:00:00', NULL, 25.5, 3100, 79000, 1, 'к537нр', '', NULL, '', 1, 1),
(27, '2018-01-09 21:00:00', NULL, 10, 3000, 30000, 1, 'о782см', '', NULL, '', 1, 1),
(28, '2018-01-09 21:00:00', NULL, 9, 3000, 27000, 1, 'в785тн', '', NULL, '', 1, 1),
(29, '2018-01-10 21:00:00', NULL, 10, 3000, 30000, 1, 'Е434МО', '', NULL, '', 1, 1),
(30, '2018-01-10 21:00:00', NULL, 21, 3000, 63000, 1, 'Е240ОТ', '', NULL, '', 1, 1),
(31, '2018-01-10 21:00:00', NULL, 25, 3000, 75000, 1, 'М535ХТ', '', NULL, '', 1, 1),
(32, '2018-01-11 21:00:00', NULL, 26, 3000, 78000, 1, 'М230СТ', '', NULL, '', 1, 1),
(33, '2018-01-11 21:00:00', NULL, 27, 3000, 81000, 1, 'В863ХВ', '', NULL, '', 1, 1),
(34, '2018-01-11 21:00:00', NULL, 30.5, 3100, 94550, 1, 'к537нр', '', NULL, '', 1, 1),
(35, '2018-01-11 21:00:00', NULL, 7, 3000, 21000, 1, 'Е609РУ', '', NULL, '', 1, 1),
(36, '2018-01-11 21:00:00', NULL, 8, 3000, 24000, 1, 'Е907СУ', '', NULL, '', 1, 1),
(37, '2018-01-11 21:00:00', NULL, 11, 3000, 33000, 1, 'Е240ОТ', '', NULL, '', 1, 1),
(38, '2018-01-11 21:00:00', NULL, 10, 3000, 30000, 1, 'Е434МО', '', NULL, '', 1, 1),
(39, '2018-01-11 21:00:00', NULL, 6, 3000, 18000, 1, 'Е148ММ', '', NULL, '', 1, 1),
(40, '2018-01-12 21:00:00', NULL, 11.5, 3000, 34500, 1, 'Е969КЕ', '', NULL, '', 1, 1),
(41, '2018-01-12 21:00:00', NULL, 24, 2800, 67200, 1, 'Е383ТК', '', NULL, '', 1, 1),
(42, '2018-01-12 21:00:00', NULL, 24, 2800, 67200, 1, 'н336ос', '', NULL, '', 1, 1),
(43, '2018-01-14 21:00:00', NULL, 13, 3100, 40300, 1, 'р700нр', '', NULL, '', 1, 1),
(44, '2018-01-14 21:00:00', NULL, 27, 3000, 81000, 1, 'М230СТ', '', NULL, '', 1, 1),
(45, '2018-01-14 21:00:00', NULL, 28, 3000, 84000, 1, 'В863ХВ', '', NULL, '', 1, 1),
(46, '2018-01-15 21:00:00', NULL, 13, 3100, 40300, 1, 'Е700РХ', '', NULL, '', 1, 1),
(47, '2018-01-16 21:00:00', NULL, 13, 3100, 40300, 1, 'Е700РХ', '', NULL, '', 1, 1),
(48, '2018-01-16 21:00:00', NULL, 6, 3000, 18000, 1, 'Е148ММ', '', NULL, '', 1, 1),
(49, '2018-01-16 21:00:00', NULL, 6.5, 3000, 19500, 1, 'Е907СУ', '', NULL, '', 1, 1),
(50, '2018-01-16 21:00:00', NULL, 13, 3100, 40300, 1, 'Е700РХ', '', NULL, '', 1, 1),
(51, '2018-01-16 21:00:00', NULL, 7, 2800, 19600, 1, 'Е907СУ', '', NULL, '', 1, 1),
(52, '2018-01-17 21:00:00', NULL, 13, 3100, 40300, 1, 'Е700РХ', '', NULL, '', 1, 1),
(53, '2018-01-17 21:00:00', NULL, 13, 3100, 40300, 1, 'Е700РХ', '', NULL, '', 1, 1),
(54, '2018-01-18 21:00:00', NULL, 26.5, 3000, 79500, 1, 'о396ее', '', NULL, '', 1, 1),
(55, '2018-01-24 21:00:00', NULL, 12, 3100, 37200, 1, 'Е700РХ', '', NULL, '', 1, 1),
(56, '2018-01-08 21:00:00', NULL, 39.4, 3100, 122140, 1, 'М224ЕС', '', NULL, '', 2, 1),
(57, '2018-01-08 21:00:00', NULL, 30.4, 3100, 94240, 1, 'В307ВМ', '', NULL, '', 2, 1),
(58, '2018-01-08 21:00:00', NULL, 35.8, 3100, 110980, 1, 'О314РК', '', NULL, '', 2, 1),
(59, '2018-01-08 21:00:00', NULL, 31.8, 3100, 98580, 1, 'С424УА', '', NULL, '', 2, 1),
(60, '2018-01-15 21:00:00', NULL, 30.6, 2900, 88740, 1, 'В404РА', '', NULL, '', 2, 1),
(61, '2018-01-15 21:00:00', NULL, 32.8, 2900, 95120, 1, 'В307ВМ', '', NULL, '', 2, 1),
(62, '2018-01-15 21:00:00', NULL, 34.8, 2900, 100920, 1, 'О314РК', '', NULL, '', 2, 1),
(63, '2018-01-09 21:00:00', 12, 22, 2800, 61600, 2, 'А564ОО', NULL, NULL, '', 1, 1),
(64, '2018-01-09 21:00:00', 12, 23.8, 2800, 66640, 2, 'О514МЕ', NULL, NULL, '', 1, 1),
(65, '2018-01-09 21:00:00', 12, 23.9, 2800, 66920, 2, 'Н165ЕР', NULL, NULL, '', 1, 1),
(66, '2018-01-04 21:00:00', 13, 4.546, 2600, 11819.6, 2, 'С734 ВН', NULL, NULL, '40%-60%', 1, 1),
(67, '2018-01-04 21:00:00', 13, 13.5, 3200, 43200, 2, 'М650РУ', NULL, NULL, '0%-40%', 1, 1),
(68, '2018-01-04 21:00:00', 13, 14.9, 2600, 38740, 2, 'М650РУ', NULL, NULL, '40%-60%', 1, 1),
(69, '2018-01-05 21:00:00', 13, 12.4, 3200, 39680, 2, 'Е718СХ', NULL, NULL, '0%-40%', 1, 1),
(70, '2018-01-05 21:00:00', 13, 14.3, 2600, 37180, 2, 'Е718СХ', NULL, NULL, '40%-60%', 1, 1),
(71, '2018-01-05 21:00:00', 13, 12.7, 3200, 40640, 2, 'Е962ТК', NULL, NULL, '0%-40%', 1, 1),
(72, '2018-01-05 21:00:00', 13, 14.3, 2600, 37180, 2, 'Е962ТК', NULL, NULL, '40%-60%', 1, 1),
(73, '2018-01-07 21:00:00', 13, 12.7, 3200, 40640, 2, 'Е962ТК', NULL, NULL, '0%-40%', 1, 1),
(74, '2018-01-07 21:00:00', 13, 14.3, 2600, 37180, 2, 'Е962ТК', NULL, NULL, '40%-60%', 1, 1),
(75, '2018-01-08 21:00:00', 13, 12.7, 3200, 40640, 2, 'Е718СХ', NULL, NULL, '0%-40%', 1, 1),
(76, '2018-01-08 21:00:00', 13, 14.3, 2600, 37180, 2, 'Е718СХ', NULL, NULL, '40%-60%', 1, 1),
(77, '2018-01-11 21:00:00', NULL, 35.132, 0, 0, 1, 'О282ТК', '', NULL, 'инкино', 1, 2),
(78, '2018-01-11 21:00:00', NULL, 35.312, 0, 0, 1, 'О060КА', '', NULL, 'инкино', 1, 2),
(79, '2018-01-11 21:00:00', NULL, 35.213, 0, 0, 1, 'Т200МТ', '', NULL, 'инкино', 1, 2),
(80, '2018-01-11 21:00:00', NULL, 35.132, 0, 0, 1, 'Е990КХ', '', NULL, 'инкино', 1, 2),
(81, '2018-01-11 21:00:00', NULL, 35.132, 0, 0, 1, 'С494ЕТ', '', NULL, 'инкино', 1, 2),
(82, '2018-01-12 21:00:00', NULL, 35.312, 0, 0, 1, 'О600РС', '', NULL, 'инкино', 1, 2),
(83, '2018-01-12 21:00:00', NULL, 35.413, 0, 0, 1, 'О454ЕЕ', '', NULL, 'инкино', 1, 2),
(84, '2018-01-25 21:00:00', NULL, 43.5, 3400, 147900, 1, 'К720КР', '', NULL, '28,12,2017', 2, 1),
(85, '2018-01-25 21:00:00', NULL, 43.3, 3400, 147220, 1, 'К732КР', '', NULL, '29,12,2017', 2, 1),
(86, '2018-01-25 21:00:00', NULL, 44, 3400, 149600, 1, 'К741КР', '', NULL, '29,12,2017', 2, 1),
(87, '2018-01-25 21:00:00', NULL, 43.6, 3400, 148240, 1, 'К732КР', '', NULL, '29,12,2017', 2, 1),
(88, '2018-01-25 21:00:00', NULL, 43.6, 3400, 148240, 1, 'К732КР', '', NULL, '18,01,2018', 2, 1),
(89, '2018-01-13 21:00:00', NULL, 33.132, 0, 0, 1, 'О282ТК', '', NULL, 'инкино', 1, 2),
(90, '2018-01-14 21:00:00', NULL, 35.132, 0, 0, 1, 'Е200МТ', '', NULL, 'инкино', 1, 2),
(91, '2018-01-14 21:00:00', NULL, 35.312, 0, 0, 1, 'С060КМ', '', NULL, 'инкино', 1, 2),
(92, '2018-01-15 21:00:00', NULL, 35.132, 0, 0, 1, 'О500АТ', '', NULL, 'инкино', 1, 2),
(93, '2018-01-15 21:00:00', NULL, 35.432, 0, 0, 1, 'Е990КХ', '', NULL, 'инкино', 1, 2),
(94, '2018-01-15 21:00:00', NULL, 37.132, 0, 40000, 1, 'К333ВВ', '', NULL, 'инкино', 1, 2),
(95, '2018-01-16 21:00:00', NULL, 35.431, 0, 0, 1, 'С060КМ', '', NULL, 'инкино', 1, 2),
(96, '2018-01-16 21:00:00', NULL, 35.321, 0, 0, 1, 'Е200МТ', '', NULL, 'инкино', 1, 2),
(97, '2018-01-16 21:00:00', NULL, 35.421, 0, 0, 1, 'Е990КХ', '', NULL, 'инкино', 1, 2),
(98, '2018-01-16 21:00:00', NULL, 35.313, 0, 0, 1, 'О600РС', '', NULL, 'инкино', 1, 2),
(99, '2018-01-17 21:00:00', NULL, 34.312, 0, 0, 1, 'О500АТ', '', NULL, 'инкино', 1, 2),
(100, '2018-01-18 21:00:00', NULL, 38.4, 0, 0, 1, 'к333вв', '', NULL, 'Бундюр (Кибиш)', 2, 3),
(101, '2018-01-18 21:00:00', NULL, 40.5, 0, 0, 1, 'а253оо', '', NULL, 'Бундюр (Кибиш)', 2, 3),
(102, '2018-01-18 21:00:00', 11, 29, 2500, 72500, 2, 'М230СТ', NULL, NULL, '', 1, 1),
(103, '2018-01-26 21:00:00', NULL, 45.138, 0, 0, 1, 'а253оо', '', NULL, 'Бундюр (Кибиш)', 2, 3),
(104, '2018-01-27 21:00:00', NULL, 45, 0, 0, 1, 'А253ОО', '', NULL, 'Бундюр (Кибиш)', 2, 3),
(105, '2018-01-27 21:00:00', 11, 28, 2500, 70000, 2, 'в863хв', NULL, NULL, '', 1, 1),
(106, '2018-01-27 21:00:00', 11, 28, 2500, 70000, 2, 'м230ст', NULL, NULL, '', 1, 1),
(107, '2018-02-04 17:00:00', 4, 38, 10000, 380000, 2, '123', NULL, NULL, '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wood_group`
--

CREATE TABLE `wood_group` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL,
  `sort` smallint(5) UNSIGNED NOT NULL DEFAULT '500'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wood_group`
--

INSERT INTO `wood_group` (`id`, `name`, `sort`) VALUES
(1, 'Общая', 100),
(2, 'Инкино', 200),
(3, 'Бундюр (Кибиш)', 300);

-- --------------------------------------------------------

--
-- Table structure for table `wood_provider`
--

CREATE TABLE `wood_provider` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(256) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '500'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wood_provider`
--

INSERT INTO `wood_provider` (`id`, `name`, `phone`, `email`, `sort`) VALUES
(3, 'ООО \"Лесоустроитель\"', '', '', 100),
(4, 'Глава крестьянского (фермерского) хозяйства Сосняков Владимир Леонидович', '', '', 200),
(5, 'Индивидуальный предприниматель Медведев Павел Васильевич', '', '', 300),
(6, 'Прогресс', '', '', 400),
(7, 'Малентрейд', '', '', 500),
(8, 'ООО Алтай-Форест', '', '', 600),
(9, 'ООО \"Сибирь\"', '', '', 600),
(10, 'Интелстрой', '', '', 500),
(11, 'ИП Струк', '', '', 500),
(12, 'Бессонова', '', '', 500),
(13, 'ИП Лебедев С.А.', '', '', 500),
(14, 'ИП Гринько С.В.', '', '', 500),
(15, 'Транссиб', '', '', 500);

-- --------------------------------------------------------

--
-- Table structure for table `worker`
--

CREATE TABLE `worker` (
  `id` smallint(10) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL,
  `post_id` tinyint(3) UNSIGNED NOT NULL,
  `salary` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `worker`
--

INSERT INTO `worker` (`id`, `name`, `post_id`, `salary`) VALUES
(2, 'Федоров Петр Арсеньевич', 2, 500),
(3, 'Чехов Антон Павлович', 2, 600),
(4, 'Павлов Сергей Сергеевич', 2, 1000),
(5, 'Семенов Сергей Андреевич', 1, 0),
(6, 'Курносов Андрей Викторович', 1, 0),
(7, 'Пименов Владислав Михайлович', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `board_item`
--
ALTER TABLE `board_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cargo_type`
--
ALTER TABLE `cargo_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carrier`
--
ALTER TABLE `carrier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash`
--
ALTER TABLE `cash`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_type`
--
ALTER TABLE `cash_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `china`
--
ALTER TABLE `china`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consignee`
--
ALTER TABLE `consignee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `container`
--
ALTER TABLE `container`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `day`
--
ALTER TABLE `day`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dryer`
--
ALTER TABLE `dryer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dryer_queue`
--
ALTER TABLE `dryer_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exporter`
--
ALTER TABLE `exporter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exporter_group`
--
ALTER TABLE `exporter_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exporter_group_branch`
--
ALTER TABLE `exporter_group_branch`
  ADD PRIMARY KEY (`branch_id`,`exporter_group_id`);

--
-- Indexes for table `incoming`
--
ALTER TABLE `incoming`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incoming_place`
--
ALTER TABLE `incoming_place`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loading_place`
--
ALTER TABLE `loading_place`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_names`
--
ALTER TABLE `model_names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parabel`
--
ALTER TABLE `parabel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parabel_cargo`
--
ALTER TABLE `parabel_cargo`
  ADD PRIMARY KEY (`parabel_id`,`provider_id`);

--
-- Indexes for table `parabel_provider`
--
ALTER TABLE `parabel_provider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parabel_type`
--
ALTER TABLE `parabel_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plank`
--
ALTER TABLE `plank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plank_group`
--
ALTER TABLE `plank_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plant`
--
ALTER TABLE `plant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reloc`
--
ALTER TABLE `reloc`
  ADD PRIMARY KEY (`worker_id`,`plank_id`,`day_id`);

--
-- Indexes for table `reloc_plank`
--
ALTER TABLE `reloc_plank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`day_id`,`worker_id`);

--
-- Indexes for table `saw`
--
ALTER TABLE `saw`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sawmill`
--
ALTER TABLE `sawmill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saw_china`
--
ALTER TABLE `saw_china`
  ADD PRIMARY KEY (`china_id`,`saw_id`);

--
-- Indexes for table `saw_plank`
--
ALTER TABLE `saw_plank`
  ADD PRIMARY KEY (`saw_id`,`plank_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `species`
--
ALTER TABLE `species`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stamp_type`
--
ALTER TABLE `stamp_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `station`
--
ALTER TABLE `station`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_branch`
--
ALTER TABLE `user_branch`
  ADD PRIMARY KEY (`user_id`,`branch_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`user_id`,`role_id`);

--
-- Indexes for table `user_widget`
--
ALTER TABLE `user_widget`
  ADD PRIMARY KEY (`user_id`,`widget_id`);

--
-- Indexes for table `way`
--
ALTER TABLE `way`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `widget`
--
ALTER TABLE `widget`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wood`
--
ALTER TABLE `wood`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wood_group`
--
ALTER TABLE `wood_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wood_provider`
--
ALTER TABLE `wood_provider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worker`
--
ALTER TABLE `worker`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `board`
--
ALTER TABLE `board`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `board_item`
--
ALTER TABLE `board_item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;
--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `cargo_type`
--
ALTER TABLE `cargo_type`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `carrier`
--
ALTER TABLE `carrier`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `cash`
--
ALTER TABLE `cash`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `cash_type`
--
ALTER TABLE `cash_type`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `china`
--
ALTER TABLE `china`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `consignee`
--
ALTER TABLE `consignee`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `container`
--
ALTER TABLE `container`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `day`
--
ALTER TABLE `day`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `destination`
--
ALTER TABLE `destination`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `dryer`
--
ALTER TABLE `dryer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `dryer_queue`
--
ALTER TABLE `dryer_queue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `exporter`
--
ALTER TABLE `exporter`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `exporter_group`
--
ALTER TABLE `exporter_group`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `incoming`
--
ALTER TABLE `incoming`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `incoming_place`
--
ALTER TABLE `incoming_place`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `loading_place`
--
ALTER TABLE `loading_place`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `model_names`
--
ALTER TABLE `model_names`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `parabel`
--
ALTER TABLE `parabel`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `parabel_provider`
--
ALTER TABLE `parabel_provider`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `parabel_type`
--
ALTER TABLE `parabel_type`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `plank`
--
ALTER TABLE `plank`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `plank_group`
--
ALTER TABLE `plank_group`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `plant`
--
ALTER TABLE `plant`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `reloc_plank`
--
ALTER TABLE `reloc_plank`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `saw`
--
ALTER TABLE `saw`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT for table `sawmill`
--
ALTER TABLE `sawmill`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `species`
--
ALTER TABLE `species`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `stamp_type`
--
ALTER TABLE `stamp_type`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `station`
--
ALTER TABLE `station`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `way`
--
ALTER TABLE `way`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `widget`
--
ALTER TABLE `widget`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `wood`
--
ALTER TABLE `wood`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
--
-- AUTO_INCREMENT for table `wood_group`
--
ALTER TABLE `wood_group`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `wood_provider`
--
ALTER TABLE `wood_provider`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `worker`
--
ALTER TABLE `worker`
  MODIFY `id` smallint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;