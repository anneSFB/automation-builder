-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Aug 30, 2016 at 09:17 AM
-- Server version: 5.6.30-log
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `burganic_workflowyii`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_actions`
--

CREATE TABLE IF NOT EXISTS `tbl_actions` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_name` varchar(200) NOT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_actions`
--

INSERT INTO `tbl_actions` (`a_id`, `a_name`) VALUES
(1, 'List of Actions'),
(2, 'Time Delay');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_action_conditions`
--

CREATE TABLE IF NOT EXISTS `tbl_action_conditions` (
  `aec_id` int(11) NOT NULL AUTO_INCREMENT,
  `ae_id` int(11) NOT NULL,
  `aec_label` text NOT NULL,
  `aec_color` varchar(200) NOT NULL,
  `aec_desc` text NOT NULL,
  PRIMARY KEY (`aec_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_action_conditions`
--

INSERT INTO `tbl_action_conditions` (`aec_id`, `ae_id`, `aec_label`, `aec_color`, `aec_desc`) VALUES
(1, 1, 'On Unsubscribe', '80c1d8', ''),
(2, 1, 'On Open', '97d086', ''),
(3, 1, 'On Send', 'eca587', ''),
(4, 1, 'On Click', 'e66e71', ''),
(5, 1, 'On Bounce', 'bd7bcf', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_action_configurations`
--

CREATE TABLE IF NOT EXISTS `tbl_action_configurations` (
  `a_config_id` int(11) NOT NULL AUTO_INCREMENT,
  `ae_id` int(11) NOT NULL,
  `a_config_option` text NOT NULL,
  PRIMARY KEY (`a_config_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbl_action_configurations`
--

INSERT INTO `tbl_action_configurations` (`a_config_id`, `ae_id`, `a_config_option`) VALUES
(1, 1, 'Email Template'),
(2, 1, 'Unsubscribe Email Template'),
(3, 1, 'Newsletter Template'),
(4, 2, 'Admin List'),
(5, 2, 'Member List'),
(6, 3, 'Phonebook contacts'),
(7, 3, 'Social contacts'),
(8, 4, 'Signup Popup');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_action_events`
--

CREATE TABLE IF NOT EXISTS `tbl_action_events` (
  `ae_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_id` int(11) NOT NULL,
  `ae_name` varchar(200) NOT NULL,
  `ae_desc` text NOT NULL,
  `ae_img` text NOT NULL,
  PRIMARY KEY (`ae_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_action_events`
--

INSERT INTO `tbl_action_events` (`ae_id`, `a_id`, `ae_name`, `ae_desc`, `ae_img`) VALUES
(1, 1, 'Send Email', '', 'http://burganic.com/projects/workflow/yii/images/send_email.png'),
(2, 1, 'Add to List', '', 'http://burganic.com/projects/workflow/yii/images/add_to_list.png'),
(3, 1, 'Update Contact', '', 'http://burganic.com/projects/workflow/yii/images/update_contact.png'),
(4, 1, 'Dialog Window', '', 'http://burganic.com/projects/workflow/yii/images/dialog_window.png'),
(5, 1, 'SMS', '', 'http://burganic.com/projects/workflow/yii/images/sms.png'),
(6, 1, 'Remove from List', '', 'http://burganic.com/projects/workflow/yii/images/remove_list.png'),
(8, 2, 'Add Delay', '', 'http://burganic.com/projects/workflow/yii/images/delay.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(200) NOT NULL,
  `c_desc` text NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`c_id`, `c_name`, `c_desc`) VALUES
(1, 'Promotion', ''),
(2, 'Events', ''),
(3, 'Webinars', ''),
(4, 'New Users', 'New Users description'),
(5, 'Landing Page', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tags`
--

CREATE TABLE IF NOT EXISTS `tbl_tags` (
  `wt_id` int(11) NOT NULL,
  `tag` varchar(200) NOT NULL,
  PRIMARY KEY (`wt_id`,`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tags`
--

INSERT INTO `tbl_tags` (`wt_id`, `tag`) VALUES
(17, 'marketing'),
(17, 'promotions'),
(17, 'tags'),
(17, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_triggers`
--

CREATE TABLE IF NOT EXISTS `tbl_triggers` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
  `t_name` varchar(200) NOT NULL,
  PRIMARY KEY (`t_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_triggers`
--

INSERT INTO `tbl_triggers` (`t_id`, `t_name`) VALUES
(1, 'Email'),
(2, 'User'),
(3, 'Time');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trigger_conditions`
--

CREATE TABLE IF NOT EXISTS `tbl_trigger_conditions` (
  `tec_id` int(11) NOT NULL AUTO_INCREMENT,
  `te_id` int(11) NOT NULL,
  `tec_label` text NOT NULL,
  `tec_color` varchar(200) NOT NULL,
  `tec_desc` text NOT NULL,
  PRIMARY KEY (`tec_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_trigger_conditions`
--

INSERT INTO `tbl_trigger_conditions` (`tec_id`, `te_id`, `tec_label`, `tec_color`, `tec_desc`) VALUES
(1, 1, 'Email Opened', '80c1d8', ''),
(2, 1, 'Unsubscribe', 'e66e71', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trigger_configurations`
--

CREATE TABLE IF NOT EXISTS `tbl_trigger_configurations` (
  `t_config_id` int(11) NOT NULL AUTO_INCREMENT,
  `te_id` int(11) NOT NULL,
  `t_config_option` text NOT NULL,
  PRIMARY KEY (`t_config_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_trigger_configurations`
--

INSERT INTO `tbl_trigger_configurations` (`t_config_id`, `te_id`, `t_config_option`) VALUES
(1, 2, 'Sample link one'),
(2, 2, 'Sample link two'),
(3, 2, 'Sample link three'),
(4, 2, 'Sample link four'),
(5, 2, 'Sample link five'),
(6, 1, 'Subscription Email'),
(7, 1, 'Registration Email'),
(8, 3, 'Member List'),
(9, 3, 'Admin List'),
(10, 4, 'Earned 100 points'),
(11, 4, 'Purchased a product'),
(12, 4, 'Upgraded to premium');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trigger_events`
--

CREATE TABLE IF NOT EXISTS `tbl_trigger_events` (
  `te_id` int(11) NOT NULL AUTO_INCREMENT,
  `t_id` int(11) NOT NULL,
  `te_name` varchar(200) NOT NULL,
  `te_desc` text NOT NULL,
  `te_img` text NOT NULL,
  PRIMARY KEY (`te_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_trigger_events`
--

INSERT INTO `tbl_trigger_events` (`te_id`, `t_id`, `te_name`, `te_desc`, `te_img`) VALUES
(1, 1, 'Email Opened', '', 'http://burganic.com/projects/workflow/yii/images/email_opened.png'),
(2, 1, 'Click Linked', '', 'http://burganic.com/projects/workflow/yii/images/click_linked.png'),
(3, 2, 'Sign up to a List', '', 'http://burganic.com/projects/workflow/yii/images/signup_to_list.png'),
(4, 2, 'Goal Achieved', '', 'http://burganic.com/projects/workflow/yii/images/goal_achieved.png'),
(5, 3, 'Specific Date', '', 'http://burganic.com/projects/workflow/yii/images/specific_date.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_workflow`
--

CREATE TABLE IF NOT EXISTS `tbl_workflow` (
  `w_id` int(11) NOT NULL AUTO_INCREMENT,
  `w_name` varchar(200) DEFAULT NULL,
  `w_type` varchar(200) NOT NULL DEFAULT 'workflow',
  `w_desc` text,
  `w_data` longtext,
  `w_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`w_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `tbl_workflow`
--

INSERT INTO `tbl_workflow` (`w_id`, `w_name`, `w_type`, `w_desc`, `w_data`, `w_date`) VALUES
(64, 'Unsubscribe Flow', 'guide', 'The PhoneGap Developer App is a mobile app that runs on devices and allows you to preview and test the PhoneGap mobile apps you build across platforms without additional platform SDK setup...', '{"cells":[{"type":"basic.Triggers","size":{"width":60,"height":60},"position":{"x":620,"y":385},"angle":0,"id":"dcdadc52-0ad5-40a2-a29c-bbd2caa1c000","embeds":"","z":1,"attrs":{".label1":{"text":"Email Opened","databaseid":"1"},".label2":{"text":"Subscription Email","databaseid":"6"},".trigger_img":{"xlink:href":"http://burganic.com/projects/workflow/yii/images/email_opened.png"},".trigger_exclam":{"xlink:href":"http://burganic.com/projects/workflow/yii/plugins/rappid/img/error_icon_hide.png"}}},{"type":"basic.AddDelay","size":{"width":30,"height":30},"position":{"x":1040,"y":400},"angle":0,"id":"1f8e9ec4-9b8a-4440-88d4-b7a59d04475f","embeds":"","z":2,"attrs":{"text":{"text":"Wait  2 days "},".delay_img":{"xlink:href":"http://burganic.com/projects/workflow/yii/images/delay.png"},".delay_exclam":{"xlink:href":"http://burganic.com/projects/workflow/yii/plugins/rappid/img/error_icon_hide.png"}}},{"type":"basic.Actions","size":{"width":60,"height":60},"position":{"x":840,"y":385},"angle":0,"id":"dc75509f-8925-4259-b660-7f519b5b672e","embeds":"","z":3,"attrs":{".label1":{"text":"Remove from List","databaseid":"6"},".action_img":{"xlink:href":"http://burganic.com/projects/workflow/yii/images/remove_list.png"},".action_exclam":{"xlink:href":"http://burganic.com/projects/workflow/yii/plugins/rappid/img/error_icon_hide.png"}}},{"type":"basic.Actions","size":{"width":60,"height":60},"position":{"x":1025,"y":520},"angle":0,"id":"62eb36de-c241-437d-9910-65c8af4e3ce5","embeds":"","z":4,"attrs":{".label1":{"text":"Send Email","databaseid":"1"},".label2":{"text":"Unsubscribe Email Template","databaseid":"2"},".action_img":{"xlink:href":"http://burganic.com/projects/workflow/yii/images/send_email.png"},".action_exclam":{"xlink:href":"http://burganic.com/projects/workflow/yii/plugins/rappid/img/error_icon_hide.png"}}},{"type":"link","source":{"id":"dcdadc52-0ad5-40a2-a29c-bbd2caa1c000"},"target":{"id":"dc75509f-8925-4259-b660-7f519b5b672e"},"id":"5df06426-9259-4a8d-96f1-ffe32493c225","embeds":"","z":5,"labels":[{"position":0.5,"attrs":{"rect":{"fill":"white","stroke":"transparent","stroke-width":20},"text":{"text":" Unsubscribe","font-size":11}}}],"attrs":{".marker-vertices":{"display":"none"},".marker-arrowheads":{"display":"none"},".marker-source":{"d":"M 5 10 A 5 5, 0, 1, 0, 6 10 L 0 15 Z","transform":"scale(0.7)","fill":"#e66e71","stroke":"#e66e71"},".marker-target":{"d":"M 10 0 L 0 5 L 10 10 z","transform":"scale(0.5)","fill":"#d7dde3","stroke":"#d7dde3"},".connection":{"stroke":"#d7dde3","stroke-width":2}}},{"type":"link","source":{"id":"dc75509f-8925-4259-b660-7f519b5b672e"},"target":{"id":"1f8e9ec4-9b8a-4440-88d4-b7a59d04475f"},"id":"3ba6f9e4-ca39-41cc-8ab6-22de5ae3c21c","embeds":"","z":6,"attrs":{".marker-vertices":{"display":"none"},".marker-arrowheads":{"display":"none"},".marker-source":{"d":"M 5 10 A 5 5, 0, 1, 0, 6 10 L 0 15 Z","transform":"scale(0.7)","fill":"#d7dde3","stroke":"#d7dde3"},".marker-target":{"d":"M 10 0 L 0 5 L 10 10 z","transform":"scale(0.5)","fill":"#d7dde3","stroke":"#d7dde3"},".connection":{"stroke":"#d7dde3","stroke-width":2}}},{"type":"link","source":{"id":"1f8e9ec4-9b8a-4440-88d4-b7a59d04475f"},"target":{"id":"62eb36de-c241-437d-9910-65c8af4e3ce5"},"id":"5e883fcd-5f6c-4d18-950f-f502ae67f1b2","embeds":"","z":7,"attrs":{".marker-vertices":{"display":"none"},".marker-arrowheads":{"display":"none"},".marker-source":{"d":"M 5 10 A 5 5, 0, 1, 0, 6 10 L 0 15 Z","transform":"scale(0.7)","fill":"#d7dde3","stroke":"#d7dde3"},".marker-target":{"d":"M 10 0 L 0 5 L 10 10 z","transform":"scale(0.5)","fill":"#d7dde3","stroke":"#d7dde3"},".connection":{"stroke":"#d7dde3","stroke-width":2}}}]}', '2016-08-30 10:46:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_workflowtemplates`
--

CREATE TABLE IF NOT EXISTS `tbl_workflowtemplates` (
  `wt_id` int(11) NOT NULL AUTO_INCREMENT,
  `wt_thumb` text NOT NULL,
  `w_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  PRIMARY KEY (`wt_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tbl_workflowtemplates`
--

INSERT INTO `tbl_workflowtemplates` (`wt_id`, `wt_thumb`, `w_id`, `c_id`) VALUES
(17, 'http://burganic.com/projects/workflow/yii/images/guides/thumb_1472553974.jpg', 64, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
