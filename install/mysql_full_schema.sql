CREATE TABLE `tbl_account_details` (
  `account_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(200) DEFAULT NULL,
  `employment_id` varchar(100) DEFAULT NULL,
  `company` varchar(200) DEFAULT '0',
  `locale` varchar(50) DEFAULT NULL,
  `language` varchar(50) DEFAULT 'english',
  `phone` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `skype` varchar(100) DEFAULT NULL,
  `direction` varchar(10) DEFAULT 'ltr',
  `designations_id` int(11) DEFAULT 0,
  `warehouse_id` int(11) DEFAULT 0,
  `avatar` varchar(255) DEFAULT 'uploads/staff_profile_images/default.jpg',
  `joining_date` date DEFAULT NULL,
  PRIMARY KEY (`account_details_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_accounts` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `balance` decimal(18,2) DEFAULT 0.00,
  `permission` text DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `bank_details` text DEFAULT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_activities` (
  `activities_id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT 0,
  `module` varchar(50) DEFAULT NULL,
  `module_field_id` int(11) DEFAULT 0,
  `activity` varchar(200) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `value1` varchar(255) DEFAULT NULL,
  `value2` varchar(255) DEFAULT NULL,
  `time` timestamp NULL DEFAULT current_timestamp(),
  `activity_date` timestamp NULL DEFAULT current_timestamp(),
  `link` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`activities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_advance_salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_allowed_ip` (
  `allowed_ip_id` int(11) NOT NULL AUTO_INCREMENT,
  `allowed_ip` varchar(100) NOT NULL,
  `status` enum('active','reject','pending') DEFAULT 'pending',
  PRIMARY KEY (`allowed_ip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_announcements` (
  `announcements_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `attachment` text DEFAULT NULL,
  PRIMARY KEY (`announcements_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_assign_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(50) DEFAULT NULL,
  `module_field_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_attachments_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attachments_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0,
  `date_in` date DEFAULT NULL,
  `date_out` date DEFAULT NULL,
  `attendance_status` varchar(20) DEFAULT NULL,
  `leave_application_id` int(11) DEFAULT 0,
  PRIMARY KEY (`attendance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_award_points` (
  `award_points_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_award_point` varchar(100) NOT NULL,
  `user_award_point` varchar(100) NOT NULL,
  `invoices_id` int(11) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `date` varchar(40) NOT NULL,
  PRIMARY KEY (`award_points_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_award_program` (
  `award_program_id` int(11) NOT NULL AUTO_INCREMENT,
  `program_name` varchar(100) NOT NULL,
  `award_rule_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `start_date` varchar(64) NOT NULL,
  `end_date` varchar(64) NOT NULL,
  `description` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`award_program_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_award_rule` (
  `award_rule_id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_name` varchar(200) NOT NULL,
  `date_create` date NOT NULL,
  `client_id` int(11) NOT NULL,
  `award_point_from` varchar(20) NOT NULL,
  `award_point_to` varchar(20) NOT NULL,
  `card` int(11) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`award_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_bug` (
  `bug_id` int(11) NOT NULL AUTO_INCREMENT,
  `bug_title` varchar(200) DEFAULT NULL,
  `bug_status` varchar(50) DEFAULT NULL,
  `permission` text DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `severity` varchar(20) DEFAULT NULL,
  `reproducibility` text DEFAULT NULL,
  `issue_no` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`bug_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_calls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_card_config` (
  `card_config_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `date_create` date DEFAULT NULL,
  `subject_card` int(11) DEFAULT 0,
  `client_name` int(11) DEFAULT 0,
  `membership` int(11) DEFAULT 0,
  `company_name` int(11) DEFAULT 0,
  `member_since` int(11) DEFAULT 0,
  `custom_field` int(11) DEFAULT 0,
  `custom_field_content` varchar(200) DEFAULT NULL,
  `text_color` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`card_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_checklists` (
  `checklist_id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(32) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `finished` int(11) DEFAULT 0,
  `create_datetime` datetime DEFAULT NULL,
  `added_from` int(11) DEFAULT NULL,
  `finished_from` int(11) DEFAULT NULL,
  `list_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`checklist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_client` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `short_name` varchar(100) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `zipcode` varchar(50) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'USD',
  `country` varchar(100) DEFAULT NULL,
  `vat` varchar(100) DEFAULT NULL,
  `permission` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `sms_notification` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_client_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `parent` int(11) DEFAULT 0,
  `sort` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_client_role` (
  `client_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0,
  `menu_id` int(11) DEFAULT 0,
  PRIMARY KEY (`client_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_clock` (
  `clock_id` int(11) NOT NULL AUTO_INCREMENT,
  `attendance_id` int(11) DEFAULT 0,
  `clockin_time` time DEFAULT NULL,
  `clockout_time` time DEFAULT NULL,
  `clocking_status` tinyint(1) DEFAULT 0,
  `latitude` varchar(300) DEFAULT NULL,
  `longitude` varchar(300) DEFAULT NULL,
  `location` text DEFAULT NULL,
  PRIMARY KEY (`clock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_clock_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_config` (
  `config_key` varchar(100) NOT NULL,
  `value` text DEFAULT NULL,
  PRIMARY KEY (`config_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_credit_note` (
  `credit_note_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT 0,
  `credit_note_date` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `credit_note_month` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `credit_note_year` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `currency` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT 'USD',
  `discount_percent` int(2) DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tax` int(11) NOT NULL DEFAULT 0,
  `total_tax` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'open',
  `date_saved` timestamp NOT NULL DEFAULT '2018-12-12 11:00:00',
  `emailed` varchar(11) DEFAULT NULL,
  `permission` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `client_visible` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'No',
  `discount_type` enum('before_tax','after_tax') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT 'sales agent',
  `adjustment` decimal(18,2) NOT NULL DEFAULT 0.00,
  `discount_total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `show_quantity_as` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `tags` text DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`credit_note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_credit_note_items` (
  `credit_note_items_id` int(11) NOT NULL AUTO_INCREMENT,
  `credit_note_id` int(11) NOT NULL,
  `saved_items_id` int(11) DEFAULT 0,
  `item_tax_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `item_tax_name` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `item_name` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT 'Item Name',
  `item_desc` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT 0.00,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `item_tax_total` decimal(10,2) DEFAULT 0.00,
  `total_cost` decimal(10,2) DEFAULT 0.00,
  `date_saved` timestamp NOT NULL DEFAULT '2018-12-12 11:00:00',
  `unit` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `hsn_code` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT 0,
  PRIMARY KEY (`credit_note_items_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_credit_used` (
  `credit_used_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoices_id` int(11) NOT NULL,
  `credit_note_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `date_applied` datetime NOT NULL,
  `amount` decimal(18,3) NOT NULL,
  `payments_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`credit_used_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_currencies` (
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_custom_field` (
  `custom_field_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) DEFAULT 0,
  `field_label` varchar(200) DEFAULT NULL,
  `field_type` varchar(50) DEFAULT 'text',
  `default_value` text DEFAULT NULL,
  `help_text` varchar(255) DEFAULT NULL,
  `required` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `show_on_table` varchar(5) DEFAULT NULL,
  `visible_for_admin` varchar(11) DEFAULT NULL,
  `visible_for_client` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`custom_field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_customer_group` (
  `customer_group_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) DEFAULT NULL,
  `customer_group` varchar(200) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`customer_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_dashboard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `col` varchar(200) DEFAULT NULL,
  `order_no` int(2) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `report` tinyint(1) NOT NULL DEFAULT 0,
  `for_staff` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_days` (
  `day_id` int(11) NOT NULL AUTO_INCREMENT,
  `day` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`day_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_departments` (
  `departments_id` int(11) NOT NULL AUTO_INCREMENT,
  `deptname` varchar(200) DEFAULT NULL,
  `department_head_id` int(11) DEFAULT 0,
  `encryption` varchar(50) DEFAULT NULL,
  `host` varchar(200) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `mailbox` varchar(200) DEFAULT NULL,
  `unread_email` tinyint(1) DEFAULT 0,
  `delete_mail_after_import` tinyint(1) DEFAULT 0,
  `last_postmaster_run` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`departments_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_designations` (
  `designations_id` int(11) NOT NULL AUTO_INCREMENT,
  `departments_id` int(11) DEFAULT 0,
  `designations` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`designations_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_draft` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attach_file` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_email_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_employee_award` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_employee_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `routing_number` varchar(50) DEFAULT NULL,
  `type_of_account` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_employee_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_employee_payroll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_estimate_items` (
  `estimate_items_id` int(11) NOT NULL AUTO_INCREMENT,
  `estimates_id` int(11) DEFAULT 0,
  `total_cost` decimal(18,2) DEFAULT 0.00,
  `order` int(11) DEFAULT 0,
  `unit` varchar(200) DEFAULT NULL,
  `item_tax_name` text DEFAULT NULL,
  `saved_items_id` int(11) DEFAULT 0,
  `hsn_code` text DEFAULT NULL,
  PRIMARY KEY (`estimate_items_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_estimates` (
  `estimates_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(100) DEFAULT NULL,
  `client_id` int(11) DEFAULT 0,
  `status` varchar(50) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `permission` text DEFAULT NULL,
  `discount_percent` int(2) DEFAULT NULL,
  `project_id` int(11) DEFAULT 0,
  `estimate_date` varchar(50) DEFAULT NULL,
  `estimate_month` varchar(20) DEFAULT NULL,
  `estimate_year` varchar(10) DEFAULT NULL,
  `invoices_id` int(11) NOT NULL DEFAULT 0,
  `discount_type` enum('before_tax','after_tax') NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT 'sales agent',
  `adjustment` decimal(18,2) NOT NULL DEFAULT 0.00,
  `discount_total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `show_quantity_as` varchar(20) NOT NULL,
  `total_tax` text DEFAULT NULL,
  `alert_overdue` tinyint(1) NOT NULL DEFAULT 0,
  `tags` text DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`estimates_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_expense_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_form` (
  `form_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_name` varchar(200) DEFAULT NULL,
  `tbl_name` varchar(200) DEFAULT NULL,
  `table_id` varchar(110) DEFAULT NULL,
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_goal_tracking` (
  `goal_tracking_id` int(11) NOT NULL AUTO_INCREMENT,
  `goal_type_id` int(11) DEFAULT 0,
  `account_id` int(11) DEFAULT 0,
  `achievement` decimal(18,2) DEFAULT 0.00,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`goal_tracking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_goal_type` (
  `goal_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`goal_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_holiday` (
  `holiday_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`holiday_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_hourly_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_inbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attach_file` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_income_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_invoices` (
  `invoices_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(100) DEFAULT NULL,
  `client_id` int(11) DEFAULT 0,
  `status` varchar(50) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `permission` text DEFAULT NULL,
  `discount_total` decimal(18,2) DEFAULT 0.00,
  `adjustment` decimal(18,2) DEFAULT 0.00,
  `inv_deleted` varchar(10) DEFAULT 'No',
  `invoice_date` date DEFAULT NULL,
  `project_id` int(11) DEFAULT 0,
  `user_id` int(11) DEFAULT 0,
  `invoice_month` varchar(20) DEFAULT NULL,
  `invoice_year` varchar(10) DEFAULT NULL,
  `recurring` varchar(10) DEFAULT 'No',
  `date_saved` timestamp NULL DEFAULT current_timestamp(),
  `discount_percent` int(2) DEFAULT NULL,
  `show_quantity_as` varchar(20) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `client_visible` varchar(10) DEFAULT 'No',
  `allow_authorize_net` enum('Yes','No') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'No',
  `allow_tappayment` enum('Yes','No') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT 'Yes',
  `recur_start_date` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `recur_end_date` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `discount_type` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'none',
  `total_tax` text DEFAULT NULL,
  `allow_payumoney` enum('Yes','No') DEFAULT 'No',
  `alert_overdue` tinyint(1) NOT NULL DEFAULT 0,
  `allow_razorpay` enum('Yes','No') DEFAULT 'No',
  `warehouse_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`invoices_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_item_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_items` (
  `items_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoices_id` int(11) DEFAULT 0,
  `item_name` varchar(255) DEFAULT NULL,
  `total_cost` decimal(18,2) DEFAULT 0.00,
  `item_tax_total` decimal(18,2) DEFAULT 0.00,
  `order` int(11) DEFAULT 0,
  `item_tax_rate` decimal(18,2) NOT NULL DEFAULT 0.00,
  `quantity` decimal(18,2) DEFAULT 0.00,
  `unit_cost` decimal(18,2) DEFAULT 0.00,
  `unit` varchar(200) DEFAULT NULL,
  `item_tax_name` text DEFAULT NULL,
  `saved_items_id` int(11) DEFAULT 0,
  `hsn_code` text DEFAULT NULL,
  PRIMARY KEY (`items_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_job_appliactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `send_email` varchar(20) DEFAULT NULL,
  `interview_date` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_job_circular` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_kb_category` (
  `kb_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(200) NOT NULL,
  `description` longtext DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `sort` int(2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`kb_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_knowledgebase` (
  `kb_id` int(11) NOT NULL AUTO_INCREMENT,
  `kb_category_id` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `slug` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `attachments` text DEFAULT NULL,
  `for_all` enum('Yes','No') DEFAULT 'No',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `total_view` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sort` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`kb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_languages` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_lead_form` (
  `lead_form_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_key` varchar(32) NOT NULL,
  `form_name` varchar(200) NOT NULL,
  `lead_status_id` int(11) NOT NULL,
  `lead_source_id` int(11) NOT NULL,
  `language` varchar(40) DEFAULT NULL,
  `form_recaptcha` int(11) NOT NULL DEFAULT 0,
  `submit_btn_text` varchar(40) DEFAULT NULL,
  `submit_btn_msg` text DEFAULT NULL,
  `allow_duplicate` int(11) NOT NULL DEFAULT 1,
  `track_duplicate_field` varchar(100) DEFAULT NULL,
  `form_data` mediumtext DEFAULT NULL,
  `notify_lead_imported` int(11) NOT NULL DEFAULT 1,
  `permission` text DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`lead_form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_lead_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_lead_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_leads` (
  `leads_id` int(11) NOT NULL AUTO_INCREMENT,
  `lead_name` varchar(200) DEFAULT NULL,
  `permission` text DEFAULT NULL,
  `country` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `state` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `created_time` timestamp NULL DEFAULT current_timestamp(),
  `company_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `imported_from_email` tinyint(1) DEFAULT 0,
  `email_integration_uid` varchar(30) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `last_contact` timestamp NULL DEFAULT NULL,
  `from_form_id` int(11) DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`leads_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_leads_notes` (
  `notes_id` int(11) NOT NULL AUTO_INCREMENT,
  `leads_id` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `contacted_indicator` varchar(50) DEFAULT NULL,
  `created_time` timestamp NULL DEFAULT current_timestamp(),
  `last_contact` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  `module_field_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`notes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_leave_application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leave_end_date` date DEFAULT NULL,
  `leave_type` enum('single_day','multiple_days','hours') NOT NULL DEFAULT 'single_day',
  `hours` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_leave_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_locales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_manufacturer` (
  `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`manufacturer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `parent` int(11) DEFAULT 0,
  `sort` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `time` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_mettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_milestones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_modules` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(55) NOT NULL,
  `installed_version` varchar(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_notes` (
  `notes_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `is_client` enum('Yes','No') NOT NULL DEFAULT 'No',
  `notes` text DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`notes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `tbl_notifications` (
  `notifications_id` int(11) NOT NULL AUTO_INCREMENT,
  `to_user_id` int(11) DEFAULT 0,
  `from_user_id` int(11) DEFAULT 0,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `read` tinyint(1) DEFAULT 0,
  `read_inline` tinyint(1) NOT NULL DEFAULT 0,
  `date` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`notifications_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_online_payment` (
  `online_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `gateway_name` varchar(20) NOT NULL,
  `icon` text NOT NULL,
  `field_1` varchar(100) DEFAULT NULL,
  `field_2` varchar(100) DEFAULT NULL,
  `field_3` varchar(100) DEFAULT NULL,
  `field_4` varchar(100) DEFAULT NULL,
  `field_5` varchar(100) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `modal` enum('Yes','No') DEFAULT NULL,
  PRIMARY KEY (`online_payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_opportunities` (
  `opportunities_id` int(11) NOT NULL AUTO_INCREMENT,
  `opportunity_name` varchar(200) DEFAULT NULL,
  `close_date` date DEFAULT NULL,
  `probability` int(11) DEFAULT 0,
  `permission` text DEFAULT NULL,
  `stages` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`opportunities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_opportunities_state_reason` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_outgoing_emails` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sent_to` varchar(64) DEFAULT NULL,
  `sent_from` varchar(64) DEFAULT NULL,
  `subject` text DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `date_sent` timestamp NULL DEFAULT current_timestamp(),
  `delivered` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_overtime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_payment_methods` (
  `payment_methods_id` int(11) NOT NULL AUTO_INCREMENT,
  `method_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`payment_methods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_payments` (
  `payments_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoices_id` int(11) DEFAULT 0,
  `trans_id` varchar(100) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `amount` decimal(18,2) DEFAULT 0.00,
  `payment_method` int(11) DEFAULT 0,
  `payment_date` date DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT current_timestamp(),
  `month_paid` varchar(2) DEFAULT NULL,
  `year_paid` varchar(4) DEFAULT NULL,
  `account_id` int(11) NOT NULL DEFAULT 0 COMMENT 'account_id means tracking deposit from which account',
  PRIMARY KEY (`payments_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_performance_apprisal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_performance_indicator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_pinaction` (
  `pinaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `module_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`pinaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_priority` (
  `priority_id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`priority_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `tbl_private_chat` (
  `private_chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_title` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`private_chat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_private_chat_messages` (
  `private_chat_messages_id` int(11) NOT NULL AUTO_INCREMENT,
  `private_chat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `message_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`private_chat_messages_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_private_chat_users` (
  `private_chat_users_id` int(11) NOT NULL AUTO_INCREMENT,
  `private_chat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `active` int(11) NOT NULL COMMENT '0 == minimize chat,1 == open chat and  2 == close chat ',
  `unread` int(11) NOT NULL,
  `title` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0 COMMENT 'keep last message id',
  PRIMARY KEY (`private_chat_users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(200) DEFAULT NULL,
  `client_id` int(11) DEFAULT 0,
  `progress` int(11) DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `project_status` varchar(50) DEFAULT NULL,
  `permission` text DEFAULT NULL,
  `category_id` int(11) DEFAULT 0,
  `tags` text DEFAULT NULL,
  `timer_started_by` int(11) DEFAULT 0,
  `start_time` varchar(50) DEFAULT NULL,
  `timer_status` varchar(10) DEFAULT 'off',
  `description` text DEFAULT NULL,
  `calculate_progress` varchar(100) DEFAULT NULL,
  `estimate_hours` varchar(100) DEFAULT NULL,
  `billing_type` varchar(100) DEFAULT NULL,
  `alert_overdue` tinyint(1) NOT NULL DEFAULT 0,
  `project_no` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_project_settings` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `settings` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`settings_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `tbl_promotions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `from_designations` int(11) NOT NULL,
  `promotion_title` varchar(190) NOT NULL,
  `promotion_date` date NOT NULL,
  `description` varchar(190) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_proposals` (
  `proposals_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(32) DEFAULT NULL,
  `subject` varchar(500) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  `module_id` int(11) DEFAULT 0,
  `proposal_date` varchar(50) DEFAULT NULL,
  `proposal_month` varchar(50) NOT NULL,
  `proposal_year` varchar(20) NOT NULL,
  `due_date` varchar(40) DEFAULT NULL,
  `currency` varchar(32) DEFAULT 'USD',
  `notes` text NOT NULL,
  `tax` int(11) NOT NULL DEFAULT 0,
  `total_tax` varchar(200) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'draft',
  `date_sent` varchar(64) DEFAULT NULL,
  `proposal_deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `emailed` enum('Yes','No') DEFAULT 'No',
  `show_client` enum('Yes','No') DEFAULT 'No',
  `convert` enum('Yes','No') NOT NULL DEFAULT 'No',
  `convert_module` varchar(200) DEFAULT NULL,
  `convert_module_id` int(11) DEFAULT 0,
  `converted_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `permission` text DEFAULT NULL,
  `discount_type` enum('before_tax','after_tax') DEFAULT NULL,
  `discount_percent` int(2) NOT NULL DEFAULT 0,
  `discount_total` decimal(18,2) NOT NULL DEFAULT 0.00,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `adjustment` decimal(18,2) NOT NULL DEFAULT 0.00,
  `show_quantity_as` varchar(20) DEFAULT NULL,
  `allowed_cmments` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `alert_overdue` tinyint(1) DEFAULT 0,
  `tags` text DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`proposals_id`),
  UNIQUE KEY `reference_no` (`reference_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `tbl_proposals_items` (
  `proposals_items_id` int(11) NOT NULL AUTO_INCREMENT,
  `proposals_id` int(11) NOT NULL,
  `item_name` varchar(150) DEFAULT 'Item Name',
  `item_desc` longtext DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `unit_cost` decimal(10,2) DEFAULT 0.00,
  `item_tax_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `item_tax_name` text DEFAULT NULL,
  `item_tax_total` decimal(10,2) DEFAULT 0.00,
  `total_cost` decimal(10,2) DEFAULT 0.00,
  `date_saved` timestamp NOT NULL DEFAULT current_timestamp(),
  `order` int(11) DEFAULT 0,
  `unit` varchar(200) NOT NULL,
  `saved_items_id` int(11) DEFAULT 0,
  `hsn_code` text DEFAULT NULL,
  PRIMARY KEY (`proposals_items_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `tbl_purchase_items` (
  `items_id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `item_tax_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `item_tax_name` text DEFAULT NULL,
  `item_tax_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `total_cost` decimal(10,2) DEFAULT 0.00,
  `item_name` varchar(255) DEFAULT 'Item Name',
  `item_desc` longtext DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT 0.00,
  `order` int(11) DEFAULT 0,
  `date_saved` timestamp NOT NULL DEFAULT current_timestamp(),
  `unit` varchar(200) DEFAULT NULL,
  `hsn_code` text DEFAULT NULL,
  `saved_items_id` int(11) DEFAULT 0,
  PRIMARY KEY (`items_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `tbl_purchase_payments` (
  `payments_id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) DEFAULT NULL,
  `trans_id` varchar(64) DEFAULT NULL,
  `payment_method` varchar(64) DEFAULT NULL,
  `amount` longtext DEFAULT NULL,
  `currency` varchar(64) DEFAULT 'USD',
  `notes` varchar(255) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `month_paid` varchar(32) DEFAULT NULL,
  `year_paid` varchar(32) DEFAULT NULL,
  `paid_to` int(11) NOT NULL,
  `paid_by` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `account_id` int(11) NOT NULL DEFAULT 0 COMMENT 'account_id means tracking deduct from which account',
  PRIMARY KEY (`payments_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `tbl_purchases` (
  `purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) DEFAULT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `update_stock` enum('Yes','No') DEFAULT 'Yes',
  `status` varchar(20) DEFAULT NULL,
  `emailed` enum('Yes','No') DEFAULT NULL,
  `date_sent` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `discount_type` enum('before_tax','after_tax') DEFAULT NULL,
  `discount_percent` decimal(10,2) DEFAULT NULL,
  `adjustment` decimal(18,2) DEFAULT NULL,
  `discount_total` decimal(18,2) DEFAULT NULL,
  `show_quantity_as` varchar(10) DEFAULT NULL,
  `permission` text DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_tax` text DEFAULT NULL,
  `tax` decimal(20,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `stock_updated` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `tbl_quotation_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_quotationforms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_quotations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_convert` enum('Yes','No') NOT NULL DEFAULT 'No',
  `convert_module` varchar(20) DEFAULT NULL,
  `convert_module_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_reminders` (
  `reminder_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text DEFAULT NULL,
  `date` datetime NOT NULL,
  `notified` enum('Yes','No') NOT NULL DEFAULT 'No',
  `module` varchar(200) NOT NULL,
  `module_id` int(11) NOT NULL,
  `user_id` varchar(40) NOT NULL,
  `notify_by_email` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`reminder_id`),
  KEY `rel_id` (`module`),
  KEY `rel_type` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_resignations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `notice_date` date NOT NULL,
  `resignation_date` date NOT NULL,
  `description` varchar(190) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_return_stock` (
  `return_stock_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoices_id` int(11) DEFAULT NULL,
  `reference_no` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `total` decimal(20,2) DEFAULT NULL,
  `update_stock` enum('Yes','No') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'Yes',
  `status` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `emailed` enum('Yes','No') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `date_sent` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `return_stock_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `discount_type` enum('before_tax','after_tax') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `discount_percent` decimal(10,2) DEFAULT NULL,
  `adjustment` decimal(18,2) DEFAULT NULL,
  `discount_total` decimal(18,2) DEFAULT NULL,
  `show_quantity_as` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `permission` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `total_tax` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `tax` decimal(20,2) DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `module` enum('client','supplier') DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `main_status` varchar(200) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`return_stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `tbl_return_stock_items` (
  `items_id` int(11) NOT NULL AUTO_INCREMENT,
  `return_stock_id` int(11) NOT NULL,
  `item_tax_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `item_tax_name` text DEFAULT NULL,
  `item_tax_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `total_cost` decimal(10,2) DEFAULT 0.00,
  `item_name` varchar(255) DEFAULT 'Item Name',
  `item_desc` longtext DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT 0.00,
  `order` int(11) DEFAULT 0,
  `date_saved` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `unit` varchar(200) DEFAULT NULL,
  `hsn_code` text DEFAULT NULL,
  `saved_items_id` int(11) DEFAULT 0,
  `invoice_items_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`items_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `tbl_return_stock_payments` (
  `payments_id` int(11) NOT NULL AUTO_INCREMENT,
  `return_stock_id` int(11) DEFAULT NULL,
  `trans_id` varchar(64) DEFAULT NULL,
  `payment_method` varchar(64) DEFAULT NULL,
  `amount` longtext DEFAULT NULL,
  `currency` varchar(64) DEFAULT 'USD',
  `notes` varchar(255) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `month_paid` varchar(32) DEFAULT NULL,
  `year_paid` varchar(32) DEFAULT NULL,
  `module` varchar(200) DEFAULT NULL,
  `paid_to` int(11) DEFAULT NULL,
  `paid_by` int(11) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `account_id` int(11) NOT NULL DEFAULT 0 COMMENT 'account_id means tracking deduct from which account',
  PRIMARY KEY (`payments_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `tbl_saas_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_salary_allowance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_salary_deduction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_salary_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deduct_from` int(11) NOT NULL DEFAULT 0 COMMENT 'deduct from means tracking deduct from which account',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_salary_payment_allowance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_salary_payment_deduction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_salary_payment_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_salary_payslip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_salary_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_saved_items` (
  `saved_items_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(200) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `permission` text DEFAULT NULL,
  `tax_rates_id` text DEFAULT NULL,
  `customer_group_id` int(11) NOT NULL DEFAULT 0,
  `unit_type` varchar(200) DEFAULT NULL,
  `hsn_code` text DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `barcode_symbology` varchar(50) NOT NULL,
  `upload_file` text DEFAULT NULL,
  `cost_price` decimal(20,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`saved_items_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_sent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attach_file` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_stock_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_stock_sub_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_suppliers` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `permission` text DEFAULT NULL,
  `vat` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `tbl_tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) DEFAULT NULL,
  `style` text DEFAULT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_task` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(200) DEFAULT NULL,
  `project_id` int(11) DEFAULT 0,
  `task_status` varchar(50) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `permission` text DEFAULT NULL,
  `timer_started_by` int(11) DEFAULT 0,
  `start_time` varchar(50) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `timer_status` varchar(10) DEFAULT 'off',
  `task_progress` int(11) DEFAULT 0,
  `index_no` int(11) DEFAULT NULL,
  `task_description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `task_start_date` date DEFAULT NULL,
  `task_hour` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `hourly_rate` decimal(18,2) DEFAULT 0.00,
  `milestones_order` int(11) NOT NULL DEFAULT 0,
  `sub_task_id` int(11) DEFAULT NULL,
  `calculate_progress` varchar(200) DEFAULT NULL,
  `transactions_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  `module_field_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_task_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attachments_id` int(11) DEFAULT 0,
  `comments_reply_id` int(11) NOT NULL DEFAULT 0,
  `uploaded_files_id` int(11) DEFAULT 0,
  `module` varchar(50) DEFAULT NULL,
  `module_field_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_tasks_timer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) DEFAULT NULL,
  `timer_status` enum('on','off') NOT NULL DEFAULT 'off',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_tax_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_terminations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `attachment` text DEFAULT NULL,
  `notice_date` date NOT NULL,
  `termination_date` date NOT NULL,
  `termination_type` varchar(190) NOT NULL,
  `description` varchar(190) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_tickets` (
  `tickets_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `permission` text DEFAULT NULL,
  `project_id` int(11) DEFAULT 0,
  `email` varchar(50) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  PRIMARY KEY (`tickets_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_tickets_replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_reply_id` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_todo` (
  `todo_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0,
  `created_date` timestamp NULL DEFAULT current_timestamp(),
  `due_date` date DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `assigned` int(11) NOT NULL DEFAULT 0,
  `order` int(11) DEFAULT 1,
  PRIMARY KEY (`todo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_total` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_file` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_transactions` (
  `transactions_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `amount` decimal(18,2) DEFAULT 0.00,
  `date` date DEFAULT NULL,
  `project_id` int(11) DEFAULT 0,
  `permission` text DEFAULT NULL,
  `account_id` int(11) DEFAULT 0,
  `status` enum('Cleared','Uncleared','Reconciled','Void','non_approved','paid') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'non_approved',
  `category_id` int(11) DEFAULT NULL,
  `tags` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `recurring_type` varchar(50) DEFAULT NULL,
  `payment_methods_id` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `repeat_every` int(11) DEFAULT NULL,
  `recurring` enum('Yes','No') DEFAULT NULL,
  `total_cycles` int(11) DEFAULT NULL,
  `done_cycles` int(11) DEFAULT NULL,
  `custom_recurring` tinyint(1) DEFAULT 0,
  `last_recurring_date` date DEFAULT NULL,
  `recurring_from` int(11) DEFAULT NULL,
  `transaction_prefix` varchar(50) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`transactions_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_transfer_item` (
  `transfer_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(50) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `status` enum('pending','complete','send','approved','rejected') DEFAULT NULL,
  `shipping_cost` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `attachment` text DEFAULT NULL,
  `from_warehouse_id` int(11) NOT NULL,
  `to_warehouse_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `show_quantity_as` varchar(20) DEFAULT NULL,
  `tax` decimal(18,3) DEFAULT NULL,
  `total_tax` text NOT NULL,
  `permission` text DEFAULT NULL,
  PRIMARY KEY (`transfer_item_id`),
  UNIQUE KEY `reference_no` (`reference_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_transfer_itemlist` (
  `transfer_itemList_id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_item_id` int(11) NOT NULL,
  `saved_items_id` int(11) DEFAULT 0,
  `warehouse_id` int(11) DEFAULT NULL,
  `item_tax_rate` decimal(10,2) DEFAULT 0.00,
  `item_tax_name` text DEFAULT NULL,
  `item_name` varchar(150) DEFAULT 'Item Name',
  `item_desc` longtext DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT 0.00,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `item_tax_total` decimal(10,2) DEFAULT 0.00,
  `total_cost` decimal(10,2) DEFAULT 0.00,
  `date_saved` timestamp NOT NULL DEFAULT '2018-12-12 04:00:00',
  `unit` varchar(200) DEFAULT NULL,
  `hsn_code` text DEFAULT NULL,
  `order` int(11) DEFAULT 0,
  PRIMARY KEY (`transfer_itemList_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_user_role` (
  `user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `designations_id` int(11) DEFAULT 0,
  `menu_id` int(11) DEFAULT 0,
  `view` tinyint(1) DEFAULT 0,
  `created` tinyint(1) DEFAULT 0,
  `edited` tinyint(1) DEFAULT 0,
  `deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`user_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `role_id` tinyint(4) NOT NULL DEFAULT 3,
  `activated` tinyint(1) NOT NULL DEFAULT 1,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  `ban_reason` varchar(255) DEFAULT NULL,
  `new_password_key` varchar(100) DEFAULT NULL,
  `new_pass_key` varchar(100) DEFAULT NULL,
  `last_ip` varchar(45) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `online_time` timestamp NULL DEFAULT NULL,
  `permission` text DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_warehouse` (
  `warehouse_id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_name` varchar(200) DEFAULT NULL,
  `permission` text DEFAULT NULL,
  PRIMARY KEY (`warehouse_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_warehouses_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `rack` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `warehouse_id` (`warehouse_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_warnings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `warning_to` int(11) NOT NULL,
  `warning_by` int(11) NOT NULL,
  `warning_type` int(11) NOT NULL,
  `attachment` text DEFAULT NULL,
  `subject` varchar(190) NOT NULL,
  `warning_date` date NOT NULL,
  `description` varchar(190) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `tbl_working_days` (
  `working_days_id` int(11) NOT NULL AUTO_INCREMENT,
  `day_id` int(11) DEFAULT 0,
  `flag` tinyint(1) DEFAULT 1,
  `start_hours` varchar(20) NOT NULL,
  `end_hours` varchar(20) NOT NULL,
  PRIMARY KEY (`working_days_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_workplace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_migrations (version) VALUES (600);
