-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 12, 2024 at 06:21 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booklist_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `booklist`
--

CREATE TABLE `booklist` (
  `id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `stock` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booklist`
--

INSERT INTO `booklist` (`id`, `title`, `category_id`, `category`, `description`, `stock`, `created_at`, `updated_at`, `created_by`) VALUES
('13c839b3-8cd2-4b8c-a7ce-c383b3aa8be9', 'Sasuke', 'eae12b4f-1f3c-400e-a7aa-2a67308b9c27', 'Adventure', 'fafafa', '11', '2024-08-12 03:47:06', '2024-08-12 03:47:06', '8246e2bf-b088-4d19-96e6-4a4f8ea311fd'),
('245d128f-fa28-4ae4-9063-8aa867b7d694', 'Naruto', '46d148a8-f092-4404-a773-70c3b3920400', 'Technology', 'adada', '12', '2024-08-12 03:46:17', '2024-08-12 03:54:29', '09645644-bfe6-4a6f-a61c-5495f75066e5'),
('77cc3de9-6d52-477a-97a7-04bd159dc05f', 'Aku', 'eae12b4f-1f3c-400e-a7aa-2a67308b9c27', 'Adventure', 'ass', '2', '2024-08-12 04:10:01', '2024-08-12 04:19:37', '09645644-bfe6-4a6f-a61c-5495f75066e5');

-- --------------------------------------------------------

--
-- Table structure for table `booklist_attachment`
--

CREATE TABLE `booklist_attachment` (
  `id` varchar(255) NOT NULL,
  `booklist_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` text NOT NULL,
  `file_type` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `file_size` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booklist_attachment`
--

INSERT INTO `booklist_attachment` (`id`, `booklist_id`, `name`, `path`, `file_type`, `created_at`, `updated_at`, `file_size`) VALUES
('1c6d7ad8-118c-47ac-8978-b6385ff241f0', '77cc3de9-6d52-477a-97a7-04bd159dc05f', 'sub-topic-digistar_4.jpg', 'public/cover/sub-topic-digistar_4.jpg', 'image/jpeg', '2024-08-12 04:18:08', '2024-08-12 04:18:08', 189),
('2435a58a-8c95-408c-b01b-35fc79bec826', '77cc3de9-6d52-477a-97a7-04bd159dc05f', 'Form SOP STEI AKD 09_Permohonan Surat Keterangan_3.pdf', 'public/file/Form SOP STEI AKD 09_Permohonan Surat Keterangan_3.pdf', 'application/pdf', '2024-08-12 04:19:37', '2024-08-12 04:19:37', 475),
('61251bd7-ed6e-4b27-8d43-76a29c039457', '245d128f-fa28-4ae4-9063-8aa867b7d694', 'sub-topic-digistar_1.jpg', 'public/cover/sub-topic-digistar_1.jpg', 'image/jpeg', '2024-08-12 03:46:17', '2024-08-12 03:46:17', 189),
('d2b93c53-4a33-481e-a7bc-252469e4fb2d', '13c839b3-8cd2-4b8c-a7ce-c383b3aa8be9', 'Kuis 2 - II2221 Manajemen Proyek 2 2023_2024 2.pdf', 'public/file/Kuis 2 - II2221 Manajemen Proyek 2 2023_2024 2.pdf', 'application/pdf', '2024-08-12 03:47:06', '2024-08-12 03:47:06', 132),
('d7438cf5-468c-49c1-b57b-6651c7402dfd', '245d128f-fa28-4ae4-9063-8aa867b7d694', 'cat.jpeg', 'public/cover/cat.jpeg', 'image/jpeg', '2024-08-12 03:54:29', '2024-08-12 03:54:29', 6),
('e1a2f8de-51ac-4b7f-8b1f-cc7e483c12a8', '245d128f-fa28-4ae4-9063-8aa867b7d694', 'Form SOP STEI AKD 09_Permohonan Surat Keterangan_1.pdf', 'public/file/Form SOP STEI AKD 09_Permohonan Surat Keterangan_1.pdf', 'application/pdf', '2024-08-12 03:54:29', '2024-08-12 03:54:29', 475),
('e2a678aa-6bb0-435a-a9aa-6067cb10da14', '13c839b3-8cd2-4b8c-a7ce-c383b3aa8be9', 'Instagram story - 1 (2).png', 'public/cover/Instagram story - 1 (2).png', 'image/png', '2024-08-12 03:47:06', '2024-08-12 03:47:06', 454);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `created_at`, `updated_at`) VALUES
('46d148a8-f092-4404-a773-70c3b3920400', 'Technology', '2024-08-12 03:34:45', '2024-08-12 03:34:45'),
('eae12b4f-1f3c-400e-a7aa-2a67308b9c27', 'Adventure', '2024-08-11 22:48:14', '2024-08-11 22:52:44');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `created_at`, `updated_at`) VALUES
('09729ee0-a844-11e9-b025-4552cee8b9e0', 'User', '2024-08-11 21:24:54', '2024-08-11 21:24:54'),
('1d221e90-e9e5-11eb-a311-63b2c6833a92', 'Admin', '2024-08-11 21:24:54', '2024-08-11 21:24:54');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `created_at`, `updated_at`) VALUES
('09645644-bfe6-4a6f-a61c-5495f75066e5', 'Kevin Prayoga', 'kevinprayoga', '$2y$10$U3tun9yiaSj9nBmdllFxa.3LRDLMLJpnrhvrXf6PDbTR4HZnEkcBe', '2024-08-11 19:29:51', '2024-08-11 19:29:51'),
('8246e2bf-b088-4d19-96e6-4a4f8ea311fd', 'anjayani', 'gurinjay', '$2y$10$jH5XeAJ0q5YRRvegzZWnReDX/7Nmi4Sz3eBn4ZortEZ9HkAlOS7/u', '2024-08-11 19:48:54', '2024-08-11 19:48:54');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `role_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `user_id`, `role_id`) VALUES
('08026dd0-cd77-11e9-8ca9-a1e58c2c0f4f', '09645644-bfe6-4a6f-a61c-5495f75066e5', '1d221e90-e9e5-11eb-a311-63b2c6833a92'),
('9c717bc0-4fa9-4d9d-8ac0-236c40e1eb5e', '8246e2bf-b088-4d19-96e6-4a4f8ea311fd', '09729ee0-a844-11e9-b025-4552cee8b9e0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booklist`
--
ALTER TABLE `booklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booklist_attachment`
--
ALTER TABLE `booklist_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
