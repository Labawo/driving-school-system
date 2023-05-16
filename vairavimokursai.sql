-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2022 at 02:27 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vairavimokursai`
--

-- --------------------------------------------------------

--
-- Table structure for table `administratoriai`
--

CREATE TABLE `administratoriai` (
  `vardas` varchar(25) COLLATE utf8_lithuanian_ci NOT NULL,
  `pavarde` varchar(25) COLLATE utf8_lithuanian_ci NOT NULL,
  `tabelio_nr` int(11) NOT NULL,
  `id` varchar(32) COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `administratoriai`
--

INSERT INTO `administratoriai` (`vardas`, `pavarde`, `tabelio_nr`, `id`) VALUES
('Andrius', 'Taumanas', 3, '22c9fb86ae475ed13742ca8277c40b32');

-- --------------------------------------------------------

--
-- Table structure for table `destytojai`
--

CREATE TABLE `destytojai` (
  `vardas` varchar(25) COLLATE utf8_lithuanian_ci NOT NULL,
  `pavarde` varchar(25) COLLATE utf8_lithuanian_ci NOT NULL,
  `telefonas` varchar(20) COLLATE utf8_lithuanian_ci NOT NULL,
  `asmens_kodas` varchar(11) COLLATE utf8_lithuanian_ci NOT NULL,
  `kursu_sk` int(11) NOT NULL,
  `id` varchar(32) COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `destytojai`
--

INSERT INTO `destytojai` (`vardas`, `pavarde`, `telefonas`, `asmens_kodas`, `kursu_sk`, `id`) VALUES
('Valdas', 'Adamkus', '+37062222222', '26161e4924e', 0, '5afda3e3942aa3481965daa45e95c1f2'),
('Adolfas', 'Hitenas', '+37062222222', '29a85de8e1d', 7, 'cb426674f941f8b8d3f9343b749f420e'),
('Ona', 'Zemaite', '+37063333333', '7b8a8c259ff', 3, '78bc9393066bba94d0ca3ef78971c91a'),
('Juozapas', 'Stalkevicius', '+37061111112', 'b1cbe6c6d1d', 2, '93f2b69cea41bb7b701ff351fde12f5d');

-- --------------------------------------------------------

--
-- Table structure for table `kursai`
--

CREATE TABLE `kursai` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(40) COLLATE utf8_lithuanian_ci NOT NULL,
  `data` date NOT NULL,
  `data_iki` date DEFAULT NULL,
  `vietu_sk` int(11) NOT NULL,
  `aprasas` text COLLATE utf8_lithuanian_ci NOT NULL,
  `kaina` decimal(10,0) NOT NULL,
  `tipas` tinyint(3) NOT NULL,
  `destytojas` varchar(11) COLLATE utf8_lithuanian_ci NOT NULL,
  `uzdarytas` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `kursai`
--

INSERT INTO `kursai` (`id`, `pavadinimas`, `data`, `data_iki`, `vietu_sk`, `aprasas`, `kaina`, `tipas`, `destytojas`, `uzdarytas`) VALUES
(8, 'A kategorija', '2022-12-22', '2022-12-30', 49, 'A kategorijos teorija', '100', 1, '29a85de8e1d', 0),
(13, 'C kategorija', '2022-12-02', '2023-01-23', 19, 'C kategorija teorija', '200', 1, '7b8a8c259ff', 1),
(15, 'C kategorija', '2022-12-30', '2023-01-31', 24, 'C kategorijos praktika', '600', 2, 'b1cbe6c6d1d', 1),
(18, 'B kategorija', '2022-12-23', '2023-01-28', 49, 'B kategorijos teorija ir praktika', '350', 3, '7b8a8c259ff', 0),
(19, 'A kategorija', '2022-12-17', '2022-12-31', 15, 'A kategorijos teorija', '150', 1, '7b8a8c259ff', 0),
(20, 'C kategorija', '2022-12-16', '2022-12-30', 54, 'C kategorijos teorija ir praktika', '900', 3, 'b1cbe6c6d1d', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kursantai`
--

