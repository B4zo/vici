-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 09:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vici`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`) VALUES
(1, 'Brez'),
(2, 'Blondinka'),
(3, 'Policijski'),
(4, 'Janezek');

-- --------------------------------------------------------

--
-- Table structure for table `forgotpassword`
--

CREATE TABLE `forgotpassword` (
  `userUUID` varchar(36) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `contentUUID` varchar(36) NOT NULL,
  `userUUID` varchar(36) NOT NULL,
  `title` varchar(60) NOT NULL,
  `body` text NOT NULL,
  `category` int(11) NOT NULL,
  `public` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`contentUUID`, `userUUID`, `title`, `body`, `category`, `public`, `created`, `modified`) VALUES
('09944868-1c62-11f0-a4da-4cedfb96eae1', '38c8ad28-48cf-46b9-a623-9214192b49be', 'First post!', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nisi mauris, sollicitudin id faucibus vulputate, convallis in augue. Mauris condimentum risus vitae efficitur bibendum. Morbi sapien elit, condimentum vel euismod vel, cursus eu diam. Integer non volutpat purus. Nam sollicitudin ut neque non posuere. Phasellus bibendum massa ac neque laoreet scelerisque. Quisque a purus nisl. Mauris vitae ligula in risus semper accumsan. Quisque dapibus turpis a tincidunt elementum. Cras felis ex, tempus et vehicula non, sollicitudin non diam. Vivamus ut iaculis dolor. Vestibulum et vestibulum tortor.\n\nDonec eleifend enim a neque pretium, mattis facilisis neque vestibulum. Morbi fermentum vel enim id rutrum. Morbi egestas tincidunt pharetra. Nullam non diam eget mauris fermentum accumsan venenatis efficitur metus. Donec vitae ipsum sed mi accumsan venenatis quis ac mauris. Sed dictum semper ex et consectetur. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.\n\nVivamus mauris nisl, porta sed nisl nec, pellentesque gravida libero. Cras eget porta est. Vivamus id facilisis sem, quis tempus arcu. Nulla facilisi. Proin mollis urna ac ligula dapibus sagittis. Maecenas venenatis arcu ipsum, in faucibus orci convallis at. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam quis condimentum odio, a elementum odio. Donec in ante risus. Nullam dolor augue, consectetur vel bibendum sed, auctor sed odio. Sed at diam eu magna efficitur faucibus. Praesent euismod nisi vitae ex interdum, elementum tristique felis interdum. Curabitur at ex in urna blandit rutrum. Nullam placerat massa neque, et aliquet ipsum rhoncus sed. Aliquam convallis diam turpis, a rhoncus enim euismod ac.\n\nSed sem odio, pulvinar sed blandit id, ullamcorper ac arcu. Phasellus elementum, justo non tristique iaculis, mauris augue vehicula ante, ut egestas lectus mi sit amet odio. Maecenas mi metus, imperdiet eget euismod nec, condimentum in erat. Etiam posuere augue in nisi consequat, pulvinar placerat quam posuere. Aenean turpis velit, maximus tincidunt tempus sit amet, dictum at nisl. Nunc congue maximus purus non luctus. Quisque et ligula id ante sodales vulputate. Nulla a sollicitudin ligula. Nulla luctus dictum leo, non feugiat leo tempus ut. Aliquam erat volutpat. Donec pulvinar rhoncus ante, sed porttitor elit vehicula ut. Ut sit amet interdum turpis, sit amet vestibulum sem. Nam id arcu finibus, tristique lorem vel, placerat nisl. Sed vitae ipsum vitae nisl cursus dictum. Nunc varius eros in augue hendrerit, id varius sem blandit. Sed sit amet consectetur eros.\n\nMorbi feugiat elit neque, sed tempus dui lobortis quis. Maecenas cursus, mi quis maximus lobortis, mauris odio hendrerit sem, ac dictum mauris lectus semper urna. Aliquam lectus purus, venenatis ut malesuada et, interdum sit amet augue. Sed laoreet tincidunt interdum. Sed vitae ultricies velit, at consequat purus. Sed efficitur sollicitudin lobortis. Maecenas vel dapibus nisl. ', 2, 1, '2025-04-18 16:31:53', '2025-04-18 16:31:53'),
('12b1b3a7-1c64-11f0-a4da-4cedfb96eae1', '38c8ad28-48cf-46b9-a623-9214192b49be', 'Second post!', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non efficitur nunc. Etiam vitae sollicitudin leo. Sed sit amet mollis mauris. Sed suscipit mauris a nibh commodo, ac suscipit dui condimentum. Nulla faucibus, libero eget viverra accumsan, tortor neque consectetur enim, at tempus magna eros at nisi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis vel quam aliquet, sagittis tortor sit amet, sollicitudin enim. Suspendisse euismod enim eget nunc congue varius. Mauris viverra commodo dolor, et bibendum est placerat id. Integer ac augue non libero pellentesque tincidunt. Nunc a maximus ante, sit amet ultricies odio. In pharetra aliquet tortor vitae euismod. Ut at ante mauris. Integer laoreet, enim ut molestie fringilla, dui eros faucibus ex, nec ullamcorper odio arcu sollicitudin libero. Ut vel finibus velit. Duis ultricies arcu sed rutrum sagittis.', 3, 1, '2025-04-18 16:47:10', '2025-04-18 16:47:10'),
('2ff01d17-029b-4551-9daf-f815566e1349', '5889a4a5-2835-457d-92db-938cc3938936', 'Matej Krumpeč', 'awdawdawdawdawdawdwadawdawd', 3, 1, '2025-05-12 19:12:25', '2025-05-13 21:08:54'),
('5921957d-ccd5-4160-a0c0-fa8c80cce58c', '5889a4a5-2835-457d-92db-938cc3938936', 'Janez je skočo!!!', 'Janez se je bujo ker je do 4 vgojno delo z nrsa in se učil slovenščino', 4, 1, '2025-05-13 21:09:02', '2025-05-13 21:09:58'),
('96d4fbe6-9720-438b-a8c4-0cd0347297e5', '5889a4a5-2835-457d-92db-938cc3938936', 'Hello, World!', 'Lorem efefegwgrg rfg thhthtghytrg r ghehhyh  he h er her here ftghtththth hth th ththththhdhdrferhafherthbnrzjnrztf geg edthb rfzjnrfhjrf zjnhfrzgtnhj rftzjn rzghjnzghjghderfghbrdtgfhjn frzghjndtzfghrdtfeswr4dg detfghbnrztfghbrfewsrujkhgzftdresw  rtgzhgftdressrtzhujhgzftrdewsrtgzh rewerftgzhujmhjgfewerftgzhujhgztrewertz hrewqerftgzhgjmgf erthjgfte ', 2, 0, '2025-05-12 17:05:42', '2025-05-13 21:12:45'),
('a919e49e-6d10-4ee1-9f9d-1e9234957844', '38c8ad28-48cf-46b9-a623-9214192b49be', 'Third post!', 'Lorem', 1, 1, '2025-04-18 23:30:08', '2025-04-18 23:41:43'),
('c0e3b87f-9c63-4431-8663-1201725be4d0', '5889a4a5-2835-457d-92db-938cc3938936', 'Nov osnutek', '', 2, 1, '2025-05-12 19:43:11', '2025-05-13 21:05:30');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `userUUID` varchar(36) NOT NULL,
  `token` varchar(64) NOT NULL,
  `created` datetime NOT NULL,
  `lastLogin` datetime NOT NULL DEFAULT current_timestamp(),
  `attempts` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`userUUID`, `token`, `created`, `lastLogin`, `attempts`) VALUES
('38c8ad28-48cf-46b9-a623-9214192b49be', 'c902a8448a4cef38948fd59a48b5ae367143d660af5727005bd910b432723dbe', '0000-00-00 00:00:00', '2025-05-12 18:08:04', 0),
('5889a4a5-2835-457d-92db-938cc3938936', '436fcdfc19a80f7e9afa8a38b605e7a914dd815043d5d03698193c6247a13702', '2025-05-12 18:01:31', '2025-05-13 20:16:15', 0),
('7821ba34-5319-4182-8241-27c155019232', '71ff587fac7b352e48ea68f01b63e90331ab676d586a653b0007705ccccfe6a4', '0000-00-00 00:00:00', '2025-05-12 19:01:24', 0),
('adb4cd02-210e-4e73-afd8-d038b0eeb14e', 'c7c89edf76d722f3e789191ee2965cfc71b95809b1c5c0e4674bf53832e89cbb', '2025-05-13 15:09:03', '2025-05-13 16:38:03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userUUID` varchar(36) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(60) NOT NULL,
  `created` datetime NOT NULL,
  `verified` tinyint(1) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `locked` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userUUID`, `username`, `email`, `password`, `created`, `verified`, `admin`, `locked`) VALUES
('01d3492b-5e70-4ed4-b4bd-0f1f6eb02c7e', 'Aljaz5', 'aljaz.skafar14534@gmail.com', '$2y$10$6CrcAsLCGroYjU7Cwom9Uu4PIvmI6JgTl2cuhaASrWX9gwhbL3JRS', '2025-05-12 22:11:02', 0, 0, 0),
('093131ed-41a4-4983-b458-164294bce58a', 'Aljaz4', 'aljaz341524234566@gmail.com', '$2y$10$BbhCZJbKALU.8BcV3zl3jO8e2Wa0mZp44F/f/dWhlHVQVPN2pJAlC', '2025-05-12 20:43:08', 0, 0, 0),
('38c8ad28-48cf-46b9-a623-9214192b49be', 'Aljaz', 'aljaz.skafar12@gmail.com', '$2y$10$DmYoMFcth6t8/0jPIxBtq.JRcuYNwHnMaWF3X6gMDW2O1YtvX4uTG', '2025-04-18 16:29:55', 1, 1, 0),
('5889a4a5-2835-457d-92db-938cc3938936', 'Aljaz2', 'aljaz-skafar@outlook.com', '$2y$10$6sAkhIkDDpdUzKrdWcA.buLGtO0bDnAkKQKXW2BR6QLOf9nO5oWK2', '2025-04-19 00:24:21', 1, 1, 0),
('7821ba34-5319-4182-8241-27c155019232', 'Aljaz1', 'aljaz.skafar10@gmail.com', '$2y$10$5IQTJV/VBKgWcQR7fAUaBe8iPiEPUJ/i10SiZPeKvCn8Tj95zUwcK', '2025-04-19 00:23:17', 1, 0, 0),
('9711e545-e60e-470d-ab70-3d771458d4b2', 'Aljaz3', 'aljaz.skafar100@gmail.com', '$2y$10$WHb1BHn3IQydOg7JDepdcOefux/knYTOS3NzLO3YIskhqTeD1LyVa', '2025-05-12 20:12:43', 0, 0, 0),
('adb4cd02-210e-4e73-afd8-d038b0eeb14e', 'Aljaz6', 'aljaz.skafar1@gmail.com', '$2y$10$49r/Pi9W898BwsRlpl4KwusuzxWQCdFOklJlr9chshgVLUldOKvHC', '2025-05-13 14:29:57', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `verification`
--

CREATE TABLE `verification` (
  `userUUID` varchar(36) NOT NULL,
  `token` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `verification`
--

INSERT INTO `verification` (`userUUID`, `token`) VALUES
('01d3492b-5e70-4ed4-b4bd-0f1f6eb02c7e', '8b92128daf41b544b1dba6bdb8ac6500');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forgotpassword`
--
ALTER TABLE `forgotpassword`
  ADD PRIMARY KEY (`userUUID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`contentUUID`),
  ADD KEY `posts_ibfk_1` (`userUUID`),
  ADD KEY `posts_ibfk_2` (`category`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`userUUID`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userUUID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `verification`
--
ALTER TABLE `verification`
  ADD PRIMARY KEY (`userUUID`),
  ADD UNIQUE KEY `token` (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forgotpassword`
--
ALTER TABLE `forgotpassword`
  ADD CONSTRAINT `forgotpassword_ibfk_1` FOREIGN KEY (`userUUID`) REFERENCES `users` (`userUUID`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`userUUID`) REFERENCES `users` (`userUUID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`category`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`userUUID`) REFERENCES `users` (`userUUID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `verification`
--
ALTER TABLE `verification`
  ADD CONSTRAINT `verification_ibfk_1` FOREIGN KEY (`userUUID`) REFERENCES `users` (`userUUID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
