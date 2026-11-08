-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2026 at 08:20 AM
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
-- Database: `leaflink`
--

-- --------------------------------------------------------

--
-- Table structure for table `abnormalreport`
--

CREATE TABLE `abnormalreport` (
  `abnormalId` varchar(11) NOT NULL,
  `submissionId` varchar(11) NOT NULL,
  `moderatorId` varchar(11) NOT NULL,
  `reason` text NOT NULL,
  `reportDate` date NOT NULL,
  `remark` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `abnormalreport`
--

INSERT INTO `abnormalreport` (`abnormalId`, `submissionId`, `moderatorId`, `reason`, `reportDate`, `remark`) VALUES
('AR000001', 'S000003', 'U000003', '[Fake Evidence] Use fake photo', '2026-08-22', NULL),
('AR000002', 'S000006', 'U000003', '[Duplicate Submission] Reuse same picture', '2026-08-22', 'Reject - Due to evidence duplicated');

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activityId` varchar(11) NOT NULL,
  `activityName` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `pointsReward` int(11) NOT NULL,
  `rules` text NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activityId`, `activityName`, `description`, `category`, `pointsReward`, `rules`, `status`) VALUES
('A000001', 'Recycle Plastic', 'Collect and recycle plastic bottles.', 'Recycling', 30, 'Recycle at least 5 plastic bottles.', 'Active'),
('A000002', 'Plant a Tree', 'Plant a tree and help improve the environment.', 'Tree Planting', 50, 'Plant at least one tree and submit photo evidence.', 'Active'),
('A000003', 'Beach Cleanup', 'Participate in a beach cleaning activity.', 'Community Service', 80, 'Attend the cleanup event and submit evidence.', 'Active'),
('A000004', 'Use Reusable Bottle', 'Use a reusable bottle instead of disposable bottles.', 'Recycling', 20, 'Use a reusable bottle for one full day.', 'Inactive'),
('A000005', 'Public Transport', 'Use public transportation instead of private vehicles.', 'Transportation', 40, 'Use public transport for your trip.', 'Active'),
('A000006', 'Save Electricity', 'Reduce electricity consumption at home or campus.', 'Energy Saving', 25, 'Turn off unnecessary electrical appliances.', 'Active'),
('A000007', 'Paperless Day', 'Avoid unnecessary paper usage for one day.', 'Recycling', 25, 'Avoid printing documents for one day.', 'Inactive'),
('A000008', 'Campus Cleanup', 'Help clean areas around campus.', 'Community Service', 60, 'Participate in campus cleanup activity.', 'Active'),
('A000009', 'Bring Your Own Bag', 'Use reusable bags when shopping.', 'Recycling', 20, 'Use a reusable shopping bag.', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `activitysubmission`
--

CREATE TABLE `activitysubmission` (
  `submissionId` varchar(11) NOT NULL,
  `participantId` varchar(11) NOT NULL,
  `activityId` varchar(11) DEFAULT NULL,
  `evidencePhoto` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `moderatorId` varchar(11) DEFAULT NULL,
  `submissionDate` date NOT NULL,
  `submissionTime` time NOT NULL,
  `challengeId` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activitysubmission`
--

INSERT INTO `activitysubmission` (`submissionId`, `participantId`, `activityId`, `evidencePhoto`, `description`, `status`, `moderatorId`, `submissionDate`, `submissionTime`, `challengeId`) VALUES
('S000001', 'P000001', 'A000001', 'recycle1.jpg', 'Recycled 10 plastic bottles at the campus recycling station.', 'Approved', 'U000003', '2026-08-12', '09:15:00', NULL),
('S000002', 'P000002', 'A000002', 'plantTree.jpg', 'Planted a small tree with my classmates.', 'Approved', 'U000003', '2026-08-12', '10:20:00', NULL),
('S000003', 'P000003', 'A000004', 'bottle_003.jpg', 'Used my reusable bottle throughout the day.', 'Pending', NULL, '2026-08-13', '08:30:00', NULL),
('S000004', 'P000004', 'A000005', 'transport_004.jpg', 'Used the MRT to travel to campus.', 'Approved', 'U000004', '2026-08-13', '09:10:00', NULL),
('S000005', 'P000005', 'A000008', 'cleanup_005.jpg', 'Joined the campus cleanup activity.', 'Approved', 'U000003', '2026-08-14', '11:00:00', NULL),
('S000006', 'P000006', 'A000006', 'electricity_006.jpg', 'Turned off unnecessary lights and electrical appliances.', 'Pending', NULL, '2026-08-14', '15:30:00', NULL),
('S000007', 'P000001', NULL, 'team_recycle_013.jpg', 'Recycled plastic bottles as part of my team challenge.', 'Approved', 'U000003', '2026-08-18', '09:20:00', 'TC000001'),
('S000008', 'P000002', NULL, 'team_recycle_014.jpg', 'Collected recyclable plastic with my team.', 'Pending', NULL, '2026-08-18', '10:10:00', 'TC000001'),
('S000009', 'P000005', NULL, 'team_green_015.jpg', 'Participated in the Green Campus Challenge.', 'Approved', 'U000004', '2026-08-18', '14:00:00', 'TC000002'),
('S000010', 'P000003', 'A000006', 'energy_018.jpg', 'Reduced electricity usage in my room.', 'Rejected', 'U000004', '2026-08-19', '17:45:00', NULL),
('S000011', 'P000006', 'A000001', 'recycle_019.jpg', 'Recycled 12 plastic bottles.', 'Approved', 'U000003', '2026-08-20', '08:50:00', NULL),
('S000012', 'P000004', 'A000004', 'bottle_022.jpg', 'Used a reusable bottle for the whole day.', 'Approved', 'U000003', '2026-08-20', '16:30:00', NULL),
('S000013', 'P000001', 'A000008', 'cleanup_024.jpg', 'Helped clean the campus garden.', 'Approved', 'U000004', '2026-08-21', '10:30:00', NULL),
('S000014', 'P000005', 'A000001', 'recycle_025.jpg', 'Recycled more than 10 plastic bottles.', 'Approved', 'U000003', '2026-08-21', '11:45:00', NULL),
('S000015', 'P000001', 'A000009', 'bag.jpg', 'I bring my bag when shopping', 'Pending', NULL, '2026-08-21', '18:57:07', NULL),
('S000016', 'P000004', 'A000008', 'campuscLeanup.jpg', 'i clean up the campus with my friend during weekend', 'Pending', NULL, '2026-08-21', '18:58:11', NULL),
('S000017', 'P000001', 'A000005', 'publicTransport.jpg', 'I use public transport with my friend during weekend', 'Rejected', 'U000003', '2026-08-21', '19:13:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `badge`
--

CREATE TABLE `badge` (
  `badgeId` varchar(11) NOT NULL,
  `badgeName` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `requiredPoints` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `badge`
--

INSERT INTO `badge` (`badgeId`, `badgeName`, `description`, `requiredPoints`) VALUES
('B000001', 'Bronze Badge', 'Earn at least 100 points.', 100),
('B000002', 'Silver Badge', 'Earn at least 300 points.', 300),
('B000003', 'Gold Badge', 'Earn at least 600 points.', 600),
('B000004', 'Green Hero', 'Earn at least 1000 points.', 1000),
('B000005', 'Eco Starter', 'Complete your first green activity.', 30);

-- --------------------------------------------------------

--
-- Table structure for table `participant`
--

CREATE TABLE `participant` (
  `participantId` varchar(11) NOT NULL,
  `participantType` varchar(25) NOT NULL,
  `faculty` varchar(100) NOT NULL,
  `pointBalance` int(11) NOT NULL,
  `userId` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participant`
--

INSERT INTO `participant` (`participantId`, `participantType`, `faculty`, `pointBalance`, `userId`) VALUES
('P000001', 'Student', 'School of Computing', 160, 'U000001'),
('P000002', 'Student', 'School of Engineering', 380, 'U000002'),
('P000003', 'Student', 'School of Computing', 260, 'U000006'),
('P000004', 'Student', 'School of Technology', 280, 'U000007'),
('P000005', 'Student', 'School of Design', 670, 'U000008'),
('P000006', 'Student', 'School of Business', 310, 'U000009');

-- --------------------------------------------------------

--
-- Table structure for table `participantbadge`
--

CREATE TABLE `participantbadge` (
  `participantBadgeId` varchar(11) NOT NULL,
  `participantId` varchar(11) NOT NULL,
  `badgeId` varchar(11) NOT NULL,
  `awardDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participantbadge`
--

INSERT INTO `participantbadge` (`participantBadgeId`, `participantId`, `badgeId`, `awardDate`) VALUES
('PB000001', 'P000001', 'B000001', '2026-07-20'),
('PB000002', 'P000001', 'B000002', '2026-07-21'),
('PB000003', 'P000002', 'B000001', '2026-07-25'),
('PB000004', 'P000003', 'B000001', '2026-08-01'),
('PB000005', 'P000005', 'B000001', '2026-07-15'),
('PB000006', 'P000005', 'B000002', '2026-07-30'),
('PB000007', 'P000005', 'B000003', '2026-08-10'),
('PB000008', 'P000006', 'B000001', '2026-08-02'),
('PB000009', 'P000004', 'B000001', '2026-08-03'),
('PB000010', 'P000004', 'B000005', '2026-08-08'),
('PB000011', 'P000005', 'B000005', '2026-08-09'),
('PB000012', 'P000006', 'B000002', '2026-08-10'),
('PB000013', 'P000006', 'B000005', '2026-08-15'),
('PB000014', 'P000003', 'B000005', '2026-08-20'),
('PB000015', 'P000002', 'B000002', '2026-08-23'),
('PB000016', 'P000002', 'B000005', '2026-08-25'),
('PB000017', 'P000001', 'B000005', '2026-08-25');

-- --------------------------------------------------------

--
-- Table structure for table `pointtransaction`
--

CREATE TABLE `pointtransaction` (
  `transactionId` varchar(11) NOT NULL,
  `participantId` varchar(11) NOT NULL,
  `submissionId` varchar(11) DEFAULT NULL,
  `redemptionId` varchar(11) DEFAULT NULL,
  `pointChange` int(11) NOT NULL,
  `transactionType` varchar(100) NOT NULL,
  `transactionDate` date NOT NULL,
  `transactionTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pointtransaction`
--

INSERT INTO `pointtransaction` (`transactionId`, `participantId`, `submissionId`, `redemptionId`, `pointChange`, `transactionType`, `transactionDate`, `transactionTime`) VALUES
('T000001', 'P000001', 'S000001', NULL, 30, 'Earn', '2026-08-12', '09:30:00'),
('T000002', 'P000002', 'S000002', NULL, 50, 'Earn', '2026-08-12', '10:40:00'),
('T000003', 'P000004', 'S000004', NULL, 40, 'Earn', '2026-08-13', '09:30:00'),
('T000004', 'P000005', 'S000005', NULL, 60, 'Earn', '2026-08-14', '11:20:00'),
('T000005', 'P000001', 'S000007', NULL, 50, 'Earn', '2026-08-18', '09:40:00'),
('T000006', 'P000005', 'S000009', NULL, 60, 'Earn', '2026-08-18', '14:20:00'),
('T000007', 'P000006', 'S000011', NULL, 30, 'Earn', '2026-08-20', '09:10:00'),
('T000008', 'P000004', 'S000012', NULL, 20, 'Earn', '2026-08-20', '16:50:00'),
('T000009', 'P000001', 'S000013', NULL, 60, 'Earn', '2026-08-21', '10:40:00'),
('T000010', 'P000001', NULL, 'RD000001', -200, 'Redeem', '2026-08-05', '10:05:00'),
('T000011', 'P000002', NULL, 'RD000002', -80, 'Redeem', '2026-08-06', '11:25:00'),
('T000012', 'P000001', NULL, 'RD000006', -80, 'Redeem', '2026-08-19', '10:35:00'),
('T000013', 'P000005', 'S000014', NULL, 30, 'Earn', '2026-08-22', '00:36:04'),
('T000014', 'P000004', NULL, 'RD000011', -200, 'Redeem', '2026-08-25', '08:13:59'),
('T000015', 'P000004', NULL, 'RD000011', 200, 'Refund', '2026-08-25', '14:14:31');

-- --------------------------------------------------------

--
-- Table structure for table `reward`
--

CREATE TABLE `reward` (
  `rewardId` varchar(11) NOT NULL,
  `rewardName` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(225) NOT NULL,
  `pointRequired` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reward`
--

INSERT INTO `reward` (`rewardId`, `rewardName`, `description`, `image`, `pointRequired`, `stock`, `status`) VALUES
('RW000001', 'Reusable Bottle', 'A stainless steel reusable water bottle.', 'bottle.png', 200, 20, 'Active'),
('RW000002', 'Canvas Bag', 'Reusable eco-friendly canvas shopping bag.', 'bag.png', 150, 30, 'Active'),
('RW000003', 'Recycled Notebook', 'Notebook made from recycled paper.', 'notebook.png', 80, 49, 'Active'),
('RW000004', 'Eco Pen Set', 'Set of recycled-material pens.', 'pen.png', 100, 40, 'Active'),
('RW000005', 'Plant Starter Kit', 'Small kit for growing your own plant.', 'plantkit.png', 300, 15, 'Active'),
('RW000006', 'Bamboo Cutlery Set', 'Reusable bamboo spoon, fork and chopsticks.', 'cutlery.png', 250, 20, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rewardredemption`
--

CREATE TABLE `rewardredemption` (
  `redemptionId` varchar(11) NOT NULL,
  `participantId` varchar(11) NOT NULL,
  `rewardId` varchar(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `moderatorId` varchar(11) DEFAULT NULL,
  `redeemedDate` date NOT NULL,
  `redeemedTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rewardredemption`
--

INSERT INTO `rewardredemption` (`redemptionId`, `participantId`, `rewardId`, `status`, `moderatorId`, `redeemedDate`, `redeemedTime`) VALUES
('RD000001', 'P000001', 'RW000001', 'Approved', 'U000003', '2026-08-05', '10:00:00'),
('RD000002', 'P000002', 'RW000003', 'Approved', 'U000004', '2026-08-06', '11:20:00'),
('RD000003', 'P000005', 'RW000005', 'Pending', NULL, '2026-08-12', '09:30:00'),
('RD000004', 'P000006', 'RW000002', 'Pending', NULL, '2026-08-13', '10:15:00'),
('RD000005', 'P000003', 'RW000003', 'Rejected', 'U000004', '2026-08-16', '16:45:00'),
('RD000006', 'P000001', 'RW000003', 'Approved', 'U000004', '2026-08-19', '10:30:00'),
('RD000007', 'P000005', 'RW000002', 'Approved', 'U000003', '2026-08-19', '12:10:00'),
('RD000008', 'P000002', 'RW000004', 'Rejected', 'U000004', '2026-08-20', '14:20:00'),
('RD000009', 'P000006', 'RW000003', 'Pending', NULL, '2026-08-21', '09:15:00'),
('RD000010', 'P000004', 'RW000003', 'Approved', 'U000003', '2026-08-25', '06:57:04'),
('RD000011', 'P000004', 'RW000001', 'Rejected', 'U000003', '2026-08-25', '08:13:59');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `roleId` varchar(11) NOT NULL,
  `RoleName` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`roleId`, `RoleName`) VALUES
('R000001', 'Participant'),
('R000002', 'Moderator'),
('R000003', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `teamchallenge`
--

CREATE TABLE `teamchallenge` (
  `challengeId` varchar(11) NOT NULL,
  `challengeName` varchar(100) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `challengePoint` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teamchallenge`
--

INSERT INTO `teamchallenge` (`challengeId`, `challengeName`, `startDate`, `endDate`, `status`, `challengePoint`) VALUES
('TC000001', 'Recycling 5 Plastic Challenge', '2026-08-01', '2026-08-31', 'Active', 50),
('TC000002', 'Plant a Tree Challenge', '2026-08-10', '2026-08-31', 'Active', 60),
('TC000003', 'Clean-Up Community Challenge', '2026-09-01', '2026-09-30', 'Inactive', 80),
('TC000004', '3-Day No Plastic Challenge', '2026-07-01', '2026-07-31', 'Inactive', 70);

-- --------------------------------------------------------

--
-- Table structure for table `teammember`
--

CREATE TABLE `teammember` (
  `teamMemberId` varchar(11) NOT NULL,
  `participantId` varchar(11) NOT NULL,
  `challengeId` varchar(11) DEFAULT NULL,
  `teamName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teammember`
--

INSERT INTO `teammember` (`teamMemberId`, `participantId`, `challengeId`, `teamName`) VALUES
('TM000001', 'P000001', 'TC000001', 'Eco Warriors'),
('TM000002', 'P000002', 'TC000001', 'Eco Warriors'),
('TM000003', 'P000003', 'TC000001', 'Eco Warriors');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` varchar(11) NOT NULL,
  `roleId` varchar(11) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `emailAddress` varchar(100) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `dateOfBirth` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `roleId`, `fullName`, `emailAddress`, `phoneNumber`, `password`, `dateOfBirth`) VALUES
('U000001', 'R000001', 'Wong Yun Xuan', 'yunxuan2007@gmail.com', '0196565981', '$2y$10$O1ss6nUS29dl0Rw9CKdJ3er/X5s4i3ynL5rHFm9O8GXRJ2C0Mu7yS', '2007-04-26'),
('U000002', 'R000001', 'Tan Jie Yu', 'jieyu2007@gmail.com', '0129024134', '$2y$10$B/14RN7QkA21xxzaAxl/EeyBvt9SmTpHGUm/0fQudAjWjZyXRh2DS', '2007-05-29'),
('U000003', 'R000002', 'Simone Lee Yu En', 'simone2007@gmail.com', '0134201698', '$2y$10$5g6hpHb5C.QrBGFOVl/7u.lWALZU5EgWMNxScGQ0iTCJKY5Ofne/e', '2007-05-29'),
('U000004', 'R000002', 'Le Canny', 'canny2007@gmail.com', '0187825600', '$2y$10$iWFZdOqC8ICwCLy5hWc.E.U5oOckIZ0/JWZiyHjGZfspvSqCfrE3u', '2007-12-03'),
('U000005', 'R000003', 'Tracy Fam Kai En', 'tracy2007@gmail.com', '01110168116', '$2y$10$X.PYJgsi0ig3tBMW9Laureihb5ykDqcYDQc4Pvq8vREu6vpo0J2SW', '2007-01-27'),
('U000006', 'R000001', 'Wong Wan Ming', 'wanming@gmail.com', '0193460999', '$2y$10$Rsglcod6wGRyICSYmpq6Hu/uNlY7.ltsx9jAU9qwGBXojG4oDdJli', '2001-07-26'),
('U000007', 'R000001', 'Wong Wan Feng', 'wanfeng@gmail.com', '0196262936', '$2y$10$xcR8bGmK/VpuZQeiHVQ44OcIbBlr8LquiXO0aspkRDBk/FBu3rAcq', '1997-08-13'),
('U000008', 'R000001', 'Sim Lei Yean', 'leiyean@gmail.com', '0196262999', '$2y$10$MJswAKCvjRm5dQIWq7ziLOH1aj61HwaTBEz/1vIMc9GOz9ICqtSbe', '2005-09-05'),
('U000009', 'R000001', 'Wong Wei Huang', 'weihuang@gmail.com', '0196588888', '$2y$10$8cYMz/WoZz5gIX4GvCJr9eY/DxOp3VLPhenP6QvhC3sR9oo2G7LG.', '2006-12-02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abnormalreport`
--
ALTER TABLE `abnormalreport`
  ADD PRIMARY KEY (`abnormalId`),
  ADD KEY `submissionId` (`submissionId`),
  ADD KEY `moderatorId` (`moderatorId`);

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activityId`);

--
-- Indexes for table `activitysubmission`
--
ALTER TABLE `activitysubmission`
  ADD PRIMARY KEY (`submissionId`),
  ADD KEY `participantId` (`participantId`),
  ADD KEY `activityId` (`activityId`),
  ADD KEY `moderatorId` (`moderatorId`),
  ADD KEY `fk_activitysubmission_challenge` (`challengeId`);

--
-- Indexes for table `badge`
--
ALTER TABLE `badge`
  ADD PRIMARY KEY (`badgeId`);

--
-- Indexes for table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`participantId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `participantbadge`
--
ALTER TABLE `participantbadge`
  ADD PRIMARY KEY (`participantBadgeId`),
  ADD KEY `participantId` (`participantId`),
  ADD KEY `badgeId` (`badgeId`);

--
-- Indexes for table `pointtransaction`
--
ALTER TABLE `pointtransaction`
  ADD PRIMARY KEY (`transactionId`),
  ADD KEY `participantId` (`participantId`),
  ADD KEY `submissionId` (`submissionId`),
  ADD KEY `redemptionId` (`redemptionId`);

--
-- Indexes for table `reward`
--
ALTER TABLE `reward`
  ADD PRIMARY KEY (`rewardId`);

--
-- Indexes for table `rewardredemption`
--
ALTER TABLE `rewardredemption`
  ADD PRIMARY KEY (`redemptionId`),
  ADD KEY `participantId` (`participantId`),
  ADD KEY `rewardId` (`rewardId`),
  ADD KEY `moderatorId` (`moderatorId`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`roleId`);

--
-- Indexes for table `teamchallenge`
--
ALTER TABLE `teamchallenge`
  ADD PRIMARY KEY (`challengeId`);

--
-- Indexes for table `teammember`
--
ALTER TABLE `teammember`
  ADD PRIMARY KEY (`teamMemberId`),
  ADD KEY `participantId` (`participantId`),
  ADD KEY `challengeId` (`challengeId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`),
  ADD KEY `roleId` (`roleId`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `abnormalreport`
--
ALTER TABLE `abnormalreport`
  ADD CONSTRAINT `abnormalreport_ibfk_1` FOREIGN KEY (`submissionId`) REFERENCES `activitysubmission` (`submissionId`),
  ADD CONSTRAINT `abnormalreport_ibfk_2` FOREIGN KEY (`moderatorId`) REFERENCES `user` (`userId`);

--
-- Constraints for table `activitysubmission`
--
ALTER TABLE `activitysubmission`
  ADD CONSTRAINT `activitysubmission_ibfk_1` FOREIGN KEY (`participantId`) REFERENCES `participant` (`participantId`),
  ADD CONSTRAINT `activitysubmission_ibfk_2` FOREIGN KEY (`activityId`) REFERENCES `activity` (`activityId`),
  ADD CONSTRAINT `activitysubmission_ibfk_3` FOREIGN KEY (`moderatorId`) REFERENCES `user` (`userId`),
  ADD CONSTRAINT `fk_activitysubmission_challenge` FOREIGN KEY (`challengeId`) REFERENCES `teamchallenge` (`challengeId`);

--
-- Constraints for table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `participant_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);

--
-- Constraints for table `participantbadge`
--
ALTER TABLE `participantbadge`
  ADD CONSTRAINT `participantbadge_ibfk_1` FOREIGN KEY (`participantId`) REFERENCES `participant` (`participantId`),
  ADD CONSTRAINT `participantbadge_ibfk_2` FOREIGN KEY (`badgeId`) REFERENCES `badge` (`badgeId`);

--
-- Constraints for table `pointtransaction`
--
ALTER TABLE `pointtransaction`
  ADD CONSTRAINT `pointtransaction_ibfk_1` FOREIGN KEY (`participantId`) REFERENCES `participant` (`participantId`),
  ADD CONSTRAINT `pointtransaction_ibfk_2` FOREIGN KEY (`submissionId`) REFERENCES `activitysubmission` (`submissionId`),
  ADD CONSTRAINT `pointtransaction_ibfk_3` FOREIGN KEY (`redemptionId`) REFERENCES `rewardredemption` (`redemptionId`);

--
-- Constraints for table `rewardredemption`
--
ALTER TABLE `rewardredemption`
  ADD CONSTRAINT `rewardredemption_ibfk_1` FOREIGN KEY (`participantId`) REFERENCES `participant` (`participantId`),
  ADD CONSTRAINT `rewardredemption_ibfk_2` FOREIGN KEY (`rewardId`) REFERENCES `reward` (`rewardId`),
  ADD CONSTRAINT `rewardredemption_ibfk_3` FOREIGN KEY (`moderatorId`) REFERENCES `user` (`userId`);

--
-- Constraints for table `teammember`
--
ALTER TABLE `teammember`
  ADD CONSTRAINT `teammember_ibfk_1` FOREIGN KEY (`participantId`) REFERENCES `participant` (`participantId`),
  ADD CONSTRAINT `teammember_ibfk_2` FOREIGN KEY (`challengeId`) REFERENCES `teamchallenge` (`challengeId`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`roleId`) REFERENCES `role` (`roleId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
