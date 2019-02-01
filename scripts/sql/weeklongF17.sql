-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 15, 2018 at 06:46 PM
-- Server version: 10.1.36-MariaDB-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cuhvmiwg_hvz`
--

-- --------------------------------------------------------

--
-- Table structure for table `weeklongF17`
--

CREATE TABLE `weeklongF17` (
  `memberID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `active` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'human',
  `user_hex` varchar(5) NOT NULL,
  `kill_count` varchar(5) NOT NULL DEFAULT '0',
  `starve_date` timestamp NULL DEFAULT NULL,
  `waiver` tinyint(1) DEFAULT NULL,
  `bandanna` tinyint(1) DEFAULT NULL,
  `orient` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weeklongF17`
--

INSERT INTO `weeklongF17` (`memberID`, `username`, `firstName`, `lastName`, `active`, `status`, `user_hex`, `kill_count`, `starve_date`, `waiver`, `bandanna`, `orient`) VALUES
(7, 'ghost', 'Scarlett', 'Harris', 'Yes', 'human', 'd8ca9', '', NULL, NULL, NULL, NULL),
(6, 'janderson', 'Jennifer', 'Anderson', 'Yes', 'human', '9563f', '', NULL, NULL, NULL, NULL),
(5, 'NerdyDruid', 'colleen', 'feuerborn', 'Yes', 'deceased', '51a17', '', '2017-11-03 21:59:00', NULL, NULL, NULL),
(9, 'CaptainPixels', 'Corbin', 'Peters', 'Yes', 'human', '306b0', '', NULL, NULL, NULL, NULL),
(11, 'clayton', 'Clayton', 'Golditch', 'Yes', 'human', '4fce6', '', NULL, NULL, NULL, NULL),
(12, 'Turncoat', 'Kyle', 'Bouchey', 'Yes', 'human', 'd4c71', '', NULL, NULL, NULL, NULL),
(13, 'woodyb2', 'Blake', 'Buxton', 'Yes', 'human', 'e970a', '', NULL, NULL, NULL, NULL),
(14, 'kspitz17', 'Katya', 'Spitznagel', 'Yes', 'human', 'ad966', '', NULL, NULL, NULL, NULL),
(15, 'Conner312', 'Conner', 'Dunathan', '4da8c856e2c3e51f7757d872b78e2144', 'human', '4972f', '', NULL, NULL, NULL, NULL),
(16, 'Luci5', 'Luci', 'Sherriff', 'Yes', 'human', 'ae470', '', NULL, NULL, NULL, NULL),
(17, 'Abhishek Kumar', 'Abhishek', 'Kumar', 'Yes', 'human', '4d69c', '', NULL, NULL, NULL, NULL),
(18, 'lakeeffectqueer', 'Laney', 'Franklin', 'Yes', 'deceased', '0452d', '1', '2017-11-05 18:04:00', NULL, NULL, NULL),
(19, 'soap_is_dope', 'Joey', 'Reed', 'Yes', 'human', 'c9253', '', NULL, NULL, NULL, NULL),
(20, 'nickyp4real', 'Nicholas', 'Probst', 'Yes', 'human', '8de22', '', NULL, NULL, NULL, NULL),
(21, 'Niko Senkov', 'Niko', 'Senkov', 'Yes', 'human', '970a7', '', NULL, NULL, NULL, NULL),
(22, 'Sidsubray', 'Siddhartha', 'Subray', 'Yes', 'human', 'eb73e', '', NULL, NULL, NULL, NULL),
(23, 'Ganesh', 'Ganesh', 'Byrandurga Gopinath', 'Yes', 'human', '44ecf', '', NULL, NULL, NULL, NULL),
(24, 'Storm Rider', 'Drew', 'Lawton', 'Yes', 'human', 'fb1a4', '', NULL, NULL, NULL, NULL),
(25, 'Jebe2465', 'Jessica', 'jebe2465@colorado.edu', 'f3db37baeca897c9bff8d7579acceb15', 'human', 'bde53', '', NULL, NULL, NULL, NULL),
(26, 'kach6345', 'Ka Kam', 'Chen', 'Yes', 'deceased', '7f22d', '', '2017-11-03 20:55:00', NULL, NULL, NULL),
(27, 'Galaxy girl', 'kristin', 'Bogar', 'Yes', 'deceased', '7621e', '', '2017-11-03 21:59:00', NULL, NULL, NULL),
(28, 'kstofosho ', 'Kevin', 'Storey', 'Yes', 'human', '9fc27', '', NULL, NULL, NULL, NULL),
(29, 'Will Smith\'s Dog', 'benjamin', 'brown', 'Yes', 'human', 'ab9aa', '', NULL, NULL, NULL, NULL),
(30, 'haha0216', 'Hannah', 'Hallenbeck', 'Yes', 'human', '912f4', '', NULL, NULL, NULL, NULL),
(31, 'Kawe7517', 'Kayla', 'Weier', 'e51cef32523a8f3f6d9a99257ee2eb11', 'human', 'aca20', '', NULL, NULL, NULL, NULL),
(32, 'ThatKidKenny', 'Kenny', 'Shankey', 'Yes', 'human', '280b8', '', NULL, NULL, NULL, NULL),
(222, 'Chriscosenza', 'Christopher', 'Cosenza', 'Yes', 'human', '0ff4a', '', NULL, NULL, NULL, NULL),
(34, 'Austin77', 'Austin', 'Gut', 'Yes', 'human', '4384a', '', NULL, NULL, NULL, NULL),
(35, 'Alexulanch', 'Alex', 'Ulanch', '741e05c41abeb7af99533574d1a8d04e', 'human', '22838', '', NULL, NULL, NULL, NULL),
(42, 'shasrethm', 'Maya', 'Shrestha', 'Yes', 'human', 'b0477', '', NULL, NULL, NULL, NULL),
(38, 'Emma', 'Olivia ', 'Braganza', 'Yes', 'human', '5ff46', '', NULL, NULL, NULL, NULL),
(39, 'isaiahk', 'Isaiah', 'Koolstra', '93914d91a7307afce8fb4e27b5b25937', 'human', 'ebe8f', '', NULL, NULL, NULL, NULL),
(40, 'Z0mN0m', 'Kendra', 'Nelson', 'Yes', 'human', '49c92', '', NULL, NULL, NULL, NULL),
(41, 'leob', 'Leo', 'Bruell', 'Yes', 'human', '7a6bb', '', NULL, NULL, NULL, NULL),
(43, 'Brandemwei', 'Wangkai', 'Wei', '48a0026df57946801d3bdc688dc7cc42', 'human', '88385', '', NULL, NULL, NULL, NULL),
(44, 'ItsMitch', 'Mitch', 'Trahan', 'Yes', 'human', 'a85a4', '', NULL, NULL, NULL, NULL),
(45, 'Codycodycody', 'Cody', 'Towstik', 'cddea8abadec0387507ba8f64b7a1239', 'human', '674aa', '', NULL, NULL, NULL, NULL),
(46, 'scarletmccauley', 'Scarlet ', 'McCauley ', 'Yes', 'human', 'a3a8f', '', NULL, NULL, NULL, NULL),
(47, 'Maggie B', 'Maggie', 'Boyle', 'Yes', 'human', 'a0774', '', NULL, NULL, NULL, NULL),
(48, 'Tschad', 'Tyler', 'Schad', 'ca0ff4ab3119f063d941df3809207613', 'human', '3e426', '', NULL, NULL, NULL, NULL),
(49, 'Kara shea', 'Kara', 'D\'Alessandro', 'ec01b089b48361cf8a2805e1163acd0c', 'human', '66e6c', '', NULL, NULL, NULL, NULL),
(50, 'Okaheel', 'Omar', 'Kaheel', 'Yes', 'human', '1d234', '', NULL, NULL, NULL, NULL),
(51, 'Fish N Chipz', 'Nicholas', 'Alvidrez', 'Yes', 'human', '8bb37', '', NULL, NULL, NULL, NULL),
(52, 'Victory Cookie', 'Victoria', 'Klimuk', 'Yes', 'human', '90754', '', NULL, NULL, NULL, NULL),
(53, 'saltlife97', 'kyle', 'bene', 'Yes', 'human', '1bea5', '', NULL, NULL, NULL, NULL),
(54, 'Stephanie_roberts ', 'Stephanie ', 'Roberts', 'Yes', 'human', '12d8d', '', NULL, NULL, NULL, NULL),
(55, 'nicolegordil', 'Nicolette', 'Gordillo LaRiviere', 'e278f2017154499b3075daa6774e4f9f', 'human', '379be', '', NULL, NULL, NULL, NULL),
(56, 'Keaton', 'Keaton', 'Camacho', 'Yes', 'human', '0be3c', '', NULL, NULL, NULL, NULL),
(57, 'jpalese', 'Jennifer', 'Palese', 'Yes', 'human', 'b16bd', '', NULL, NULL, NULL, NULL),
(58, 'Ssweet', 'Sarah', 'Sweet', 'Yes', 'human', '8bbd8', '', NULL, NULL, NULL, NULL),
(59, 'TestPlayer001', 'Justus', 'Leben', 'Yes', 'deceased', '93fdb', '5', '2017-11-04 15:27:00', NULL, NULL, NULL),
(60, 'theblueone', 'Cameron', 'Sojak', 'Yes', 'deceased', '3ba67', '', '2017-11-05 18:04:00', NULL, NULL, NULL),
(61, 'Bsal', 'Branden', 'Salomon', 'Yes', 'human', 'ff496', '', NULL, NULL, NULL, NULL),
(62, 'soli4712', 'Thorn', 'Lin', 'Yes', 'human', '0c3b7', '', NULL, NULL, NULL, NULL),
(63, 'elizabeisher', 'Eliza', 'Beisher', 'Yes', 'deceased', '7e980', '', '2017-11-05 18:04:00', NULL, NULL, NULL),
(64, 'chdu1446', 'Chris', 'Dusbabek', 'Yes', 'human', 'b3b4b', '', NULL, NULL, NULL, NULL),
(65, 'jacksonfull ', 'Jackson', 'Full', 'Yes', 'human', '524f6', '', NULL, NULL, NULL, NULL),
(66, 'Avery Troop', 'Avery', 'Troop', 'Yes', 'human', '58b17', '', NULL, NULL, NULL, NULL),
(67, 'muscleboy', 'Isaai', 'Urbina', 'Yes', 'deceased', '1fba9', '', '2017-11-03 20:02:00', NULL, NULL, NULL),
(68, 'GrayGhost666', 'Angel', 'Florencio', 'Yes', 'deceased', '74621', '5', '2017-11-05 18:04:00', NULL, NULL, NULL),
(69, 'Jorgeortiz99', 'Jorge', 'Ortiz', 'Yes', 'deceased', 'f9e13', '', '2017-11-03 20:55:00', NULL, NULL, NULL),
(70, 'AdamVega98', 'Adam', 'Vega', 'Yes', 'deceased', '8b02f', '2', '2017-11-03 20:02:00', NULL, NULL, NULL),
(71, 'bhse0345', 'Bhavya', 'Senwar', 'Yes', 'human', 'bfede', '', NULL, NULL, NULL, NULL),
(72, 'Jaimath', 'Jairaj', 'Mathur', 'Yes', 'human', 'ae05e', '', NULL, NULL, NULL, NULL),
(73, 'Gabe', 'Gabe', 'Cohen', 'c5491648967a1e1c63bc94d2286684ff', 'human', '0ea52', '', NULL, NULL, NULL, NULL),
(74, 'Smithsonian9898', 'Hayden', 'Smith', 'Yes', 'human', '2428d', '', NULL, NULL, NULL, NULL),
(75, 'Dana', 'Dana', 'Asfur', '6f10b0b56c0efbddd4b670102c042ccd', 'human', '22d00', '', NULL, NULL, NULL, NULL),
(76, 'cmr7874', 'Connor', 'Ryan', 'Yes', 'human', 'e7f28', '', NULL, NULL, NULL, NULL),
(77, 'May', 'May', 'Albader', '94e633a794f271c922c6c05ef8378b2d', 'human', 'ebc5f', '', NULL, NULL, NULL, NULL),
(78, 'Hokar1018', 'Matt', 'Alexander', 'Yes', 'human', '4aad6', '', NULL, NULL, NULL, NULL),
(79, 'Maddie P', 'Madeline', 'Pettine', 'da8cb7d6e5ccea6e092c79712d65663e', 'human', 'f493f', '', NULL, NULL, NULL, NULL),
(80, 'kelleymcc98', 'Kelley', 'McCarville', 'Yes', 'human', '5aac4', '', NULL, NULL, NULL, NULL),
(81, 'san696', 'Sierra', 'Nash', 'c6ea4f09b409e172f9021212ec37bdcc', 'human', '7b17f', '', NULL, NULL, NULL, NULL),
(82, 'pedro521', 'Joaquin', 'Valdez', 'bcdd5107d294c5dc4b44ecdc6a6cca4f', 'human', 'f7064', '', NULL, NULL, NULL, NULL),
(83, 'Wattsy716', 'Watts', 'Austen', 'f516d9f9997a59bd4f1df1785ddaafef', 'human', '3ca98', '', NULL, NULL, NULL, NULL),
(84, 'Jflo6', 'Jacob', 'Flores', 'Yes', 'human', 'a4626', '', NULL, NULL, NULL, NULL),
(85, 'Xx_Slayer23_xX', 'Erik', 'Stolz', 'Yes', 'human', '96a7c', '', NULL, NULL, NULL, NULL),
(86, 'RoseWalker', 'Emma', 'Hassman', 'Yes', 'human', '303d4', '', NULL, NULL, NULL, NULL),
(87, 'jakob.fletcher', 'Jakob', 'Fletcher', 'Yes', 'human', '88b3a', '', NULL, NULL, NULL, NULL),
(88, 'JiroLover7', 'Joseph', 'Michael', 'Yes', 'human', 'be1af', '', NULL, NULL, NULL, NULL),
(89, 'Juppuh', 'Jared', 'Darling-munson', 'e76530c6c415b205bb26024d8074af49', 'human', 'eccce', '', NULL, NULL, NULL, NULL),
(90, 'GiggleKitten', 'Phillip', 'Martinez', '0fc9a362772e5e9792d947b365d2aa40', 'human', '528b8', '', NULL, NULL, NULL, NULL),
(91, 'anadaig', 'Annanya', 'George', 'Yes', 'human', '7199f', '', NULL, NULL, NULL, NULL),
(92, 'thni6618', 'Ted', 'Niemann', 'Yes', 'human', 'e43e9', '', NULL, NULL, NULL, NULL),
(93, 'OutLAW', 'Aaron', 'Tucker', 'Yes', 'human', 'e0a43', '', NULL, NULL, NULL, NULL),
(94, 'Jeassa', 'Jarod', 'Eassa', 'Yes', 'human', '6365c', '', NULL, NULL, NULL, NULL),
(95, 'Rinzler', 'Madisen', 'Frie', 'Yes', 'human', '244f7', '', NULL, NULL, NULL, NULL),
(96, 'Soha', 'Andreas', 'Han', 'Yes', 'human', '40b00', '', NULL, NULL, NULL, NULL),
(97, 'dustfinger5280', 'Hunter', 'Allen', 'Yes', 'human', '91391', '', NULL, NULL, NULL, NULL),
(98, 'Bcab09', 'Benjamin', 'Alexander-Buie', 'Yes', 'human', '5fdb5', '', NULL, NULL, NULL, NULL),
(99, 'Sandeep', 'Sandeep', 'Kaushik', 'Yes', 'human', '39c7c', '', NULL, NULL, NULL, NULL),
(100, 'Zhch1699', 'Zhuoying', 'Chen', 'Yes', 'human', '2f578', '', NULL, NULL, NULL, NULL),
(101, 'aylasullivan', 'Ayla', 'Sullivan', 'Yes', 'human', '0e644', '', NULL, NULL, NULL, NULL),
(102, 'lexia', 'Jennifer', 'Alexia', 'Yes', 'human', '39532', '', NULL, NULL, NULL, NULL),
(103, 'Drizzy', 'Brendan', 'Ostrom', 'Yes', 'human', '7428d', '', NULL, NULL, NULL, NULL),
(104, 'colejordan66', 'Cole ', 'Jordan', 'Yes', 'human', '2205f', '', NULL, NULL, NULL, NULL),
(105, 'ESSIE', 'Essie', 'Gao', 'Yes', 'human', '90beb', '', NULL, NULL, NULL, NULL),
(106, 'njxnes', 'Nate', 'Jones', 'Yes', 'human', '52ae8', '', NULL, NULL, NULL, NULL),
(107, 'Robot723', 'Daniel', 'Garcia', 'Yes', 'human', 'a7614', '', NULL, NULL, NULL, NULL),
(108, 'Lexi', 'Shiyu', 'Lai', 'cee13096ac9233f302c456edcf6acc09', 'human', 'c0f83', '', NULL, NULL, NULL, NULL),
(109, 'ssyed227', 'Saad', 'Syed', 'Yes', 'human', '5341d', '', NULL, NULL, NULL, NULL),
(110, 'hubnert', 'Maura', 'Smith', 'Yes', 'human', '747d5', '', NULL, NULL, NULL, NULL),
(111, 'suryansh373', 'Suryansh', 'Singh', 'Yes', 'human', 'd1a95', '', NULL, NULL, NULL, NULL),
(112, 'Tutchtonator', 'Robin', 'Tutchton', 'cd9314d443f6af53165c31681661a9ca', 'human', '21ed7', '', NULL, NULL, NULL, NULL),
(113, 'Artyphex', 'Maddie', 'Aeling', 'Yes', 'deceased', '9cc0e', '', '2017-11-04 15:27:00', NULL, NULL, NULL),
(114, 'sjacobsen878', 'Sam', 'Jacobsen', 'Yes', 'human', '3998e', '', NULL, NULL, NULL, NULL),
(115, 'coonen.wyatt@gmail.com', 'Wyatt', 'Coonen', 'Yes', 'human', '17404', '', NULL, NULL, NULL, NULL),
(116, 'Tamollyo', 'Molly', 'Obermeier', 'Yes', 'human', '4bd81', '', NULL, NULL, NULL, NULL),
(117, 'Amandaaeag', 'Amanda', 'Gerritsen', 'Yes', 'human', '77e89', '', NULL, NULL, NULL, NULL),
(118, 'ydeath', 'yas', 'D', 'Yes', 'human', 'ba203', '', NULL, NULL, NULL, NULL),
(119, 'Callum', 'Callum', 'Schulz', '73f3424f0c8b93cee5e6242be1b4423b', 'human', '10224', '', NULL, NULL, NULL, NULL),
(120, 'jackdapogo', 'Jack', 'Davis', 'Yes', 'human', '4ab97', '', NULL, NULL, NULL, NULL),
(121, 'venkata uddaraju', 'venkata', 'uddaraju', 'Yes', 'human', 'd9d7d', '', NULL, NULL, NULL, NULL),
(122, 'DNThavehands42', 'Destin', 'Woods', '076def9291d925d11940903a47466c90', 'human', '9b2e0', '', NULL, NULL, NULL, NULL),
(123, 'Joca8873', 'Jonathan ', 'Callan ', 'Yes', 'human', '3f1b1', '', NULL, NULL, NULL, NULL),
(124, 'giro5409', 'Giovanni', 'Rodriguez-Avitia', 'Yes', 'human', 'fcb46', '', NULL, NULL, NULL, NULL),
(125, 'Camz', 'Cameron', 'Humphreys ', 'Yes', 'human', '55f77', '', NULL, NULL, NULL, NULL),
(126, 'Yarrow', 'Yarrow', 'Sullivan', '794acabfb1482736ac6a7188fd242bd9', 'human', '0cb3b', '', NULL, NULL, NULL, NULL),
(127, 'Dabrander', 'Dalton', 'Brander', 'Yes', 'deceased', '3eb39', '', '2017-11-04 15:27:00', NULL, NULL, NULL),
(128, 'jkillelea', 'Jacob', 'Killelea', 'Yes', 'deceased', 'd9ce3', '', '2017-11-04 16:15:00', NULL, NULL, NULL),
(129, 'Tristan', 'Tristan', 'Schoeman', 'Yes', 'human', '2f3bb', '', NULL, NULL, NULL, NULL),
(130, 'HarrisonB', 'Harrison', 'Bolin', 'Yes', 'human', 'c3ef2', '', NULL, NULL, NULL, NULL),
(131, 'DaneFisher', 'Dane', 'Fisher', 'Yes', 'human', 'f9965', '', NULL, NULL, NULL, NULL),
(132, 'allyfarraway', 'Ally', 'Farr', 'Yes', 'human', 'a3a7c', '', NULL, NULL, NULL, NULL),
(133, 'Twade7', 'Tom', 'Puhr', 'Yes', 'human', '2c101', '', NULL, NULL, NULL, NULL),
(134, 'Devviepie', 'Devin', 'Driggs', 'a80d245a7fd83aac490b8825f4eb54e2', 'human', '2afde', '', NULL, NULL, NULL, NULL),
(135, 'CarterHanson', 'Carter', 'Hanson', 'd41b8d0106216714bc0efb8781de6988', 'human', '75431', '', NULL, NULL, NULL, NULL),
(136, 'Kakarotten', 'Ezekiel', 'Williams', 'Yes', 'human', '8c015', '', NULL, NULL, NULL, NULL),
(137, 'dape6000', 'Davis', 'Peirce', 'Yes', 'human', '70b83', '', NULL, NULL, NULL, NULL),
(138, 'Ali-j', 'Alison ', 'Garscadden', 'Yes', 'human', '5cc20', '', NULL, NULL, NULL, NULL),
(139, 'Zomboy', 'Charles', 'Candon', 'Yes', 'human', 'c5bf3', '', NULL, NULL, NULL, NULL),
(140, 'Lgallowicz', 'Lindsey', 'Gallowicz', '14c1df77d6dcad560c08ffe702c30e53', 'human', '412ad', '', NULL, NULL, NULL, NULL),
(141, 'QuanScience', 'Jacob', 'McKean', 'Yes', 'human', 'f3965', '', NULL, NULL, NULL, NULL),
(142, 'Rocketman', 'Cedric', 'Leedy', 'Yes', 'human', '9e208', '', NULL, NULL, NULL, NULL),
(143, 'loshernajr', 'Carlos', 'Hernandez Martinez', 'Yes', 'human', '0bdc5', '', NULL, NULL, NULL, NULL),
(144, 'RoastedPecans', 'Connor', 'Thompson', 'Yes', 'human', 'dc368', '', NULL, NULL, NULL, NULL),
(145, 'Joso4992', 'Jose ', 'Soto', 'bfc4ee813b7f6855e09f317d2a5d5041', 'human', '644dc', '', NULL, NULL, NULL, NULL),
(146, 'Darkfire', 'Hanalei', 'Lintag', 'Yes', 'human', '4e1ed', '', NULL, NULL, NULL, NULL),
(147, 'DEADication', 'Lacey', 'Langman', 'Yes', 'human', 'd026f', '', NULL, NULL, NULL, NULL),
(148, 'megaBITES', 'Lacey', 'Langman', 'Yes', 'human', 'ba81b', '', NULL, NULL, NULL, NULL),
(149, 'Anubis65', 'Jack', 'Maicki', 'Yes', 'human', '14596', '', NULL, NULL, NULL, NULL),
(150, 'algathordk', 'Landon', 'McCully', 'Yes', 'human', 'bbc92', '', NULL, NULL, NULL, NULL),
(151, 'phhe1263', 'Phoebe', 'Hess', 'Yes', 'human', 'e1ed2', '', NULL, NULL, NULL, NULL),
(152, 'saal1800', 'sara', 'alhaddad', 'Yes', 'human', 'ab5f2', '', NULL, NULL, NULL, NULL),
(156, 'Lekshmi Prathap', 'Lekshmi', 'Prathap', 'Yes', 'human', 'e5300', '', NULL, NULL, NULL, NULL),
(154, 'shraddhadangi', 'Shraddha', 'Dangi', 'Yes', 'human', '13449', '', NULL, NULL, NULL, NULL),
(157, 'Darkrider97', 'Joe', 'Knapp', 'Yes', 'human', '3ba6a', '', NULL, NULL, NULL, NULL),
(158, 'shaurya', 'Shaurya ', 'Chitravanshi', 'Yes', 'human', 'f76c3', '', NULL, NULL, NULL, NULL),
(159, 'jkscool', 'Jonas', 'Kulberg-Savercool', 'Yes', 'human', '5eaa9', '', NULL, NULL, NULL, NULL),
(160, 'Erickrehbiel ', 'Eric', 'Krehbiel', 'Yes', 'human', '59ba0', '', NULL, NULL, NULL, NULL),
(161, 'shadedstrike', 'April', 'Ott', 'Yes', 'human', '6b023', '', NULL, NULL, NULL, NULL),
(162, 'deri9928', 'Devon', 'Ricken', 'd4e31be1e71b51582bfb28e73bd9e989', 'human', '86d50', '', NULL, NULL, NULL, NULL),
(163, 'Jett Moore', 'Jett', 'Moore', 'Yes', 'human', 'dea2b', '', NULL, NULL, NULL, NULL),
(164, 'make5845', 'Mary', 'Kelly', 'Yes', 'human', '7e6b5', '', NULL, NULL, NULL, NULL),
(165, 'MohammedJalai', 'Mohammed', 'Jalali', 'Yes', 'human', '74daf', '', NULL, NULL, NULL, NULL),
(167, 'Ozymandias', 'Devin', 'Driggs', 'Yes', 'human', '903ce', '', NULL, NULL, NULL, NULL),
(168, 'Hannah Briner', 'Hannah', 'Briner', 'Yes', 'human', '6ead5', '', NULL, NULL, NULL, NULL),
(169, 'Esteckler', 'Ella', 'Steckler', 'eb053ea1eac368834a387e63c6779df0', 'human', '3c393', '', NULL, NULL, NULL, NULL),
(170, 'Bamsberry', 'Blake', 'Amsberry', 'Yes', 'human', '1991d', '', NULL, NULL, NULL, NULL),
(171, 'Almostcandid', 'Elizabeth', 'Gregg', '536b750f25ed53fffcba23b33ab763d6', 'human', '00762', '', NULL, NULL, NULL, NULL),
(172, 'Hiba', 'Hiba', 'Al Abdali', 'Yes', 'human', 'e3ef9', '', NULL, NULL, NULL, NULL),
(173, 'TheDagger', 'Kyle', 'Dagg', 'Yes', 'human', 'eab24', '', NULL, NULL, NULL, NULL),
(174, 'Ennienoelle', 'Sienna', 'Wesner', 'b3788edb7e8d6b755232d16d1fecb40d', 'human', '2ec61', '', NULL, NULL, NULL, NULL),
(175, 'Nardstorm', 'Joseph', 'McSoud', 'Yes', 'human', '35bc6', '', NULL, NULL, NULL, NULL),
(176, 'Jazzyfizzle', 'Jasmine', 'Magno', '460285162be326c8cc46b766373b3f50', 'human', 'd4005', '', NULL, NULL, NULL, NULL),
(177, 'RamyunTylor', 'Tylor', 'Thai', '5631a866f91cac0d28acabb413c3a0da', 'human', 'f8870', '', NULL, NULL, NULL, NULL),
(178, 'Badriya', 'Badriya', 'Al Dhuhli', 'Yes', 'human', '3ee77', '', NULL, NULL, NULL, NULL),
(179, 'Jocr0509', 'Joey', 'Crispino', 'aaf148ba22170855a580144b5b524b3b', 'human', 'b8cc3', '', NULL, NULL, NULL, NULL),
(180, 'devboi', 'Devon', 'Ricken', 'Yes', 'human', '0b160', '', NULL, NULL, NULL, NULL),
(181, 'elmu6301', 'Elena', 'Murray', 'Yes', 'human', '9626a', '', NULL, NULL, NULL, NULL),
(183, 'castanon', 'carolyn', 'castanon', '1a84a45350752092aafe7028efecf9a1', 'human', '450ff', '', NULL, NULL, NULL, NULL),
(184, 'Swansonator225', 'Andrew', 'Swanson', 'Yes', 'human', 'b972b', '', NULL, NULL, NULL, NULL),
(185, 'Farragut', 'David', 'Nelson', 'Yes', 'human', '0f638', '', NULL, NULL, NULL, NULL),
(186, 'brmu1856', 'Brendan', 'mulcahy', 'Yes', 'human', 'a22da', '', NULL, NULL, NULL, NULL),
(187, 'RiFe0561', 'Riley', 'Ferrero', 'Yes', 'human', '3d8a7', '', NULL, NULL, NULL, NULL),
(189, 'alhy7727', 'Aleah', 'Hyvonen', 'Yes', 'human', '8869b', '', NULL, NULL, NULL, NULL),
(190, 'averyostrand', 'Avery', 'Ostrand', 'Yes', 'human', 'a9a39', '', NULL, NULL, NULL, NULL),
(191, 'brja3022', 'Brian', 'Jackman', 'd3cff64dadf365092620318baf671719', 'human', 'f51f3', '', NULL, NULL, NULL, NULL),
(192, 'damywei', 'Daniel ', 'Wei', 'Yes', 'human', 'b332f', '', NULL, NULL, NULL, NULL),
(193, 'Clara', 'Clara', 'Smith', 'Yes', 'human', '9ccc6', '', NULL, NULL, NULL, NULL),
(194, 'Somebodyxxx', 'Vaibhav', 'Chourasia', 'Yes', 'deceased', '50e2a', '', '2017-11-03 21:59:00', NULL, NULL, NULL),
(195, 'Elise157', 'Elise', 'Warnock', '188e64631901691f63af88c2096478fc', 'human', '0bbc1', '', NULL, NULL, NULL, NULL),
(196, 'Signyhs', 'Signy', 'Shumway', '0253cb1dc6f69284e0e9eb6fc423b94c', 'human', '03707', '', NULL, NULL, NULL, NULL),
(197, 'WagnerBB', 'Ben', 'Wagner', 'Yes', 'human', '5b7b2', '', NULL, NULL, NULL, NULL),
(198, 'Anthonylevy', 'Anthony', 'Levy', '00f01daddebf6169307cfddc7620a664', 'human', 'c51ec', '', NULL, NULL, NULL, NULL),
(199, 'graviityx', 'Lauren', 'Chen', 'Yes', 'human', '32562', '', NULL, NULL, NULL, NULL),
(200, 'GunsofCasey', 'Matt', 'Casey', 'Yes', 'deceased', '0f904', '', '2017-11-03 20:55:00', NULL, NULL, NULL),
(201, 'Miguel', 'Miguel', 'Guerrero', 'Yes', 'human', '07202', '', NULL, NULL, NULL, NULL),
(202, 'Hulksmash', 'Claudia', 'Chacon', '947413342b6083396be99f521934d6c4', 'human', 'eb354', '', NULL, NULL, NULL, NULL),
(203, 'ebta0134', 'Ebelyn', 'Tapia Garcia', 'a4a74c5f9496625b832c3d078e9a4f0e', 'human', 'dffe4', '', NULL, NULL, NULL, NULL),
(204, 'Jose13', 'Jose', 'Martinez', 'c85d18a4ef6c1d4052df8e994503f669', 'human', '39f75', '', NULL, NULL, NULL, NULL),
(205, 'Doran', 'Doran', 'Harrop', '591c2ed22cd9e2ef5ad1fba0db001603', 'human', '85db9', '', NULL, NULL, NULL, NULL),
(206, 'BLOB', 'Jayson', 'Williamson-Lee', 'Yes', 'human', 'bdd9c', '', NULL, NULL, NULL, NULL),
(207, 'beba6156', 'Ben', 'Barron', 'Yes', 'human', 'c06f3', '', NULL, NULL, NULL, NULL),
(208, 'borky_mcgee', 'Juno', 'Presken', 'Yes', 'deceased', 'e36a0', '4', '2017-11-03 21:59:00', NULL, NULL, NULL),
(209, 'alexbirmann', 'Alexandre', 'Birmann', 'Yes', 'human', 'd352c', '', NULL, NULL, NULL, NULL),
(210, 'Cyeags', 'Collin', 'Yeager', 'Yes', 'human', 'f204e', '', NULL, NULL, NULL, NULL),
(211, 'MrGingerson', 'Isaac', 'Dickerson', 'Yes', 'human', '0b459', '', NULL, NULL, NULL, NULL),
(212, 'Houghelpuff', 'Jacob ', 'Hough', 'Yes', 'deceased', '84d21', '', '2017-11-04 16:15:00', NULL, NULL, NULL),
(213, 'cbrumley', 'Carson', 'Brumley', 'Yes', 'human', '000ac', '', NULL, NULL, NULL, NULL),
(214, 'n8thegr8', 'Nathan', 'Nagaoka', 'Yes', 'human', '74781', '', NULL, NULL, NULL, NULL),
(215, 'Gretacon', 'Gretchen', 'Conley', 'Yes', 'human', '9a084', '', NULL, NULL, NULL, NULL),
(216, 'Gsta', 'Gabe', 'Staitman', 'Yes', 'human', 'c5655', '', NULL, NULL, NULL, NULL),
(217, 'frenchhorn11', 'Abby ', 'Marynowski', 'Yes', 'human', '0a0d6', '', NULL, NULL, NULL, NULL),
(230, 'jakecameron111', 'Jake ', 'Cameron', 'Yes', 'human', '1041e', '', NULL, NULL, NULL, NULL),
(219, 'patelrohan17298', 'Rohan', 'Patel', 'Yes', 'human', '30107', '', NULL, NULL, NULL, NULL),
(220, 'orich', 'Oriana', 'Richmond', 'Yes', 'human', '9fc51', '', NULL, NULL, NULL, NULL),
(221, 'cair1720', 'Carson', 'Irwin', 'Yes', 'human', 'f9649', '', NULL, NULL, NULL, NULL),
(223, 'Aus_Wein', 'Austin', 'Weingart', 'Yes', 'human', '2b2b9', '', NULL, NULL, NULL, NULL),
(224, 'Ryanxz', 'Ryan', 'Xu', 'Yes', 'human', 'a829e', '', NULL, NULL, NULL, NULL),
(225, 'ZigggyStardust', 'Zach', 'Yearout', 'Yes', 'human', '33706', '', NULL, NULL, NULL, NULL),
(226, 'caal0667', 'Cara', 'Allen', 'e53886c8ce7948af455d69740e667153', 'human', 'bf048', '', NULL, NULL, NULL, NULL),
(227, 'Sanjay_G', 'Sanjay', 'Gurunath', 'Yes', 'human', '98492', '', NULL, NULL, NULL, NULL),
(228, 't3chnojunk13', 'Adam', 'Skokan', 'Yes', 'human', 'a562a', '', NULL, NULL, NULL, NULL),
(229, 'Sicksacrifice ', 'Tan', 'Ner ', 'Yes', 'human', '80019', '', NULL, NULL, NULL, NULL),
(231, 'kunals', 'Kunal', 'Sinha', 'Yes', 'human', '3a8b7', '', NULL, NULL, NULL, NULL),
(232, 'micatrieu', 'Mica', 'Trieu', 'Yes', 'deceased', 'fdf1b', '', '2017-11-04 16:15:00', NULL, NULL, NULL),
(233, 'zeareal24', 'Everett', 'Abegg', 'Yes', 'human', '22e61', '', NULL, NULL, NULL, NULL),
(234, 'yavinbase', 'Michael', '', 'Yes', 'human', '30520', '', NULL, NULL, NULL, NULL),
(235, 'FIREEEL', 'Samuel', 'Felice', 'Yes', 'human', '4ee75', '', NULL, NULL, NULL, NULL),
(236, 'MarioBruh', 'Mario', 'Hanson', 'Yes', 'human', '988af', '', NULL, NULL, NULL, NULL),
(237, 'Lotfy', 'Lotfy', 'Abdel Khaliq', 'Yes', 'human', '549c2', '', NULL, NULL, NULL, NULL),
(238, 'Varun', 'Varun', 'Kirti', 'Yes', 'human', 'c6d5d', '', NULL, NULL, NULL, NULL),
(245, 'ssweet16', 'Sarah', 'Sweet', 'Yes', 'human', 'c757f', '', NULL, NULL, NULL, NULL),
(240, 'HERECOMESTHEGIBSON', 'Gibson', 'Olbrys', 'Yes', 'human', 'c2b95', '', NULL, NULL, NULL, NULL),
(241, 'jaythekeeper', 'Jay', 'Jennings', 'Yes', 'human', 'dfd0d', '', NULL, NULL, NULL, NULL),
(242, 'Dhoover58', 'Dylan', 'Hoover', 'Yes', 'human', '75f52', '', NULL, NULL, NULL, NULL),
(243, 'yungtroy', 'Troy', 'Chensri', 'Yes', 'human', '10682', '', NULL, NULL, NULL, NULL),
(244, 'sharanjeetsinghmago', 'Sharanjeet', 'Mago', 'Yes', 'human', 'e6586', '', NULL, NULL, NULL, NULL),
(246, 'ancient_papaya', 'Juan', 'Oleas', 'Yes', 'human', '1e732', '', NULL, NULL, NULL, NULL),
(247, 'George', 'George', 'Allison', 'Yes', 'human', 'cbec4', '', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `weeklongF17`
--
ALTER TABLE `weeklongF17`
  ADD PRIMARY KEY (`memberID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `weeklongF17`
--
ALTER TABLE `weeklongF17`
  MODIFY `memberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
