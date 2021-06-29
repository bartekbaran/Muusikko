-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 
-- Czas generowania: 29 Cze 2021, 15:53
-- Wersja serwera: 8.0.21
-- Wersja PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `s120`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `userInformation`
--

CREATE TABLE `userInformation` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_ids` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `userInformation`
--

INSERT INTO `userInformation` (`id`, `email`, `birth`, `city`, `status`, `description`, `gender`, `image`, `added_ids`) VALUES
(13, 'bartekbaran00@gmail.com', '30 December 2000', 'Rzeszów', 'Band', 'Hi, I am Bartek and I am an admin. BBKB', 'Man', 'kapibarka.jpeg', '36,42'),
(14, 'test1@gmail.com', '5 May 1994', 'Bydgoszcz', 'Members', 'Yo, I am unknown trap beast!', 'Woman', NULL, NULL),
(15, 'test2@gmail.com', '5 July 2003', 'Kraków', 'Members', 'My name is Piter Parker and I am local spider-man', 'Man', 'B).png', NULL),
(16, 'test3@gmail.com', '22 April 1991', 'Rzeszów', 'Band', 'Hi I am looking for a new challange, I can play multiple instruments. 2115', 'Man', NULL, '36'),
(17, 'test4@gmail.com', '1 January 1990', 'Rzeszów', 'Members', 'Hello, Me nombre es Peter. Puedo tocar la guitarra', 'Woman', 'egnok.png', '32,35'),
(18, 'test6@test.com', '6 July 1993', 'Kraków', 'Band', 'I am looking for a band. I am 28 y.o. and I play musical instruments since I was 6.', 'Man', NULL, '42'),
(19, 'test7@test7.com', '15 October 1991', 'Oświęcim', 'Members', 'Hi, My name is Natasha and I am looking for a guitarist.', 'Woman', 'avk.jpg', NULL),
(20, 'test9@test.com', '13 November 2017', 'Sosnowiec', 'Band', 'I am 4 y.o. and I want to learn how to play on clarnet', 'Dunno', 'avek.png', NULL),
(21, 'test10@test.com', '31 February 2021', 'Białka Tatrzańska', 'Members', 'Hi, I am me', 'Woman', NULL, NULL),
(22, 'test11@test.com', '4 March 1993', 'Oświęcim', 'Members', 'ndkfjndkf', 'Woman', 'kkkk.png', '32,37');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `userMessages`
--

CREATE TABLE `userMessages` (
  `id` int UNSIGNED NOT NULL,
  `from_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `message` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `creator` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `userMessages`
--

INSERT INTO `userMessages` (`id`, `from_id`, `receiver_id`, `message`, `created`, `creator`) VALUES
(25, 36, 35, 'elo', '2021-06-29 14:00:02', 'Test4'),
(26, 36, 32, 'dzienki dziala?', '2021-06-29 14:01:44', 'Test4'),
(27, 32, 36, 'dzienki dziala.', '2021-06-29 15:02:42', 'Ksiurf'),
(28, 42, 32, 'Hi', '2021-06-29 15:50:34', 'test11'),
(29, 32, 42, 'Hello, there : ) ', '2021-06-29 15:50:52', 'Ksiurf');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `email`, `nickname`, `password`, `created`) VALUES
(32, 'bartekbaran00@gmail.com', 'Ksiurf', '$2y$10$.eD5cCKU84fIHiZ1z7Y6led0evC24lAjnUpnhUzwP.JhElU3omXbS', '2021-06-29 12:33:16'),
(33, 'test1@gmail.com', 'Test1', '$2y$10$Ez7Guz3tqA.DwwL3HCQlTuTduB.SOCGe0H357/g/xXoIVix2rfNNe', '2021-06-29 13:11:05'),
(34, 'test2@gmail.com', 'Test2', '$2y$10$Y8AY53MUfa2hjFSYiLdC2.VUkbimh1fpmU6J9Q5zCvtDY6hH.No7i', '2021-06-29 13:11:18'),
(35, 'test3@gmail.com', 'Test3', '$2y$10$u50zm9NyM5yhn3ChzE1xaezHQ/XV3vfcd1Iy9YIVlcFwJTv7rSOXi', '2021-06-29 13:13:14'),
(36, 'test4@gmail.com', 'Test4', '$2y$10$W68a7kgolA94bwRbO0Dd5ewkD8hdnkUAifuIIuW64ryULYdUJJysy', '2021-06-29 13:13:28'),
(37, 'test6@test.com', 'Gafcio', '$2y$10$1.Z5zuJ/mYQM2UjkF9aJLu7QddEv4ZE1iUGZ9j0uCBuno90ageuTm', '2021-06-29 14:38:57'),
(38, 'test7@test7.com', 'test7`', '$2y$10$hyE7LECnDpckTZ1ucE3TKeklOnm8b0ai7GgCioJPh1SRhXrUfs5se', '2021-06-29 14:41:11'),
(39, 'tes8@test.com', 'test8', '$2y$10$adw7RTS/mfxxoXD.Aoe31e3yDD19DlmiTsdqzYuJpSIPkGLXzGO26', '2021-06-29 14:43:27'),
(40, 'test9@test.com', 'test9', '$2y$10$IE8Gph7YQt7sNTPY2y82L.eqEnstsUVcmyvcAB0nfh5Qz7IHIPmw2', '2021-06-29 14:45:58'),
(41, 'test10@test.com', 'test10', '$2y$10$y/aqlMMuRu/JdXsvLrFKzufjr46NlQb9AdjpcviRlj8Tdz/V5MeSu', '2021-06-29 14:48:41'),
(42, 'test11@test.com', 'test11', '$2y$10$FC3Xx3Jv/cgTcI8uOyy.DOGgXCkHysHfVfk0czcyx7FninrNkYXUy', '2021-06-29 15:46:18');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `userInformation`
--
ALTER TABLE `userInformation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeksy dla tabeli `userMessages`
--
ALTER TABLE `userMessages`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `userInformation`
--
ALTER TABLE `userInformation`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT dla tabeli `userMessages`
--
ALTER TABLE `userMessages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
