-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 06, 2024 at 07:01 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `contact_info` varchar(255) NOT NULL,
  `services_required` text NOT NULL,
  `projected_completion_date` date NOT NULL,
  `amount_charged` decimal(10,2) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pdf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` enum('Complete','Work in Progress') DEFAULT 'Work in Progress',
  PRIMARY KEY (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `name`, `contact_info`, `services_required`, `projected_completion_date`, `amount_charged`, `image`, `pdf`, `status`) VALUES
(2, 'Dennis Maina', '0712345600', 'Dashboard UI Redesign', '2024-06-30', 199990.00, 'uploads/Male.jpg', '', 'Complete'),
(3, ' Wairimu Maina', '0768124000', 'UI/UX Audit', '2024-06-29', 90000.00, 'uploads/b.jpg', 'uploads/WebDesignRateCard.pdf', 'Work in Progress'),
(10, 'Brenda W. Mwangi', '0719870608', 'Brand Strategy', '2025-10-15', 500000.00, 'uploads/b.jpg', 'uploads/WebDesignRateCard.pdf', 'Complete'),
(6, 'Jackie N. Mwangi', '0714534877', 'Web App Design', '2024-12-16', 129000.00, 'uploads/b.jpg', '', 'Complete'),
(7, 'Stella W. Mwangi', '0729629190', 'Product Redesign', '2025-04-04', 500000.00, 'uploads/b.jpg', '', 'Work in Progress'),
(8, 'Veronicah M.', '0721839075', 'Branding Campaign', '2025-09-12', 400000.00, 'uploads/b.jpg', 'uploads/WebDesignRateCard.pdf', 'Work in Progress'),
(9, 'Patrick J. Maina', '0794339580', 'UX Audit', '2024-08-15', 65000.00, 'uploads/Male.jpg', '', 'Complete'),
(23, 'Obadia', '0700666991', 'Website Audit', '2025-02-05', 900000.00, 'uploads/images/b.jpg', 'uploads/pdfs/WebDesignRateCard.pdf', 'Complete'),
(24, 'Angie N. Wanjiruu', '0720072023', 'UX Audit', '2024-06-05', 60000.00, 'uploads/b.jpg', '', 'Work in Progress');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `department_id` int NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`) VALUES
(1, 'Product Manager'),
(2, 'Project Manager'),
(3, 'Technical Product Manager'),
(4, 'Associate Product Manager'),
(5, 'Product Marketing Manager');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `title`, `description`, `start_datetime`, `end_datetime`, `location`, `created_at`) VALUES
(6, 'Pound Town', 'Fluid Change &amp; Lubrication', '2024-06-24 03:59:00', '2024-06-29 08:00:00', 'My Place', '2024-06-05 23:00:16'),
(5, 'Product Review and Feedback Session', 'In this monthly session, we will review the performance of our current products, gather feedback from stakeholders, and discuss potential enhancements and updates. It&#039;s an opportunity for cross-functional teams to collaborate and align on product goals and priorities.', '2024-06-12 15:40:00', '2024-06-06 06:40:00', 'Zoom', '2024-06-05 22:35:58'),
(7, 'Director Meeting', 'Brief on the state of affairs', '2024-06-06 04:03:00', '2024-06-19 02:03:00', 'Google meet', '2024-06-05 23:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

DROP TABLE IF EXISTS `technicians`;
CREATE TABLE IF NOT EXISTS `technicians` (
  `tech_id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `contract_length` int DEFAULT NULL,
  `wages` decimal(10,2) DEFAULT NULL,
  `overtime_hours` int DEFAULT NULL,
  `documents` varchar(255) DEFAULT NULL,
  `status` enum('Active','On Leave') NOT NULL,
  `department_id` int DEFAULT NULL,
  PRIMARY KEY (`tech_id`),
  KEY `department_id` (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`tech_id`, `image`, `full_name`, `contract_length`, `wages`, `overtime_hours`, `documents`, `status`, `department_id`) VALUES
(20, 'uploadsb.jpg', 'Irene Wanjiru', 30, 10000.00, 12, 'uploads/documents/WebDesignRateCard.pdf', 'On Leave', 4),
(15, 'uploadsM - Copy.jpg', 'Ss Kigongi', 60, 100000.00, 5, '', 'On Leave', 3),
(16, 'uploads/M - Copy.jpg', 'Sam Johnstone', 60, 12000.00, 12, 'uploads/WebDesignRateCard.pdf', 'On Leave', 1),
(17, 'uploads/b.jpg', 'Harriet Aoko', 60, 44000.00, 3, 'uploads/WebDesignRateCard.pdf', 'Active', 2),
(21, 'uploadsMale.jpg', 'Jane Doe', 12, 129000.00, 8, 'uploads/documents/WebDesignRateCard.pdf', 'On Leave', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`) VALUES
(65, 'Stringer', 'stringerbell@gmail.com', '123456'),
(64, 'Umar', 'umar@gmail.com', '123456'),
(20, 'acartmael6', 'dbrickell6@utexas.edu', 'jN1|r@}Nql#u'),
(21, 'drusling7', 'sartrick7@sciencedirect.com', 'yZ8cE0L7y'),
(22, 'dmcgonnell8', 'kdowle8@ehow.com', 'bO3,37IfW}(('),
(23, 'wpheazey9', 'ahaliburn9@wordpress.org', 'cO7/jngWmOTU'),
(24, 'rratnagea', 'cshowera@imgur.com', 'bI3+#)\'.'),
(25, 'isutcliffeb', 'lhandoverb@toplist.cz', 'bC5{KanMb+,dK4e'),
(28, 'froyanse', 'jbordise@goo.ne.jp', 'wU4>|iukSXL'),
(29, 'spettf', 'fgisburnf@blogspot.com', 'aN4)u$vB'),
(30, 'dpaxfordeg', 'cbasinigazzig@edublogs.org', 'tB1.mTLH3MA3bu'),
(31, 'qshakshafth', 'asjostromh@sbwire.com', 'iW9%Sx{#i!\"'),
(32, 'ppontini', 'ilevingsi@theatlantic.com', 'sT6)GH@)'),
(33, 'hroiznj', 'tmeechanj@amazon.co.jp', 'rF1~%>kL?f$DdMq'),
(34, 'dgonzalvok', 'nstrondk@canalblog.com', 'pL7a+XgP.gS'),
(35, 'cancliffel', 'mallabartonl@theglobeandmail.com', 'nK2$eiZXz,KV'),
(36, 'nsesonm', 'pgebuhrm@mashable.com', 'pI0@K8&rwMXXPWy'),
(37, 'ainnocentin', 'cwintonn@themeforest.net', 'nR5|l&$SJJw39z&'),
(38, 'mcoveyo', 'spitkeathleyo@cdc.gov', 'mD9!&r!yBC>'),
(39, 'ghardeyp', 'cbourtonp@soundcloud.com', 'tI1{~H<_5@7i'),
(40, 'lduddleq', 'mjakobssonq@netscape.com', 'vO9&4<d2'),
(41, 'jgentilr', 'sshreenanr@addthis.com', 'jI2)#**5'),
(42, 'cburwoods', 'ugerhtss@infoseek.co.jp', 'cR5/Qx`v.L'),
(43, 'jkeelinget', 'rduket@scribd.com', 'vY1|HFLP{\"`8'),
(44, 'lmingusu', 'znesteru@about.com', 'tQ4%}B#j|JK\"+1'),
(45, 'vpipkinv', 'hcardov@netvibes.com', 'dM8!(dZ{}>E}b<l_'),
(46, 'aculwenw', 'sochterloniew@nytimes.com', 'nA9#\".18kC|ei'),
(47, 'rmushrowx', 'aduckerx@spotify.com', 'vL3/ycj,e}m4'),
(48, 'tdoagy', 'cbaystony@netlog.com', 'xQ0%=3\'Y'),
(49, 'byedyz', 'eerettz@ted.com', 'gT2~\"_CYH'),
(50, 'ggullen10', 'ntrott10@privacy.gov.au', 'kO8@mapS7%ceij_'),
(51, 'sgascard11', 'chusher11@canalblog.com', 'xB3`|y(XjTI9'),
(52, 'kduignan12', 'jgegg12@creativecommons.org', 'dW0\"FG|n@nW|O>+'),
(53, 'ledel13', 'cgregersen13@shareasale.com', 'pM2<=bart'),
(54, 'btrayes14', 'ccorr14@upenn.edu', 'mR0.#8vlfH'),
(55, 'atrase15', 'scampanelle15@techcrunch.com', 'gJ2!EEjP9Fm=GL'),
(56, 'iwickstead16', 'ksyfax16@gravatar.com', 'xQ1=j%`r6'),
(57, 'mduckering17', 'tselkirk17@ehow.com', 'cN0%5(jvah_GZM'),
(58, 'cvilla18', 'irawet18@chicagotribune.com', 'uC7)Ey%1CDLfN'),
(59, 'hcorsham19', 'dweatherup19@patch.com', 'aL0.qepejRNjW_\''),
(60, 'glegier1a', 'hmerrilees1a@so-net.ne.jp', 'nV0>@,%<'),
(61, 'bhoffner1b', 'sreaman1b@imageshack.us', 'jH6<,.VS');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
