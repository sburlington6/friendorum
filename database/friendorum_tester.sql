-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2016 at 04:29 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `friendorum`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `album_name` varchar(50) NOT NULL DEFAULT 'New Album',
  PRIMARY KEY (`album_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`album_id`, `user_id`, `album_name`) VALUES
(21, 21, 'Profile Pictures');

-- --------------------------------------------------------

--
-- Table structure for table `changelog`
--

CREATE TABLE IF NOT EXISTS `changelog` (
  `change_id` int(11) NOT NULL AUTO_INCREMENT,
  `change` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`change_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `changelog`
--

INSERT INTO `changelog` (`change_id`, `change`, `date`) VALUES
(1, 'Created Changelog', '2012-05-09 22:48:46'),
(2, 'user can delete photo albums as long as there are no images in it.', '2012-05-09 22:50:04'),
(5, 'Items added to profile info page\r\n', '2012-05-10 22:22:57'),
(6, 'Users table sortable by headers', '2012-05-11 05:54:45'),
(7, 'New Banner', '2012-05-11 06:45:56'),
(8, 'fixed validation errors on image upload form\r\n', '2012-05-12 07:13:58'),
(9, 'added a simple clock page at <a href="clock.php">gettingsocial.tk/clock.php</a>', '2012-05-12 21:41:28'),
(10, 'new much improved menu system', '2012-05-21 04:53:26'),
(12, 'improved login page', '2012-05-21 07:33:28'),
(13, 'added rss feed to changelog', '2012-05-25 01:26:02'),
(15, 'added more profile information', '2012-05-26 17:24:43'),
(16, 'improved image upload form', '2012-05-27 07:32:30'),
(17, 'improved theme creator <a href="themeMaker.php">theme creator</a>', '2012-05-27 16:41:49'),
(18, 'improved profile info editing (now all on one page)', '2012-06-27 02:56:09'),
(19, 'profile info page improvements', '2012-06-28 20:57:54'),
(20, 'improved the look of the main page (statuses)', '2012-07-06 07:30:51'),
(21, 'Finally made the switch to a .com url!', '2012-07-11 05:20:26');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `faq_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(200) NOT NULL,
  `question_type` varchar(50) NOT NULL,
  `answer` text NOT NULL,
  `need_login` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`faq_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`faq_id`, `question`, `question_type`, `answer`, `need_login`) VALUES
