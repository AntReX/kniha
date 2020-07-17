-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Počítač: wm49.wedos.net:3306
-- Vygenerováno: Pát 17. čec 2020, 18:55
-- Verze serveru: 5.6.14
-- Verze PHP: 5.4.23

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `d31990_9cca81e`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `knihy`
--

CREATE TABLE IF NOT EXISTS `knihy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rok_vydani` smallint(4) NOT NULL DEFAULT '1900',
  `autor` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `nazev` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `nazev` (`nazev`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=6 ;

--
-- Vypisuji data pro tabulku `knihy`
--

INSERT INTO `knihy` (`id`, `rok_vydani`, `autor`, `nazev`, `datum`) VALUES
(1, 2013, 'Jonathan Chaffer', 'Mistrovství v jQuery', '2020-07-17 18:49:47'),
(2, 2009, 'Nicholas Z. Zakas', 'JavaScript pro webové vývojáře', '2020-07-17 18:51:00'),
(3, 2012, 'Ryan Stephens', 'Naučte se SQL za 28 dní', '2020-07-17 18:51:54'),
(4, 2016, 'Matěj Barták', 'Autoškola 2016', '2020-07-17 18:53:06'),
(5, 2011, 'Martin Domes', 'SEO Jednoduše', '2020-07-17 18:53:50');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
