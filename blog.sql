-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2022 at 11:32 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'News'),
(2, 'Sports');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `category_id`, `user_id`) VALUES
(1, 'Post 1', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed voluptate nostrum provident repellat tenetur alias porro eos minima doloribus. Quos minima, cum repellat aliquam eveniet quam error atque magnam pariatur!', 1, 1),
(33, 'Post 2 Update', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium saepe laborum tempora doloremque, fugit dolorum sunt, doloribus aspernatur voluptatibus esse assumenda facere amet, commodi dicta sit? Nisi esse ipsa dolore?', 2, 1),
(35, 'post 3', 'Omnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in modOmnis facilis in mod', 1, 22),
(36, 'Post 4', 'Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid', 2, 22),
(37, 'Post 5', 'Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid', 2, 22),
(38, 'Post 6', 'Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid Ipsum veritatis quid', 1, 22);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'test', 'test@gmail.com', '$2y$10$FAW8VB69WupQfR86rh9A..rwILUyCmgEXdmYIQK75tDYE774K2TA.'),
(22, 'Pearl Cross', 'duxadyjy@mailinator.com', '$2y$10$iwSYzX4lpXOz4p398iFAaOtT9jhnYXGrYz3H5xRbsm4EfVMp1YYkK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `u_id` (`user_id`),
  ADD KEY `cat_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `cat_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `u_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