(1, 'What is this site?', 'about', 'gettingsocial started as a forum for a college final and evolved past that into what you see today.', 0),
(2, 'What if I forget my password?', 'help', 'If you forget your password you can go to <a href="passwordReset.php" alt="reset your password">The Password Reset Page</a>, and enter your username to reset your password.', 0),
(3, 'Can I edit the information in my profile?', 'help', 'Yes you can. You just need to go to the <a href="profileedit.php">Profile Edit</a> page.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `user` int(11) NOT NULL,
  `friend` int(11) NOT NULL,
  `pending` tinyint(1) NOT NULL DEFAULT '1',
  `accepted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user`,`friend`),
  KEY `friend` (`friend`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `games_tictactoe`
--

CREATE TABLE IF NOT EXISTS `games_tictactoe` (
  `game_id` int(11) NOT NULL AUTO_INCREMENT,
  `player1` int(11) NOT NULL,
  `player2` int(11) NOT NULL,
  `score1` int(11) NOT NULL DEFAULT '0',
  `score2` int(11) NOT NULL DEFAULT '0',
  `ties` int(11) NOT NULL DEFAULT '0',
  `turn` varchar(1) NOT NULL DEFAULT 'x',
  `plays` varchar(20) NOT NULL DEFAULT '0,0,0,0,0,0,0,0,0',
  `winner` varchar(1) DEFAULT NULL,
  `game_over` varchar(5) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`game_id`),
  KEY `player1` (`player1`),
  KEY `player2` (`player2`),
  KEY `winner` (`winner`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `album_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `caption` varchar(50) DEFAULT NULL,
  `big` varchar(150) NOT NULL,
  `medium` varchar(150) NOT NULL,
  `small` varchar(150) NOT NULL,
  PRIMARY KEY (`image_id`),
  KEY `user_id` (`user_id`),
  KEY `album_id` (`album_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=200 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `image_date`, `album_id`, `user_id`, `caption`, `big`, `medium`, `small`) VALUES
(1, '0000-00-00 00:00:00', NULL, NULL, NULL, '', 'images/default/1.png', 'images/default/small1.png'),
(2, '0000-00-00 00:00:00', NULL, NULL, NULL, '', 'images/default/2.png', 'images/default/small2.png'),
(3, '0000-00-00 00:00:00', NULL, NULL, NULL, '', 'images/default/3.png', 'images/default/small3.png'),
(4, '0000-00-00 00:00:00', NULL, NULL, NULL, '', 'images/default/4.png', 'images/default/small4.png'),
(5, '0000-00-00 00:00:00', NULL, NULL, NULL, '', 'images/default/5.png', 'images/default/small5.png');

-- --------------------------------------------------------

--
-- Table structure for table `image_comments`
--

CREATE TABLE IF NOT EXISTS `image_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  KEY `image_id` (`image_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(50) DEFAULT NULL,
  `comment` text NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`),
  KEY `thread_id` (`thread_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `notifications` int(4) NOT NULL DEFAULT '0',
  `image_id` int(11) NOT NULL,
  `profile_theme_id` int(11) DEFAULT '1',
  `site_theme_id` int(11) DEFAULT '1',
  `user_sig` varchar(200) DEFAULT NULL,
  `age` tinyint(3) DEFAULT NULL,
  `ethnicity` varchar(50) DEFAULT NULL,
  `bmonth` varchar(20) NOT NULL,
  `bday` int(11) NOT NULL,
  `byear` int(11) NOT NULL,
  `interests` text,
  `gender` varchar(20) NOT NULL,
  `interested_in` varchar(10) NOT NULL,
  `relationship` varchar(20) NOT NULL,
  `languages` varchar(20) NOT NULL,
  `location` varchar(100) NOT NULL,
  `website` varchar(200) NOT NULL,
  `quote` text NOT NULL,
  `about` text NOT NULL,
  `college` text,
  `major` text,
  `high_school` text,
  `address` text,
  `phone` varchar(15) DEFAULT NULL,
  `email` text,
  `chat` text,
  `political_view` text,
  `religion` varchar(50) DEFAULT NULL,
  `sports` text,
  `activities` text,
  `games` text,
  `movies` text,
  `tv_shows` text,
  `restaurants` text,
  `food` text,
  `c_l_w` text,
  `p_t_g` text,
  `height` varchar(5) DEFAULT NULL,
  `smoke` varchar(5) DEFAULT NULL,
  `drink` varchar(5) DEFAULT NULL,
  `l_f` varchar(50) DEFAULT NULL,
  `children` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`profile_id`),
  KEY `thread_id` (`user_id`),
  KEY `image_id` (`image_id`),
  KEY `theme` (`profile_theme_id`),
  KEY `site_theme_id` (`site_theme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profile_id`, `visibility`, `user_id`, `notifications`, `image_id`, `profile_theme_id`, `site_theme_id`, `user_sig`, `age`, `ethnicity`, `bmonth`, `bday`, `byear`, `interests`, `gender`, `interested_in`, `relationship`, `languages`, `location`, `website`, `quote`, `about`, `college`, `major`, `high_school`, `address`, `phone`, `email`, `chat`, `political_view`, `religion`, `sports`, `activities`, `games`, `movies`, `tv_shows`, `restaurants`, `food`, `c_l_w`, `p_t_g`, `height`, `smoke`, `drink`, `l_f`, `children`) VALUES
