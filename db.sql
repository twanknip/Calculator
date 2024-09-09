-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 09 sep 2024 om 13:45
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------



-- --------------------------------------------------------

-- Tabelstructuur voor tabel `brands`
CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Gegevens voor tabel `brands`
INSERT INTO `brands` (`id`, `name`) VALUES
(1, 'Philips'),
(2, 'Jura'),
(3, 'DeLonghi'),
(4, 'Siemens'),
(5, 'Sage'),
(6, 'Solis'),
(7, 'Gaggia'),
(8, 'Nivona'),
(9, 'Melitta'),
(10, 'Saeco'),
(11, 'Atag'),
(12, 'Miele'),
(13, 'Bauknecht');

-- --------------------------------------------------------

-- Tabelstructuur voor tabel `models`
CREATE TABLE `models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_brand_id` (`brand_id`),
  CONSTRAINT `fk_brand_id` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Gegevens voor tabel `models`
INSERT INTO `models` (`id`, `brand_id`, `name`) VALUES
(1, 1, 'EP 2300 series'),
(2, 1, 'EP 3300 series'),
(3, 1, 'EP 4300 series'),
(4, 2, 'A series'),
(5, 2, 'D series'),
(6, 2, 'Ena series'),
(7, 3, 'Dinamica series'),
(8, 3, 'Primadonna series'),
(9, 4, 'EQ6 S100'),
(10, 4, 'EQ6 PLUS S100'),
(11, 5, 'Barista express series'),
(12, 5, 'Barista Pro series'),
(13, 6, 'Grind & Infuse series'),
(14, 7, 'Titanium'),
(15, 8, 'CafeRomatica series'),
(16, 9, 'Barista series'),
(17, 10, 'Xelsis series'),
(18, 11, 'Inbouw machines'),
(19, 12, 'Inbouw machines'),
(20, 13, 'Inbouw machines');

-- --------------------------------------------------------

-- Tabelstructuur voor tabel `machine_data`
CREATE TABLE `machine_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `machine_status` varchar(255) NOT NULL,
  `electronics` varchar(255) DEFAULT NULL,
  `accessories` varchar(255) DEFAULT NULL,
  `cleaning` varchar(255) DEFAULT NULL,
  `packaging` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

-- Tabelstructuur voor tabel `users`
CREATE TABLE `users` (
  `idUsers` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  PRIMARY KEY (`idUsers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Gegevens voor tabel `users`
INSERT INTO `users` (`idUsers`, `email`, `password`, `role`) VALUES
(1, 'admin@gmail.com', 'admin', 'admin'),
(2, 'admin2@gmail.com', 'admin', 'admin'),
(3, 'admin@gmail.com', '$2y$10$Q4pRn/QgbYaCaI9vwVNte.5.JT9SxMmOPaa48A0YNuSbltqPvelXe', 'admin');

-- --------------------------------------------------------

-- Tabelstructuur voor tabel `machine_prices`
CREATE TABLE `machine_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `base_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_brand_id` (`brand_id`),
  KEY `fk_model_id` (`model_id`),
  CONSTRAINT `fk_brand_id` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_model_id` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Gegevens voor tabel `machine_prices`
INSERT INTO `machine_prices` (`brand_id`, `model_id`, `base_price`) VALUES
(1, 1, 70.00),
(1, 2, 80.00),
(1, 3, 125.00),
(1, 4, 125.00),
(1, 5, 80.00),
(1, 6, 150.00),
(1, 7, 125.00),
(2, 4, 80.00),
(2, 5, 150.00),
(2, 6, 100.00),
(2, 7, 125.00),
(2, 8, 150.00),
(2, 9, 130.00),
(2, 10, 425.00),
(2, 11, 425.00),
(2, 12, 700.00),
(2, 13, 700.00),
(2, 14, 700.00),
(2, 15, 700.00),
(2, 16, 700.00),
(2, 17, 150.00),
(2, 18, 200.00),
(2, 19, 200.00),
(2, 20, 200.00),
(3, 7, 75.00),
(3, 8, 100.00),
(3, 9, 175.00),
(3, 10, 125.00),
(3, 11, 100.00),
(3, 12, 300.00),
(3, 13, 100.00),
(4, 9, 75.00),
(4, 10, 75.00),
(4, 11, 75.00),
(4, 12, 75.00),
(4, 13, 110.00),
(4, 14, 110.00),
(4, 15, 110.00),
(4, 16, 125.00),
(4, 17, 150.00),
(4, 18, 200.00),
(4, 19, 200.00),
(4, 20, 300.00),
(5, 1, 100.00),
(5, 2, 120.00),
(5, 3, 150.00),
(5, 4, 200.00),
(6, 13, 80.00),
(6, 14, 100.00),
(7, 1, 60.00),
(7, 2, 80.00),
(7, 3, 50.00),
(8, 1, 130.00),
(9, 1, 100.00),
(9, 2, 90.00),
(9, 3, 90.00),
(10, 1, 150.00),
(10, 2, 120.00),
(10, 3, 90.00),
(11, 1, 130.00),
(12, 1, 130.00),
(13, 1, 130.00);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
