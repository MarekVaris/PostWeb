-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 10, 2024 at 10:18 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `postweb`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `liked_posts`
--

CREATE TABLE `liked_posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `likedPost_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `liked_posts`
--

INSERT INTO `liked_posts` (`id`, `user_id`, `likedPost_id`, `created_at`) VALUES
(3, 1, 2, '2024-05-16 19:27:54'),
(7, 1, 9, '2024-05-17 15:59:12'),
(20, 2, 13, '2024-05-25 18:52:40'),
(21, 2, 12, '2024-05-25 18:52:41'),
(26, 2, 2, '2024-05-25 18:52:49'),
(35, 3, 14, '2024-05-31 17:40:34');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `encrypted_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `encrypted_text`, `created_at`) VALUES
(1, 11, 'UG', '2024-06-10 20:13:49'),
(2, 6, 'MILX', '2024-06-10 20:14:03');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `likes` int(11) DEFAULT 0,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `likes`, `upload_date`) VALUES
(2, 2, 'zxc', 2, '2024-05-16 19:27:42'),
(9, 1, '\r\n\r\n+', 1, '2024-05-16 21:07:26'),
(12, 1, ';;\r\n', 1, '2024-05-16 21:07:48'),
(13, 1, '<button>asd</button>', 1, '2024-05-16 21:08:02'),
(14, 1, 'WOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOWWOW', 1, '2024-05-25 18:26:14'),
(26, 6, 'OWO :3\r\n', 0, '2024-06-01 18:12:25'),
(27, 8, 'NAH BUH', 0, '2024-06-01 18:12:52'),
(28, 9, 'BUH BUH BUH WAWA', 0, '2024-06-01 18:13:38');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `paswd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userName`, `paswd`) VALUES
(1, 'asd', 'asd'),
(2, 'zxc', 'zxc'),
(6, 'qwe', 'qwe'),
(8, 'Kolo123', 'qwe'),
(9, 'No1', 'qwe'),
(11, 'XD', 'qwe');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `liked_posts`
--
ALTER TABLE `liked_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `liked_posts`
--
ALTER TABLE `liked_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
