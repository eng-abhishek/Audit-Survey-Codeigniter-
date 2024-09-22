-- Adminer 4.7.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `survey_template_question_options`;
CREATE TABLE `survey_template_question_options` (
  `id` int NOT NULL AUTO_INCREMENT,
  `template_id` int NOT NULL,
  `template_question_id` int NOT NULL,
  `value` text NOT NULL,
  `is_alert_notify` tinyint(1) DEFAULT NULL,
  `is_end_notify` tinyint(1) DEFAULT NULL,
  `alert_notes` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `end_audit_notes` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `survey_template_question_options_template_question_id_foreign` (`template_question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `survey_template_questions`;
CREATE TABLE `survey_template_questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `survey_template_id` int NOT NULL,
  `question` text NOT NULL,
  `question_type` enum('Text','Textarea','Email','Number','Dropdown','Datepicker','Checkbox','Radio') NOT NULL DEFAULT 'Text',
  `is_required` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `survey_template_questions_survey_template_id_foreign` (`survey_template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `survey_templates`;
CREATE TABLE `survey_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_by` int NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `survey_templates_audit`;
CREATE TABLE `survey_templates_audit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `field_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `before_value_string` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `after_value_string` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- 2021-10-15 16:02:22
