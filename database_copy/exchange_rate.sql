-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 03 May 2023, 14:05:53
-- Sunucu sürümü: 10.4.27-MariaDB
-- PHP Sürümü: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `exchange_rate`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `transactions`
--

CREATE TABLE `transactions` (
  `Id` int(11) NOT NULL,
  `transforming` varchar(3) DEFAULT NULL,
  `converted` varchar(3) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `calculation` double DEFAULT NULL,
  `user` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `transactions`
--

INSERT INTO `transactions` (`Id`, `transforming`, `converted`, `amount`, `Date`, `calculation`, `user`) VALUES
(13, 'USD', 'RUB', 45, '2023-05-01 00:00:00', 3616.5, 'test@gmail.com'),
(14, 'AUD', 'GBP', 34, '2023-05-02 20:39:20', 18.234, 'test@gmail.com'),
(15, 'EUR', 'USD', 67, '2023-05-02 20:55:09', 73.509, 'test@gmail.com'),
(16, 'PKR', 'AZN', 456, '2023-05-02 20:55:18', 2.7318, 'test@gmail.com'),
(17, 'CHF', 'JPY', 56765, '2023-05-02 20:55:27', 86932, 'test@gmail.com'),
(18, 'GBP', 'AUD', 34, '2023-05-04 20:57:47', 63.397, 'test@gmail.com'),
(19, 'QAR', 'AUD', 56, '2023-05-05 20:58:01', 22.79, 'test@gmail.com'),
(20, 'USD', 'RUB', 9999, '2023-05-02 21:01:43', 803594, 'test@gmail.com'),
(21, 'USD', 'RUB', 999999, '2023-05-01 21:02:06', 803674, 'test@gmail.com'),
(22, 'USD', 'RUB', 9999999, '2023-05-02 21:02:22', 803674, 'test@gmail.com'),
(23, 'QAR', 'AUD', 999999, '1899-12-01 00:00:00', 406965, 'test@gmail.com'),
(24, 'QAR', 'AUD', 2147483647, '2023-05-01 21:03:20', 4.0696, 'test@gmail.com'),
(25, 'IRR', 'RUB', 550, '2023-05-02 21:54:27', 104.65, 'test@gmail.com'),
(26, 'DKK', 'EUR', 60, '2023-05-03 07:01:52', 8.0374, 'test@gmail.com'),
(27, 'SEK', 'EUR', 450, '2023-05-03 12:56:20', 39.65, 'test@gmail.com');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `userName` varchar(50) DEFAULT NULL,
  `userPassword` text DEFAULT NULL,
  `userEmail` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`Id`, `userName`, `userPassword`, `userEmail`) VALUES
(1, 'test', '202cb962ac59075b964b07152d234b70', 'test@gmail.com');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`Id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `transactions`
--
ALTER TABLE `transactions`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
