SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `zs1quiz` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `zs1quiz`;

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(8) DEFAULT NULL,
  `correctAnswers` int(11) DEFAULT 1,
  `contents` varchar(512) DEFAULT NULL,
  `answer1` varchar(128) DEFAULT NULL,
  `answer2` varchar(128) DEFAULT NULL,
  `answer3` varchar(128) DEFAULT NULL,
  `answer4` varchar(128) DEFAULT NULL,
  `answer5` varchar(128) DEFAULT NULL,
  `answer6` varchar(128) DEFAULT NULL,
  `image` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `questions` (`id`, `category`, `correctAnswers`, `contents`, `answer1`, `answer2`, `answer3`, `answer4`, `answer5`, `answer6`, `image`) VALUES
(1, 'INF_easy', 1, 'Przykład 1', 'Tak', 'Nie', NULL, NULL, NULL, NULL, NULL),
(2, 'INF_easy', 1, 'Przykład 2', '1', '2', '3', '4', NULL, NULL, NULL),
(3, 'INF_easy', 1, 'Przykład 3', '1', '2', '3', '4', NULL, NULL, NULL),
(4, 'INF_easy', 3, 'Przykład 4', '1', '2', '3', '4', '5', '6', NULL),
(5, 'INF_easy', 1, 'Przykład 5', '1', '2', '3', '4', NULL, NULL, NULL);

CREATE TABLE IF NOT EXISTS `scoreboard` (
  `guestID` varchar(128) NOT NULL,
  `groupID` varchar(128) NOT NULL,
  `username` varchar(32) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `startTime` int(11) NOT NULL,
  `finishTime` int(11) NOT NULL DEFAULT 0,
  `score` int(3) DEFAULT NULL,
  `maxScore` int(3) NOT NULL,
  `isDisqualified` int(1) NOT NULL,
  `category` varchar(8) NOT NULL,
  `quizRating` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`guestID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
