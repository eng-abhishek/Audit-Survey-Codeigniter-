ALTER TABLE `users`
ADD `organization_name` varchar(255) COLLATE 'utf8_general_ci' NULL AFTER `last_name`,
ADD `billing_address_1` text COLLATE 'utf8_general_ci' NULL AFTER `office_address2`,
ADD `billing_address_2` text COLLATE 'utf8_general_ci' NULL AFTER `billing_address_1`;


ALTER TABLE `users`
ADD `billing_city` varchar(100) COLLATE 'utf8_general_ci' NULL AFTER `billing_address_2`,
ADD `billing_state` varchar(100) COLLATE 'utf8_general_ci' NULL AFTER `billing_city`,
ADD `billing_zipcode` int NULL AFTER `billing_state`,
ADD `website_url` text COLLATE 'utf8_general_ci' NULL AFTER `billing_zipcode`;


ALTER TABLE `users`
ADD `school_destination_id` int NULL AFTER `organization_name`;


ALTER TABLE `invites_register`
ADD `sms_survey_completion` tinyint(1) NOT NULL DEFAULT '0',
ADD `sms_survey_alert` tinyint(1) NOT NULL DEFAULT '0' AFTER `sms_survey_completion`,
ADD `email_survey_completion` tinyint(1) NOT NULL DEFAULT '0' AFTER `sms_survey_alert`,
ADD `email_survey_alert` tinyint(1) NOT NULL DEFAULT '0' AFTER `email_survey_completion`;



ALTER TABLE `invites`
ADD `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'if 1 registration created ' AFTER `active`;



ALTER TABLE `school_destinations` ADD `is_deleted` INT(11) NOT NULL DEFAULT '0' AFTER `is_active`; 
ALTER TABLE `school_districts` CHANGE `is_deleted` `is_deleted` INT(11) NOT NULL DEFAULT '0'; 


ALTER TABLE `users`
ADD `signup_password_selector` varchar(255) COLLATE 'utf8_general_ci' NULL AFTER `forgotten_password_time`,
ADD `signup_password_code` varchar(255) COLLATE 'utf8_general_ci' NULL AFTER `signup_password_selector`,
ADD `signup_password_time` int unsigned NULL AFTER `signup_password_code`;


ALTER TABLE `students`
ADD `flg_bus_nurse` tinyint(1) NULL DEFAULT '0' AFTER `special_transportations`,
ADD `flg_bus_wheelchair` tinyint(1) DEFAULT '0' AFTER `flg_bus_nurse`,
ADD `flg_bus_specialreqs` tinyint(1) DEFAULT '0' AFTER `flg_bus_wheelchair`,
ADD `flg_bus_aide` tinyint(1) DEFAULT '0' AFTER `flg_bus_specialreqs`,
ADD `flg_car_seat_required` tinyint(1) DEFAULT '0' AFTER `flg_bus_aide`,
ADD `flg_harness_required` tinyint(1) DEFAULT '0' AFTER `flg_car_seat_required`,
ADD `flg_bus_specialreqs_desc` tinyint(1) DEFAULT '0' AFTER `flg_harness_required`,
ADD `flg_type_of_chair` tinyint(1) DEFAULT '0' AFTER `flg_bus_specialreqs_desc`,
ADD `flg_carharness_type_size` tinyint(1) DEFAULT '0' AFTER `flg_type_of_chair`;


ALTER TABLE `bus_companies`
ADD `deleted` tinyint NOT NULL DEFAULT '0';

ALTER TABLE `students` ADD `assign_bus_route_status` INT NOT NULL DEFAULT '0'

ALTER TABLE `students`
ADD `is_deleted` tinyint NOT NULL DEFAULT '0';


ALTER TABLE `surveys`
CHANGE `start_date` `start_date` date NOT NULL AFTER `frequency`,
CHANGE `end_date` `end_date` date NOT NULL AFTER `start_date`;


ALTER TABLE `survey_schedule`
ADD `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 - for active and 0- for not active' AFTER `school_destination_id`;


ALTER TABLE `students` ADD `sending_district_code` VARCHAR(100) NULL AFTER `assign_bus_route_status`;

ALTER TABLE `students` CHANGE `sending_district_code` `sending_district_id` INT(11) NULL DEFAULT NULL;

ALTER TABLE `school_calendar` ADD `start_date` DATE NULL AFTER `calender_notes`, ADD `end_date` DATE NULL AFTER `start_date`

ALTER TABLE `school_calendar` ADD `type` ENUM('Holiday','Weekoff') NOT NULL AFTER `user_id`;

ALTER TABLE `school_calendar` CHANGE `type` `type` ENUM('Holiday','Weekoff') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `invites` ADD `is_email_sent` tinyint(1) NOT NULL DEFAULT '0' AFTER `status`;