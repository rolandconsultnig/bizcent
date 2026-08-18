SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS `tbl_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_users` (
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
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `online_time` timestamp NULL DEFAULT NULL,
  `permission` text,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_account_details` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_config` (
  `config_key` varchar(100) NOT NULL,
  `value` text,
  PRIMARY KEY (`config_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_currencies` (
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_languages` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_notifications` (
  `notifications_id` int(11) NOT NULL AUTO_INCREMENT,
  `to_user_id` int(11) DEFAULT 0,
  `from_user_id` int(11) DEFAULT 0,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `icon` varchar(50) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `read` tinyint(1) DEFAULT 0,
  `read_inline` tinyint(1) NOT NULL DEFAULT 0,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notifications_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `parent` int(11) DEFAULT 0,
  `sort` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_user_role` (
  `user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `designations_id` int(11) DEFAULT 0,
  `menu_id` int(11) DEFAULT 0,
  `view` tinyint(1) DEFAULT 0,
  `created` tinyint(1) DEFAULT 0,
  `edited` tinyint(1) DEFAULT 0,
  `deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`user_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_client_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `parent` int(11) DEFAULT 0,
  `sort` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_client_role` (
  `client_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0,
  `menu_id` int(11) DEFAULT 0,
  PRIMARY KEY (`client_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_modules` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(55) NOT NULL,
  `installed_version` varchar(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_activities` (
  `activities_id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT 0,
  `module` varchar(50) DEFAULT NULL,
  `module_field_id` int(11) DEFAULT 0,
  `activity` varchar(200) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `value1` varchar(255) DEFAULT NULL,
  `value2` varchar(255) DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`activities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_departments` (
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
  PRIMARY KEY (`departments_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_designations` (
  `designations_id` int(11) NOT NULL AUTO_INCREMENT,
  `departments_id` int(11) DEFAULT 0,
  `designations` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`designations_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_client` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `short_name` varchar(100) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `address` text,
  `city` varchar(100) DEFAULT NULL,
  `zipcode` varchar(50) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'USD',
  `country` varchar(100) DEFAULT NULL,
  `vat` varchar(100) DEFAULT NULL,
  `permission` text,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(200) DEFAULT NULL,
  `client_id` int(11) DEFAULT 0,
  `progress` int(11) DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `project_status` varchar(50) DEFAULT NULL,
  `category_id` int(11) DEFAULT 0,
  `permission` text,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_task` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(200) DEFAULT NULL,
  `project_id` int(11) DEFAULT 0,
  `task_status` varchar(50) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `permission` text,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_invoices` (
  `invoices_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(100) DEFAULT NULL,
  `client_id` int(11) DEFAULT 0,
  `project_id` int(11) DEFAULT 0,
  `user_id` int(11) DEFAULT 0,
  `status` varchar(50) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `invoice_month` varchar(20) DEFAULT NULL,
  `invoice_year` varchar(10) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `recurring` varchar(10) DEFAULT 'No',
  `date_saved` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `discount_percent` int(2) DEFAULT NULL,
  `discount_total` decimal(18,2) DEFAULT 0.00,
  `adjustment` decimal(18,2) DEFAULT 0.00,
  `show_quantity_as` varchar(20) DEFAULT NULL,
  `inv_deleted` varchar(10) DEFAULT 'No',
  `notes` text,
  `tags` text,
  `permission` text,
  PRIMARY KEY (`invoices_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_estimates` (
  `estimates_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(100) DEFAULT NULL,
  `client_id` int(11) DEFAULT 0,
  `status` varchar(50) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `permission` text,
  PRIMARY KEY (`estimates_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_bug` (
  `bug_id` int(11) NOT NULL AUTO_INCREMENT,
  `bug_title` varchar(200) DEFAULT NULL,
  `bug_status` varchar(50) DEFAULT NULL,
  `permission` text,
  PRIMARY KEY (`bug_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_opportunities` (
  `opportunities_id` int(11) NOT NULL AUTO_INCREMENT,
  `opportunity_name` varchar(200) DEFAULT NULL,
  `close_date` date DEFAULT NULL,
  `probability` int(11) DEFAULT 0,
  `permission` text,
  PRIMARY KEY (`opportunities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_transactions` (
  `transactions_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `amount` decimal(18,2) DEFAULT 0.00,
  `date` date DEFAULT NULL,
  `account_id` int(11) DEFAULT 0,
  `project_id` int(11) DEFAULT 0,
  `permission` text,
  PRIMARY KEY (`transactions_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_accounts` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(200) DEFAULT NULL,
  `description` text,
  `balance` decimal(18,2) DEFAULT 0.00,
  `permission` text,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_leads` (
  `leads_id` int(11) NOT NULL AUTO_INCREMENT,
  `lead_name` varchar(200) DEFAULT NULL,
  `permission` text,
  PRIMARY KEY (`leads_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_tickets` (
  `tickets_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `permission` text,
  PRIMARY KEY (`tickets_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0,
  `date_in` date DEFAULT NULL,
  `date_out` date DEFAULT NULL,
  `attendance_status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`attendance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_clock` (
  `clock_id` int(11) NOT NULL AUTO_INCREMENT,
  `attendance_id` int(11) DEFAULT 0,
  `clockin_time` time DEFAULT NULL,
  `clockout_time` time DEFAULT NULL,
  `clocking_status` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`clock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_holiday` (
  `holiday_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(200) DEFAULT NULL,
  `description` text,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`holiday_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_days` (
  `day_id` int(11) NOT NULL AUTO_INCREMENT,
  `day` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`day_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_working_days` (
  `working_days_id` int(11) NOT NULL AUTO_INCREMENT,
  `day_id` int(11) DEFAULT 0,
  `flag` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`working_days_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_warehouse` (
  `warehouse_id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_name` varchar(200) DEFAULT NULL,
  `permission` text,
  PRIMARY KEY (`warehouse_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_saved_items` (
  `saved_items_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(200) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `permission` text,
  PRIMARY KEY (`saved_items_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_dashboard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `col` varchar(200) DEFAULT NULL,
  `order_no` int(2) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `report` tinyint(1) NOT NULL DEFAULT 0,
  `for_staff` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_todo` (
  `todo_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `due_date` date DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `assigned` int(11) NOT NULL DEFAULT 0,
  `order` int(11) DEFAULT 1,
  PRIMARY KEY (`todo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_form` (
  `form_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_name` varchar(200) DEFAULT NULL,
  `tbl_name` varchar(200) DEFAULT NULL,
  `table_id` varchar(110) DEFAULT NULL,
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_custom_field` (
  `custom_field_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) DEFAULT 0,
  `field_label` varchar(200) DEFAULT NULL,
  `field_type` varchar(50) DEFAULT 'text',
  `default_value` text,
  `help_text` varchar(255) DEFAULT NULL,
  `required` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `show_on_table` varchar(5) DEFAULT NULL,
  `visible_for_admin` varchar(11) DEFAULT NULL,
  `visible_for_client` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`custom_field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_customer_group` (
  `customer_group_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) DEFAULT NULL,
  `customer_group` varchar(200) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`customer_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) DEFAULT NULL,
  `style` text,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_pinaction` (
  `pinaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `module_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`pinaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_config` (`config_key`, `value`) VALUES
('company_name', 'RolandERP'),
('company_legal_name', 'RolandERP'),
('website_name', 'RolandERP'),
('contact_person', 'Admin'),
('mail_username', 'admin'),
('company_email', 'admin@localhost'),
('timezone', 'UTC'),
('default_language', 'english'),
('default_currency', 'USD'),
('version', '6.0.0'),
('allow_client_registration', 'FALSE'),
('mark_attendance_from_login', 'No'),
('allow_geo_clock_in', 'FALSE'),
('recaptcha_secret_key', ''),
('recaptcha_site_key', ''),
('RTL', ''),
('date_format', '%d-%m-%Y'),
('time_format', 'g:i a'),
('office_lat', ''),
('office_long', ''),
('allowed_radius', '0'),
('auto_check_for_new_notifications', '0'),
('desktop_notifications', '0'),
('company_logo', 'assets/img/logo.png'),
('favicon', 'assets/img/favicon.ico'),
('logo_or_icon', 'logo_title'),
('sidebar_theme', 'bg-dark'),
('active_pre_loader', '0'),
('copyright_name', 'RolandERP'),
('copyright_url', '#'),
('chat_interval_time', '5');

INSERT INTO `tbl_currencies` (`code`, `name`, `symbol`) VALUES
('USD', 'US Dollar', '$'),
('EUR', 'Euro', '€'),
('GBP', 'Pound Sterling', '£'),
('NGN', 'Nigerian Naira', '₦');

INSERT INTO `tbl_languages` (`code`, `name`, `icon`, `active`) VALUES
('english', 'English', 'en', 1);

INSERT INTO `tbl_migrations` (`version`) VALUES (600);

INSERT INTO `tbl_days` (`day_id`, `day`) VALUES
(1, 'Monday'), (2, 'Tuesday'), (3, 'Wednesday'), (4, 'Thursday'), (5, 'Friday'), (6, 'Saturday'), (7, 'Sunday');

INSERT INTO `tbl_working_days` (`day_id`, `flag`) VALUES
(1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 0), (7, 0);

INSERT INTO `tbl_dashboard` (`id`, `name`, `col`, `order_no`, `status`, `report`, `for_staff`) VALUES
(1, 'income_expenses_report', 'col-sm-4', 1, 1, 1, 1),
(2, 'invoice_payment_report', 'col-sm-4', 1, 1, 1, 1),
(3, 'ticket_tasks_report', 'col-sm-4', 2, 1, 1, 1),
(5, 'goal_report', 'col-md-12', 7, 1, 0, 1),
(6, 'overdue_report', 'col-md-12', 10, 1, 0, 1),
(11, 'my_project', 'col-md-6', 24, 1, 0, 1),
(12, 'my_tasks', 'col-md-6', 27, 1, 0, 1),
(14, 'announcements', 'col-md-6', 30, 1, 0, 1),
(15, 'payments_report', 'col-md-6', 39, 1, 0, 1),
(16, 'income_expense', 'col-md-6', 15, 1, 0, 1),
(17, 'income_report', 'col-md-6', 42, 1, 0, 1),
(18, 'expense_report', 'col-md-6', 36, 1, 0, 1),
(19, 'recently_paid_invoices', 'col-md-6', 21, 1, 0, 1),
(20, 'recent_activities', 'col-md-6', 18, 1, 0, 1),
(21, 'finance_overview', 'col-sm-12', 1, 1, 0, 1),
(22, 'todo_list', 'col-md-6', 32, 1, 0, 1),
(23, 'paid_amount', 'col-md-3', 2, 1, 2, 1),
(24, 'due_amount', 'col-md-3', 4, 1, 2, 1),
(25, 'invoice_amount', 'col-md-3', 1, 1, 2, 1),
(26, 'paid_percentage', 'col-md-3', 3, 1, 2, 1),
(27, 'recently_paid_invoices', 'col-sm-6', 2, 1, 3, 1),
(28, 'payments', 'col-sm-6', 1, 1, 3, 1),
(29, 'recent_invoice', 'col-sm-6', 3, 1, 3, 1),
(30, 'recent_projects', 'col-sm-6', 4, 1, 3, 1),
(31, 'recent_emails', 'col-sm-4', 5, 1, 3, 1),
(32, 'recent_activities', 'col-sm-4', 6, 1, 3, 1),
(33, 'announcements', 'col-sm-4', 7, 1, 3, 1),
(34, 'my_calendar', 'col-sm-6', 1, 1, 0, 1);

INSERT INTO `tbl_menu` (`menu_id`, `label`, `link`, `icon`, `parent`, `sort`, `status`) VALUES
(1, 'dashboard', 'admin/dashboard', 'fa fa-dashboard', 0, 1, 1),
(24, 'users', 'admin/user/user_list', 'fa fa-users', 0, 20, 1),
(25, 'settings', 'admin/settings', 'fa fa-cogs', 0, 99, 1),
(26, 'client', 'admin/client/manage_client', 'fa fa-user', 0, 5, 1),
(27, 'projects', 'admin/projects', 'fa fa-folder-open', 0, 6, 1),
(28, 'tasks', 'admin/tasks/all_task', 'fa fa-tasks', 0, 7, 1),
(29, 'bugs', 'admin/bugs', 'fa fa-bug', 0, 8, 1),
(30, 'leads', 'admin/leads', 'fa fa-rocket', 0, 9, 1),
(31, 'opportunities', 'admin/opportunities', 'fa fa-filter', 0, 10, 1),
(32, 'tickets', 'admin/tickets', 'fa fa-ticket', 0, 11, 1),
(33, 'invoice', 'admin/invoice/manage_invoice', 'fa fa-file-text', 0, 12, 1),
(34, 'estimates', 'admin/estimates', 'fa fa-file-o', 0, 13, 1),
(35, 'transactions', 'admin/transactions/deposit', 'fa fa-money', 0, 14, 1),
(36, 'mailbox', 'admin/mailbox', 'fa fa-envelope', 0, 15, 1),
(37, 'calendar', 'admin/calendar', 'fa fa-calendar', 0, 16, 1),
(38, 'filemanager', 'admin/filemanager', 'fa fa-folder', 0, 17, 1),
(39, 'items', 'admin/items/items_list', 'fa fa-cubes', 0, 18, 1),
(40, 'stock', 'admin/stock/stock_category', 'fa fa-archive', 0, 19, 1),
(41, 'purchase', 'admin/purchase', 'fa fa-shopping-cart', 0, 21, 1),
(42, 'report', 'admin/report/account_statement', 'fa fa-bar-chart', 0, 22, 1),
(43, 'attendance', 'admin/attendance/time_history', 'fa fa-clock-o', 0, 23, 1),
(44, 'payroll', 'admin/payroll/salary_template', 'fa fa-credit-card', 0, 24, 1);

SET FOREIGN_KEY_CHECKS = 1;
