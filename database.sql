-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Mai 2018 um 19:55
-- Server-Version: 10.1.30-MariaDB
-- PHP-Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `picdb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gallery`
--

CREATE TABLE `gallery` (
  `Id` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `Description` text NOT NULL,
  `User_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `picture`
--

CREATE TABLE `picture` (
  `Id` int(11) NOT NULL,
  `Description` varchar(1024) DEFAULT NULL,
  `Gallery_id` int(11) NOT NULL,
  `Creation_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `picture_tag`
--

CREATE TABLE `picture_tag` (
  `Picture_id` int(11) NOT NULL,
  `Tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tag`
--

CREATE TABLE `tag` (
  `Id` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `Id` int(11) NOT NULL,
  `Email` varchar(64) NOT NULL,
  `Displayname` varchar(32) NOT NULL,
  `Password` varchar(64) NOT NULL,
  `Register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `salt` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_gallery_user` (`User_Id`);

--
-- Indizes für die Tabelle `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_picture_gallery` (`Gallery_id`);

--
-- Indizes für die Tabelle `picture_tag`
--
ALTER TABLE `picture_tag`
  ADD UNIQUE KEY `picture_tag_index` (`Picture_id`,`Tag_id`),
  ADD KEY `fk_picture_tag_tag` (`Tag_id`);

--
-- Indizes für die Tabelle `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`Id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `gallery`
--
ALTER TABLE `gallery`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `picture`
--
ALTER TABLE `picture`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `tag`
--
ALTER TABLE `tag`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `fk_gallery_user` FOREIGN KEY (`User_Id`) REFERENCES `user` (`Id`);

--
-- Constraints der Tabelle `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `fk_picture_gallery` FOREIGN KEY (`Gallery_id`) REFERENCES `gallery` (`Id`);

--
-- Constraints der Tabelle `picture_tag`
--
ALTER TABLE `picture_tag`
  ADD CONSTRAINT `fk_picture_tag_picture` FOREIGN KEY (`Picture_id`) REFERENCES `picture` (`Id`),
  ADD CONSTRAINT `fk_picture_tag_tag` FOREIGN KEY (`Tag_id`) REFERENCES `tag` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
