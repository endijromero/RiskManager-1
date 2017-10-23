-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th10 22, 2017 lúc 11:28 AM
-- Phiên bản máy phục vụ: 10.1.25-MariaDB
-- Phiên bản PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `risk_manager_real`
--
CREATE DATABASE IF NOT EXISTS `risk_manager_real` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `risk_manager_real`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `agents`
--

DROP TABLE IF EXISTS `agents`;
CREATE TABLE IF NOT EXISTS `agents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8 NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `type` varchar(20) DEFAULT 'person',
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `agents`
--

INSERT INTO `agents` (`id`, `code`, `name`, `description`, `type`, `createdAt`, `deleted`) VALUES
(9, 'M01', 'Hoàng văn Thịnh', 'Sinh 1968, học vấn: Thạc sĩ, kinh nghiệm: 10 năm QLDA', 'person', '2017-10-14 04:07:14', 0),
(10, 'M02', 'Lê Viết Huy', 'Sinh : 1976, học vấn: Đại học, kinh nghiệm 3 năm QLDA', 'person', '2017-10-14 04:07:14', 0),
(11, 'M03', 'Vũ Văn Khánh', 'Sinh : 1978, học vấn: Đại học, kinh nghiệm 5 năm QLDA', 'person', '2017-10-14 04:07:14', 0),
(12, 'M04', 'Vũ Văn Khiêm', 'Sinh : 1976, học vấn: Đại học, kinh nghiệm 5 năm QLDA', 'person', '2017-10-14 04:07:15', 0),
(13, 'M05', 'Trần THị Nhàn', 'Sinh : 1975, học vấn: Đại học, kinh nghiệm 7 năm QLDA', 'person', '2017-10-14 04:07:15', 0),
(14, 'M06', 'Vũ Thanh Hải', 'Sinh : 1970, học vấn: Đại học, kinh nghiệm 10 năm QLDA', 'person', '2017-10-14 04:07:15', 0),
(15, 'M07', 'Nguyễn Minh Hằng', 'Sinh : 1980, học vấn: Đại học, kinh nghiệm 3 năm QLDA', 'person', '2017-10-14 04:07:15', 0),
(16, 'M08', 'Nguyễn Thị Loan', 'Sinh : 1978, học vấn: Đại học, kinh nghiệm 5 năm QLDA', 'person', '2017-10-14 04:07:15', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ci_migrations`
--