CREATE TABLE `kursantai` (
  `vardas` varchar(25) COLLATE utf8_lithuanian_ci NOT NULL,
  `pavarde` varchar(25) COLLATE utf8_lithuanian_ci NOT NULL,
  `amzius` int(4) NOT NULL,
  `telefono_nr` varchar(20) COLLATE utf8_lithuanian_ci NOT NULL,
  `asmens_kodas` varchar(11) COLLATE utf8_lithuanian_ci NOT NULL,
  `id` varchar(32) COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `kursantai`
--

INSERT INTO `kursantai` (`vardas`, `pavarde`, `amzius`, `telefono_nr`, `asmens_kodas`, `id`) VALUES
('Liudas', 'Vasaris', 18, '+37064444444', '41ba9f29ac9', '6556c97ce7d2a709215d28c668fffb32'),
('Tukas', 'Tukauskas', 19, '+37067777777', '458d9864ab8', 'dfeb56f1f5c05211d8662425afa7b131'),
('Egle', 'Egluza', 25, '+37066666666', '8e4f0f42f35', '754756882d2428d321f1b1a7fc5105b3'),
('Antanas', 'Skema', 16, '+37065555555', 'fac200306eb', '53293f47f3d88439cff4afa04f447f20');

-- --------------------------------------------------------

--
-- Table structure for table `naudotojai`
--

CREATE TABLE `naudotojai` (
  `id` varchar(32) COLLATE utf8_lithuanian_ci NOT NULL,
  `slapyvardis` varchar(25) COLLATE utf8_lithuanian_ci NOT NULL,
  `slaptazodis` varchar(32) COLLATE utf8_lithuanian_ci NOT NULL,
  `el_pastas` varchar(50) COLLATE utf8_lithuanian_ci NOT NULL,
  `lygmuo` tinyint(3) UNSIGNED NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `naudotojai`
--

INSERT INTO `naudotojai` (`id`, `slapyvardis`, `slaptazodis`, `el_pastas`, `lygmuo`, `timestamp`) VALUES
('22c9fb86ae475ed13742ca8277c40b32', 'labas', '8854088f0408edab6b0404993432edb0', 'labas@ktu.lt', 9, '2022-12-09 00:46:18'),
('53293f47f3d88439cff4afa04f447f20', 'antanas', '8b06a1e5485d67afc52a5c233acb21df', 'antanas@ktu.lt', 4, '2022-12-07 18:54:07'),
('5afda3e3942aa3481965daa45e95c1f2', 'valdas', '64c3bc2b6c562c69f894067163845d6b', 'valdas@ktu.lt', 5, '2022-12-09 00:36:48'),
('6556c97ce7d2a709215d28c668fffb32', 'liudas', '920edaabb269e66b1447baec39948923', 'liudas@ktu.lt', 4, '2022-12-07 18:53:13'),
('754756882d2428d321f1b1a7fc5105b3', 'egle', '333db4fb9cec9af765906d05dc6452c0', 'egle@ktu.lt', 4, '2022-12-09 00:52:21'),
('78bc9393066bba94d0ca3ef78971c91a', 'ona', 'c29ef553171829e8c0925b3bb7c97306', 'ona@ktu.lt', 5, '2022-12-08 22:16:03'),
('93f2b69cea41bb7b701ff351fde12f5d', 'joseph', 'd037766aa181d8840ad04b9fc6e195fd', 'joseph@ktu.lt', 5, '2022-12-08 20:48:38'),
('cb426674f941f8b8d3f9343b749f420e', 'adolf', 'd909b94deb27b460692084d9f2b1dbc9', 'adolf@ktu.lt', 5, '2022-12-08 21:26:06'),
('dfeb56f1f5c05211d8662425afa7b131', 'tuk', '1fa7efa5858846cc3c534bffd202b557', 'tuk@ktu.lt', 4, '2022-12-07 18:57:19');

-- --------------------------------------------------------

--
-- Table structure for table `rysiai`
--

CREATE TABLE `rysiai` (
  `id` int(11) NOT NULL,
  `kursanto_ak` varchar(11) COLLATE utf8_lithuanian_ci NOT NULL,
  `kurso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `rysiai`
--

INSERT INTO `rysiai` (`id`, `kursanto_ak`, `kurso_id`) VALUES
(53, '8e4f0f42f35', 18),
(54, '8e4f0f42f35', 13);

-- --------------------------------------------------------

--
-- Table structure for table `tipai`
--

CREATE TABLE `tipai` (
  `id` tinyint(4) NOT NULL,
  `tipo_pavadinimas` varchar(50) COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `tipai`
--

INSERT INTO `tipai` (`id`, `tipo_pavadinimas`) VALUES
(1, 'Teorija'),
(2, 'Praktika'),
(3, 'Teorija + Praktika');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administratoriai`
--
ALTER TABLE `administratoriai`
  ADD PRIMARY KEY (`tabelio_nr`);

--
-- Indexes for table `destytojai`
--
ALTER TABLE `destytojai`
  ADD PRIMARY KEY (`asmens_kodas`);

--
-- Indexes for table `kursai`
--
ALTER TABLE `kursai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kursantai`
--
ALTER TABLE `kursantai`
  ADD PRIMARY KEY (`asmens_kodas`);

--
-- Indexes for table `naudotojai`
--
ALTER TABLE `naudotojai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rysiai`
--
ALTER TABLE `rysiai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipai`
--
ALTER TABLE `tipai`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administratoriai`
--
ALTER TABLE `administratoriai`
  MODIFY `tabelio_nr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kursai`
--
ALTER TABLE `kursai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `rysiai`
--
ALTER TABLE `rysiai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