(14, 1, 21, 0, 2, 1, 1, NULL, NULL, NULL, '1', 21, 1965, 'I am not very interesting', '', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `security_questions`
--

CREATE TABLE IF NOT EXISTS `security_questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(200) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `security_questions`
--

INSERT INTO `security_questions` (`question_id`, `question`) VALUES
(1, 'What was your childhood nickname?'),
(2, 'In what city did you meet your spouse/significant other?'),
(3, 'What is the name of your favorite childhood friend? '),
(4, 'What street did you live on in third grade?'),
(5, 'What is your oldest sibling&#146;s birthday month and year? (e.g., January 1900) '),
(6, 'What is the middle name of your oldest child?'),
(7, 'What is your oldest sibling''s middle name?'),
(8, 'What school did you attend for sixth grade?'),
(9, 'What was your childhood phone number including area code? (e.g., 000-000-0000)'),
(10, 'What is your oldest cousin''s first and last name?'),
(11, 'What was the name of your first stuffed animal?'),
(12, 'In what city or town did your mother and father meet? '),
(13, 'Where were you when you had your first kiss? '),
(14, 'What is the first name of the boy or girl that you first kissed?'),
(15, 'What was the last name of your third grade teacher?'),
(16, 'In what city does your nearest sibling live? '),
(17, 'What is your oldest brother&#146;s birthday month and year? (e.g., January 1900) '),
(18, 'What is your maternal grandmother''s maiden name?'),
(19, 'In what city or town was your first job?'),
(20, 'What is the name of the place your wedding reception was held?'),
(21, 'What is the name of a college you applied to but didn''t attend?'),
(22, 'Where were you when you first heard about 9/11?');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`status_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE IF NOT EXISTS `themes` (
  `theme_id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `background_color` varchar(50) NOT NULL,
  `background_img` varchar(150) DEFAULT NULL,
  `nav_bar` varchar(50) NOT NULL,
  `nav_buttons` varchar(50) NOT NULL,
  `nav_curve` varchar(50) NOT NULL,
  `nav_text` varchar(50) NOT NULL,
  `nav_text_hover` varchar(50) NOT NULL,
  `banner_color` varchar(50) NOT NULL,
  `banner_curve` varchar(50) NOT NULL,
  `text_color` varchar(50) NOT NULL,
  `link_color` varchar(50) NOT NULL,
  `link_hover_color` varchar(50) NOT NULL,
  `box_color` varchar(50) NOT NULL,
  `footer_color` varchar(50) NOT NULL,
  PRIMARY KEY (`theme_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`theme_id`, `theme_name`, `user_id`, `background_color`, `background_img`, `nav_bar`, `nav_buttons`, `nav_curve`, `nav_text`, `nav_text_hover`, `banner_color`, `banner_curve`, `text_color`, `link_color`, `link_hover_color`, `box_color`, `footer_color`) VALUES
(1, 'default', NULL, '#A7ADC3', NULL, '#7A809B', '#A7ADC3', '0', '#FFFFFF', '#7A809B', '#7A809B', '0', '#FFFFFF', '#FFFFFF', '#A7ADC3', '#7A809B', '#7A809B\n'),
(2, 'red', NULL, '#FF0700', NULL, '#A60400', '#FF0700', '0', '#FFFFFF', '#A60400', '#A60400', '0', '#FFFFFF', '#FFFFFF', '#FF0700', '#A60400', '#A60400'),
(3, 'blue', NULL, '#1B1BB3', NULL, '#090974', '#1B1BB3', '0', '#FFFFFF', '#090974', '#090974', '0', '#FFFFFF', '#FFFFFF', '#1B1BB3', '#090974', '#090974'),
(4, 'green', NULL, '#244D4D', NULL, '#0A4343', '#244D4D', '0', '#FFFFFF', '#0A4343', '#0A4343', '0', '#FFFFFF', '#FFFFFF', '#244D4D', '#0A4343', '#0A4343'),
(7, 'purple', NULL, '#5F2580', NULL, '#48036F', '#5F2580', '0', '#FFFFFF', '#48036F', '#48036F', '0', '#FFFFFF', '#FFFFFF', '#5F2580', '#48036F', '#48036F'),
(8, 'Fire', NULL, '#FFE700', NULL, '#A60400', '#FFE700', '0', '#FF8E00', '#A60400', '#FF8E00', '0', '#FFFFFF', '#FFFFFF', '#FFE700', '#FF8E00', '#A60400'),
(14, 'Blue,Orange', NULL, '#015965', '', '#A62D00', '#FF4500', '10', '#000000', '#FFFFFF', '#FF4500', '10', '#000000', '#000000', '#FFFFFF', '#03899C', '#A62D00'),
(15, 'Purple,Green', NULL, '#0F6518', '', '#A62D9A', '#1B9E2C', '10', '#000000', '#FFFFFF', '#1B9E2C', '10', '#000000', '#000000', '#FFFFFF', '#772D9C', '#A62D9A');

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE IF NOT EXISTS `thread` (
  `thread_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `topic` varchar(50) NOT NULL,
  `thread_name` varchar(50) NOT NULL,
  `thread_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` varchar(100) DEFAULT NULL,
  `thread_text` text NOT NULL,
  PRIMARY KEY (`thread_id`),
  KEY `topic_id` (`topic`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'guest',
  `password` varchar(150) NOT NULL,
  `question1` int(11) NOT NULL,
  `question2` int(11) NOT NULL,
  `question3` int(11) NOT NULL,
  `answer1` text NOT NULL,
  `answer2` text NOT NULL,
  `answer3` text NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `user_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_log_in` timestamp NULL DEFAULT NULL,
  `last_log_out` timestamp NULL DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `question1` (`question1`),
  KEY `question2` (`question2`),
  KEY `question3` (`question3`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `role`, `password`, `question1`, `question2`, `question3`, `answer1`, `answer2`, `answer3`, `first_name`, `last_name`, `user_date`, `last_log_in`, `last_log_out`, `email`) VALUES
(21, 'tester', 'user', '$6$rounds=5000$8Zy9FNZEz9MQ1nps$w6pWcyBtQCxY.t/Xpzmu2270Jcl8pFPe1ANWXYD.oqrEqAOC4MMETxUqeTEskwM2FWodNg3HzGifSUR0.gg0d1', 1, 2, 4, 'tester', 'testington', 'test drive', 'test', 'test', '2016-01-22 03:26:34', '2016-01-22 03:27:24', NULL, 'test@test.com');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_4` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_3` FOREIGN KEY (`user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friends_ibfk_4` FOREIGN KEY (`friend`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `games_tictactoe`
--
ALTER TABLE `games_tictactoe`
  ADD CONSTRAINT `games_tictactoe_ibfk_1` FOREIGN KEY (`player1`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `games_tictactoe_ibfk_2` FOREIGN KEY (`player2`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `images_ibfk_3` FOREIGN KEY (`album_id`) REFERENCES `albums` (`album_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `image_comments`
--
ALTER TABLE `image_comments`
  ADD CONSTRAINT `image_comments_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`image_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `image_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_3` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`thread_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_10` FOREIGN KEY (`site_theme_id`) REFERENCES `themes` (`theme_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `profile_ibfk_4` FOREIGN KEY (`image_id`) REFERENCES `images` (`image_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `profile_ibfk_6` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profile_ibfk_9` FOREIGN KEY (`profile_theme_id`) REFERENCES `themes` (`theme_id`) ON UPDATE CASCADE;

--
-- Constraints for table `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `themes`
--
ALTER TABLE `themes`
  ADD CONSTRAINT `themes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `thread_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`question1`) REFERENCES `security_questions` (`question_id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`question2`) REFERENCES `security_questions` (`question_id`),
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`question3`) REFERENCES `security_questions` (`question_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