DROP TABLE IF EXISTS `ci_migrations`;
CREATE TABLE IF NOT EXISTS `ci_migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `ci_migrations`
--

INSERT INTO `ci_migrations` (`version`) VALUES
(20170428173500);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `conflicts`
--

DROP TABLE IF EXISTS `conflicts`;
CREATE TABLE IF NOT EXISTS `conflicts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `method_1_id` int(11) NOT NULL,
  `method_2_id` int(11) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `method_1_id` (`method_1_id`),
  KEY `method_2_id` (`method_2_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `conflicts`
--

INSERT INTO `conflicts` (`id`, `project_id`, `method_1_id`, `method_2_id`, `code`, `name`, `description`, `createdAt`, `deleted`) VALUES
(1, 2, 9, 10, 'CF12', NULL, NULL, '2017-10-14 08:09:05', 0),
(2, 2, 12, 14, 'CF46', NULL, NULL, '2017-10-14 08:10:04', 0),
(3, 2, 9, 16, 'CF18', NULL, NULL, '2017-10-15 13:38:21', 0),
(4, 2, 11, 13, 'CF35', NULL, NULL, '2017-10-17 15:50:39', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `fitness`
--

DROP TABLE IF EXISTS `fitness`;
CREATE TABLE IF NOT EXISTS `fitness` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `risk` int(11) DEFAULT NULL,
  `method` int(11) DEFAULT NULL,
  `financial_impact` int(11) DEFAULT NULL,
  `risk_level` int(11) DEFAULT NULL,
  `cost` int(11) NOT NULL,
  `diff` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `fitness`
--

INSERT INTO `fitness` (`id`, `project_id`, `risk`, `method`, `financial_impact`, `risk_level`, `cost`, `diff`, `priority`, `time`, `createdAt`, `deleted`) VALUES
(1, 2, 40, 60, 80, 20, 40, 30, 10, 20, '2017-10-07 15:34:22', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `goals`
--

DROP TABLE IF EXISTS `goals`;
CREATE TABLE IF NOT EXISTS `goals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8 NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `goal_type_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `parent_goal_id` int(11) DEFAULT NULL,
  `goal_level` varchar(20) NOT NULL DEFAULT 'Medium',
  `description` text CHARACTER SET utf8 NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `category_id` (`goal_type_id`),
  KEY `parent_goal_id` (`parent_goal_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `goals`
--

INSERT INTO `goals` (`id`, `code`, `name`, `goal_type_id`, `project_id`, `parent_goal_id`, `goal_level`, `description`, `createdAt`, `deleted`) VALUES
(2, 'G001', 'Chuẩn bị tốt công tá', 2, 2, NULL, 'High', 'XD nhiệm vụ quy hoạch của DA, phê duyệt, XD hồ sơ thiết kế cơ sở, phê duyệt thiết kế cơ sở, thực hiện tốt công tác thiết kế kỹ thuật, thiết kế kỹ thuật thi công', '2017-10-14 04:48:25', 0),
(3, 'G002', 'Thực hiện thi công m', 3, 2, NULL, 'High', 'Thực hiện khoan nhồi, đổ bê tông tường vây, gia cố...', '2017-10-14 04:48:25', 0),
(4, 'G003', 'Thực hiện thi công p', 2, 2, NULL, 'Low', 'Đổ trụ cột, dầm, sàn, tường bao, vách ngăn...', '2017-10-14 04:48:25', 0),
(5, 'G004', 'Hoàn thiện xây lắp', 2, 2, NULL, 'High', 'Hoàn thiện chát, cửa, ốm, lát...', '2017-10-14 04:48:25', 0),
(6, 'G005', 'XD hệ thống điện ', 2, 2, NULL, 'Low', 'Gồm các trạm, đường dây, cao hạ thế, thiết bị chiếu sáng...', '2017-10-14 04:48:25', 0),
(7, 'G006', 'Thực hiện thi công t', 2, 2, NULL, 'Medium', 'Âm thanh, truyền hình gồm đường dây và các thiết bị', '2017-10-14 04:48:25', 0),
(8, 'G007', 'Thực hiện thi công X', 3, 2, NULL, 'Low', 'XD các đường ống, thiết bị cấp thoát nước, bể chứa, bể lọc....', '2017-10-14 04:48:25', 0),
(9, 'G008', 'XD hoàn thiện các Hệ', 3, 2, NULL, 'Extreme', 'Hệ thống camera, hệ thống kiểm soát hệ thống quản lý tòa nhà...', '2017-10-14 04:48:25', 0),
(10, 'G009', 'Thực hiện thi công  ', 2, 2, NULL, 'Medium', 'hệ thống báo cháy, hệ thống chữa cháy, chỉ dẫn thoát nạn, chiếu sáng sự cố', '2017-10-14 04:48:25', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `goal_categories`
--

DROP TABLE IF EXISTS `goal_categories`;
CREATE TABLE IF NOT EXISTS `goal_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8 NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `goal_categories`
--

INSERT INTO `goal_categories` (`id`, `code`, `name`, `description`, `createdAt`, `deleted`) VALUES
(2, 'HG', 'Hard Goal', 'Mục tiêu cứng, bắt buộc phải hoàn thành.', '2017-10-13 15:25:16', 0),
(3, 'SG', 'Soft Goal', 'Mục tiêu mềm, không nhất thiết phải hoàn thành.', '2017-10-13 17:52:30', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ion_groups`
--

DROP TABLE IF EXISTS `ion_groups`;
CREATE TABLE IF NOT EXISTS `ion_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `deleted` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `ion_groups`
--

INSERT INTO `ion_groups` (`id`, `name`, `description`, `deleted`) VALUES
(1, 'admin', 'Administrator', 0),
(2, 'develop', 'Develop', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ion_login_attempts`
--

DROP TABLE IF EXISTS `ion_login_attempts`;
CREATE TABLE IF NOT EXISTS `ion_login_attempts` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL,
  `deleted` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ion_users_groups`
--

DROP TABLE IF EXISTS `ion_users_groups`;
CREATE TABLE IF NOT EXISTS `ion_users_groups` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL,
  `deleted` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `ion_users_groups`
--

INSERT INTO `ion_users_groups` (`id`, `user_id`, `group_id`, `deleted`) VALUES
(1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `methods`
--

DROP TABLE IF EXISTS `methods`;
CREATE TABLE IF NOT EXISTS `methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `risk_id` int(11) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `cost` int(11) NOT NULL DEFAULT '0',
  `diff` int(5) NOT NULL DEFAULT '0',
  `priority` int(5) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `responsible_agent_id` int(11) DEFAULT NULL,
  `action_status` varchar(11) DEFAULT 'Created',
  `risk_status` varchar(11) DEFAULT 'Identified ',
  `description` text,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `risk_id` (`risk_id`),
  KEY `responsible_agent_id` (`responsible_agent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `methods`
--

INSERT INTO `methods` (`id`, `risk_id`, `code`, `name`, `cost`, `diff`, `priority`, `time`, `responsible_agent_id`, `action_status`, `risk_status`, `description`, `createdAt`, `deleted`) VALUES
(9, 1, 'PT1', 'Risk Mitigation', 96000, 9, 9, 26, 9, 'Created', 'Identified ', 'Yêu cầu nhà thầu bổ sung thiết bị và thay thế các thiết bị lạc hậu, tăng nhân lực, tăng ca, trình độ chuyên môn \nthay thế cán bộ quản lý yếu kém, đảm bảo cung ứng vật tư, vật liệu tốt, hoặc thay thế nhà thầu khác có năng lực tốt hơn.', '2017-10-14 07:59:08', 0),
(10, 2, 'PT2', 'Risk Mitigation', 11000, 3, 9, 10, 10, 'Created', 'Identified ', 'Tự tổ chức các lực lượng thường trực trong các ngày mưa bão, huy động lực lượng làm tăng ca bù vào cho các ngày mưa bão...', '2017-10-14 07:59:08', 0),
(11, 3, 'PT3', 'Enhance', 88000, 6, 4, 47, 11, 'Created', 'Identified ', ' Tạm dừng chi phí cho các dự án chưa cần thiết khác, lên kế hoạch để huy động nguồn vốn trong các đơn vị, hoặc ngân hàng, thương thảo khách hàng đầu tư trước....', '2017-10-14 07:59:08', 0),
(12, 4, 'PT4', 'Risk Mitigation', 32000, 8, 3, 11, 12, 'Created', 'Identified ', 'Thay thế các cán bộ giám sát hoặc thay đổi hẳn đơn vị tư vấn giám sát có năng lực hơn.....', '2017-10-14 07:59:08', 0),
(13, 5, 'PT5', 'Risk Mitigation', 20000, 9, 3, 70, 13, 'Created', 'Identified ', 'Tăng cường công tác truyền thông quảng bá, phân tích đánh giá ưu việt của dự án để khách hàng đồng ý với giá dự kiến ban đầu', '2017-10-14 07:59:08', 0),
(14, 6, 'PT6', 'Risk Mitigation', 99000, 2, 2, 46, 14, 'Created', 'Identified ', 'Thuê các đơn vị bảo vệ chuyên nghiệp, ký kết bảo hiểm, yêu cầu trình thể trước khi ra vào cổng...', '2017-10-14 07:59:08', 0),
(15, 7, 'PT7', 'Risk Mitigation', 99000, 0, 1, 85, 15, 'Created', 'Identified ', 'Đề nghị các nhà thầu phải học tập các nội quy an toàn PCCC và học tập các lớp huấn luyện của công an PCCC hướng dẫn', '2017-10-14 07:59:08', 0),
(16, 8, 'PT8', 'Risk Mitigation', 70000, 5, 4, 20, 16, 'Created', 'Identified ', 'Học tập phổ biến nội quy an toàn, an ninh lao động trên công trường...', '2017-10-14 07:59:08', 0),
(17, 8, 'PT9', 'Risk Mitigation', 1000, 9, 9, 4, 9, 'Created', 'Identified', 'no des', '2017-10-15 13:09:09', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `finished` int(11) DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `projects`
--

INSERT INTO `projects` (`id`, `user_id`, `code`, `name`, `description`, `createdAt`, `finished`, `deleted`) VALUES
(2, 1, 'P001', 'TTVP căn hộ cao cấp The manor', 'Địa điểm XD: HN\r\nDiện tích: 4 ha\r\nThời gian XD: 3 năm\r\nSố lượng: 500 căn hộ\r\nVốn đâu tư: 70 USD\r\nGiá bán: 900 USD /1m2\r\nCác hạng chính: XD phần thô, phần ngầm, hoàn thiện,\r\nLắp đặt các hạng mục: cơ điện, An ninh, An toàn\r\nTrang thiết bị nội ngoại thất, sân vườn', '2017-10-05 14:21:22', 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `remarks`
--

DROP TABLE IF EXISTS `remarks`;
CREATE TABLE IF NOT EXISTS `remarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `risk_id` int(11) NOT NULL,
  `remark` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `risk-goal`
--

DROP TABLE IF EXISTS `risk-goal`;
CREATE TABLE IF NOT EXISTS `risk-goal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8 NOT NULL,
  `risk_id` int(11) NOT NULL,
  `goal_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `goal_id` (`goal_id`),
  KEY `risk_id` (`risk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `risk-goal`
--

INSERT INTO `risk-goal` (`id`, `code`, `risk_id`, `goal_id`, `project_id`, `description`, `createdAt`, `deleted`) VALUES
(1, 'RG001', 2, 3, 2, 'no description', '2017-10-17 15:49:40', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `riskfactor-riskevent`
--

DROP TABLE IF EXISTS `riskfactor-riskevent`;
CREATE TABLE IF NOT EXISTS `riskfactor-riskevent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8 NOT NULL,
  `risk_id` int(11) NOT NULL,
  `risk_factor_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `risk_id` (`risk_id`),
  KEY `risk_factor_id` (`risk_factor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `riskfactor-riskevent`
--

INSERT INTO `riskfactor-riskevent` (`id`, `code`, `risk_id`, `risk_factor_id`, `project_id`, `description`, `createdAt`, `deleted`) VALUES
(1, 'RR001', 5, 4, 2, 'no description', '2017-10-17 15:46:49', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `risks`
--

DROP TABLE IF EXISTS `risks`;
CREATE TABLE IF NOT EXISTS `risks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `risk_type_id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `financial_impact` int(11) DEFAULT NULL,
  `risk_level` varchar(20) DEFAULT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `risk_type_id` (`risk_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `risks`
--

INSERT INTO `risks` (`id`, `project_id`, `risk_type_id`, `code`, `name`, `description`, `financial_impact`, `risk_level`, `createdAt`, `deleted`) VALUES
(1, 2, 20, 'A01', 'Tiến độ thi công', 'Do nhà thầu không đủ nhân lực, máy móc, tài chính', 2000000, 'Medium', '2017-10-14 05:14:39', 0),
(2, 2, 19, 'A02', 'Thiên tai', 'Thời tiết, bão, lụt, động đất', 3000000, 'Extreme', '2017-10-14 05:14:39', 0),
(3, 2, 15, 'A03', 'Vốn đầu tư', 'Thiếu vốn', 4000000, 'Extreme', '2017-10-14 05:14:40', 0),
(4, 2, 18, 'A04', 'chất lượng công trìn', 'Thiết bị máy móc yếu kém, công nghệ lạc hậu', 5000000, 'Medium', '2017-10-14 05:14:40', 0),
(5, 2, 25, 'A05', 'Giá bán căn hộ', 'dự kiến 18000 USD', 9000000, 'Medium', '2017-10-14 05:14:40', 0),
(6, 2, 23, 'A06', 'Phá hoai', 'Thù địch', 3000000, 'Extreme', '2017-10-14 05:14:40', 0),
(7, 2, 15, 'A07', 'Cháy nổ', 'Cháy các thiết bị máy thi công, thiết bị vật tư, vật liệu lắp đặt cho công trình', 1500000, 'High', '2017-10-14 05:14:40', 0),
(8, 2, 25, 'A08', 'Tai nạn', 'Tai Nạn lao động', 300000, 'Medium', '2017-10-14 05:14:40', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `risk_factors`
--

DROP TABLE IF EXISTS `risk_factors`;
CREATE TABLE IF NOT EXISTS `risk_factors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8 NOT NULL,
  `name` varchar(11) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `project_id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `risk_factors`
--

INSERT INTO `risk_factors` (`id`, `code`, `name`, `description`, `project_id`, `createdAt`, `deleted`) VALUES
(3, 'T01', 'Tiến độ thi', 'Chậm tiến độ: Do điều kiện thi công, phương tiện tham gia thi công kém lạc hậu không đủ, lạc hậu, LL tham gia thi công thiếu, trình độ chuyên môn kém; trình độ quản trị của các ký sư yếu kém, cung cấp VTVL không kịp thời...', 2, '2017-10-14 04:54:01', 0),
(4, 'T02', 'Thiên tai', 'Do động đất, mưa bão', 2, '2017-10-14 04:54:01', 0),
(5, 'T03', 'Vốn đầu tư', 'Năng lực tài chính nhà thầu huy động không đủ và kịp thời để chi phí mua nguyên vật liêu, chi phí thi công, máy móc....', 2, '2017-10-14 04:54:01', 0),
(6, 'T04', 'chất lượng ', 'Sử dụng các nguyên vật liệu không đúng chủng loại mẫu mã theo đúng thiết kế đã được phê duyệt, kỹ thuật lắp đặt sai; giám sát thi công không chặt chẽ về vật tư, vật liệu, thiết bị, kiểm định chất lượng...', 2, '2017-10-14 04:54:01', 0),
(7, 'T05', 'Giá bán căn', 'không đạt dự kiến ban đầu: Do khảo sát  nhu cầu của thị trường không kỹ, không lắm bắt được nhu cầu của khách hàng, giá vật liệu tăng....', 2, '2017-10-14 04:54:02', 0),
(8, 'T06', 'Phá hoai', 'Do thù địch hoặc cạnh tranh không lành mạnh....', 2, '2017-10-14 04:54:02', 0),
(9, 'T07', 'Cháy nổ', 'Do bất cẩn về cách thực hiện An ninh, an toàn cháy nổ trong quá trình thi công', 2, '2017-10-14 04:54:02', 0),
(10, 'T08', 'Tai nạn', 'Do không chấp hành đúng nội quy an toàn Lao động', 2, '2017-10-14 04:54:02', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `risk_types`
--

DROP TABLE IF EXISTS `risk_types`;
CREATE TABLE IF NOT EXISTS `risk_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `risk_types`
--

INSERT INTO `risk_types` (`id`, `code`, `name`, `description`, `createdAt`, `deleted`) VALUES
(14, 'CT001', 'Operational Risk', 'Risks of loss due to improper process implementation, failed system or some external events risks. Examples can be Failure to address priority conflicts, Insufficient resources or No proper subject training etc.', '2017-10-14 04:58:52', 0),
(15, 'CT002', 'Schedule Risk', 'Project schedule get slip when project tasks and schedule release risks are not addressed properly. Schedule risks mainly affect on project and finally on company economy and may lead to project failure', '2017-10-14 04:58:52', 0),
(16, 'CT003', 'Budget Risk', 'Wrong budget estimation or Project scope expansion leads to Budget / Cost Risk.  This risk may lead to either a delay in the delivery of the project or sometimes even an incomplete closure of the project.', '2017-10-14 04:58:53', 0),
(17, 'CT004', 'Business Risk', 'Non-availability of contracts or purchase order at the start of the project or delay in receiving proper inputs from the customer or business analyst may lead to business risks.', '2017-10-14 04:58:53', 0),
(18, 'CT005', 'Technical Environment Risk', 'These are the risks related to the environment under which both the client and the customer work. For example, constantly changing development or production  or testing environment can lead to this risk.', '2017-10-14 04:58:53', 0),
(19, 'CT006', 'Information Security Risk', 'The risks related to the security of information like confidentiality or integrity of customer’s personal / business data. The Access rights / privileges failure will lead to leakage of confidential data.', '2017-10-14 04:58:53', 0),
(20, 'CT007', 'Programmatic Risks', 'The external risks beyond the operational limits. These are outside the control of the program. These external events can be Running out of fund or Changing customer product strategy and priority or Government rule changes etc.', '2017-10-14 04:58:53', 0),
(21, 'CT008', 'Infrastructure Risk', 'Improper planning of infrastructure / resources may lead to risks related to slow network connectivity or complete failure of connectivity at both the client and the customer sites. So, it is important to do proper planning of infrastructure for the efficient development of a project.', '2017-10-14 04:58:53', 0),
(22, 'CT009', 'Quality and Process Risk', 'This risk occures due to\n1.Incorrect application of process tailoring and deviation guidelines\n2.New employees allocated to the project not trained in the quality processes and procedures adopted by the organization', '2017-10-14 04:58:53', 0),
(23, 'CT010', 'Resource Risk', 'This risk depends on factors like Schedule, Staff, Budget and Facilities. Improper management of any of these factors leads to resource risk.', '2017-10-14 04:58:53', 0),
(24, 'CT011', 'Supplier Risk', 'This type of risk may occurs when some third party supplier is involved in the development of the project. This risk occurs due to the uncertain or inadequate capability of supplier.', '2017-10-14 04:58:53', 0),
(25, 'CT012', 'Technology Risk', 'It is related to the complete change in technology or introduction of a new technology.', '2017-10-14 04:58:53', 0),
(26, 'CT013', 'Technical and Architectural Ri', 'These types of risks generally generally leads to failure of functionality and performance. It addresses the hardware and software tools & supporting equipments used in the project. The risk for this category may be due to — Capacity, Suitability, usability, Familiarity, Reliability, System Support and deliverability.', '2017-10-14 04:58:53', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `name`, `password`, `salt`, `email`, `avatar`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `deleted`) VALUES
(1, '127.0.0.1', 'administrator', 'Administrator', '$2a$06$zfgtNV3sB1gzYS6sKgnn9.9ydzb7RhAdYak0Ww/64DfONO6NsG9Q2', '', 'admin@admin.com', NULL, '', NULL, NULL, NULL, 1268889823, 1508253724, 1, 0);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `conflicts`
--
ALTER TABLE `conflicts`
  ADD CONSTRAINT `conflicts_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `conflicts_ibfk_2` FOREIGN KEY (`method_1_id`) REFERENCES `methods` (`id`),
  ADD CONSTRAINT `conflicts_ibfk_3` FOREIGN KEY (`method_2_id`) REFERENCES `methods` (`id`);

--
-- Các ràng buộc cho bảng `fitness`
--
ALTER TABLE `fitness`
  ADD CONSTRAINT `fitness_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Các ràng buộc cho bảng `goals`
--
ALTER TABLE `goals`
  ADD CONSTRAINT `goals_ibfk_1` FOREIGN KEY (`goal_type_id`) REFERENCES `goal_categories` (`id`),
  ADD CONSTRAINT `goals_ibfk_2` FOREIGN KEY (`parent_goal_id`) REFERENCES `goals` (`id`),
  ADD CONSTRAINT `goals_ibfk_3` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Các ràng buộc cho bảng `methods`
--
ALTER TABLE `methods`
  ADD CONSTRAINT `methods_ibfk_1` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`),
  ADD CONSTRAINT `methods_ibfk_2` FOREIGN KEY (`responsible_agent_id`) REFERENCES `agents` (`id`);

--
-- Các ràng buộc cho bảng `risk-goal`
--
ALTER TABLE `risk-goal`
  ADD CONSTRAINT `risk-goal_ibfk_1` FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`),
  ADD CONSTRAINT `risk-goal_ibfk_2` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`);

--
-- Các ràng buộc cho bảng `riskfactor-riskevent`
--
ALTER TABLE `riskfactor-riskevent`
  ADD CONSTRAINT `riskfactor-riskevent_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `riskfactor-riskevent_ibfk_2` FOREIGN KEY (`risk_id`) REFERENCES `risks` (`id`),
  ADD CONSTRAINT `riskfactor-riskevent_ibfk_3` FOREIGN KEY (`risk_factor_id`) REFERENCES `risk_factors` (`id`);

--
-- Các ràng buộc cho bảng `risks`
--
ALTER TABLE `risks`
  ADD CONSTRAINT `risks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `risks_ibfk_2` FOREIGN KEY (`risk_type_id`) REFERENCES `risk_types` (`id`);

--
-- Các ràng buộc cho bảng `risk_factors`
--
ALTER TABLE `risk_factors`
  ADD CONSTRAINT `risk_factors_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
