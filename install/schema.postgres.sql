-- RolandERP schema for PostgreSQL (converted from schema.sql)


CREATE TABLE IF NOT EXISTS tbl_account_details (
  account_details_id serial,
  user_id integer NOT NULL,
  fullname varchar(200) DEFAULT NULL,
  employment_id varchar(100) DEFAULT NULL,
  company varchar(200) DEFAULT '0',
  locale varchar(50) DEFAULT NULL,
  "language" varchar(50) DEFAULT 'english',
  phone varchar(50) DEFAULT NULL,
  mobile varchar(50) DEFAULT NULL,
  skype varchar(100) DEFAULT NULL,
  direction varchar(10) DEFAULT 'ltr',
  designations_id integer DEFAULT 0,
  warehouse_id integer DEFAULT 0,
  avatar varchar(255) DEFAULT 'uploads/staff_profile_images/default.jpg',
  joining_date date DEFAULT NULL,
  PRIMARY KEY (account_details_id)
);

CREATE TABLE IF NOT EXISTS tbl_accounts (
  account_id serial,
  account_name varchar(200) DEFAULT NULL,
  description text DEFAULT NULL,
  balance decimal(18,2) DEFAULT 0.00,
  permission text DEFAULT NULL,
  account_number varchar(50) DEFAULT NULL,
  contact_person varchar(100) DEFAULT NULL,
  contact_phone varchar(20) DEFAULT NULL,
  bank_details text DEFAULT NULL,
  PRIMARY KEY (account_id)
);

CREATE TABLE IF NOT EXISTS tbl_activities (
  activities_id serial,
  "user" integer DEFAULT 0,
  module varchar(50) DEFAULT NULL,
  module_field_id integer DEFAULT 0,
  activity varchar(200) DEFAULT NULL,
  icon varchar(50) DEFAULT NULL,
  value1 varchar(255) DEFAULT NULL,
  value2 varchar(255) DEFAULT NULL,
  time timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  activity_date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  link varchar(200) DEFAULT NULL,
  PRIMARY KEY (activities_id)
);

CREATE TABLE IF NOT EXISTS tbl_advance_salary (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_allowed_ip (
  allowed_ip_id serial,
  allowed_ip varchar(100) NOT NULL,
  status varchar(100) DEFAULT 'pending',
  PRIMARY KEY (allowed_ip_id)
);

CREATE TABLE IF NOT EXISTS tbl_announcements (
  announcements_id serial,
  title varchar(255) DEFAULT NULL,
  description text DEFAULT NULL,
  created_date timestamp DEFAULT NULL,
  attachment text DEFAULT NULL,
  PRIMARY KEY (announcements_id)
);

CREATE TABLE IF NOT EXISTS tbl_assign_item (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_attachments (
  id serial,
  module varchar(50) DEFAULT NULL,
  module_field_id integer DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_attachments_files (
  id serial,
  attachments_id integer NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_attendance (
  attendance_id serial,
  user_id integer DEFAULT 0,
  date_in date DEFAULT NULL,
  date_out date DEFAULT NULL,
  attendance_status varchar(20) DEFAULT NULL,
  leave_application_id integer DEFAULT 0,
  PRIMARY KEY (attendance_id)
);

CREATE TABLE IF NOT EXISTS tbl_award_points (
  award_points_id serial,
  client_id integer NOT NULL,
  user_id integer NOT NULL,
  client_award_point varchar(100) NOT NULL,
  user_award_point varchar(100) NOT NULL,
  invoices_id integer NOT NULL,
  payment_status varchar(100) NOT NULL,
  date varchar(40) NOT NULL,
  PRIMARY KEY (award_points_id)
);

CREATE TABLE IF NOT EXISTS tbl_award_program (
  award_program_id serial,
  program_name varchar(100) NOT NULL,
  award_rule_id integer NOT NULL,
  client_id integer NOT NULL,
  start_date varchar(64) NOT NULL,
  end_date varchar(64) NOT NULL,
  description varchar(200) NOT NULL,
  status integer NOT NULL,
  PRIMARY KEY (award_program_id)
);

CREATE TABLE IF NOT EXISTS tbl_award_rule (
  award_rule_id serial,
  rule_name varchar(200) NOT NULL,
  date_create date NOT NULL,
  client_id integer NOT NULL,
  award_point_from varchar(20) NOT NULL,
  award_point_to varchar(20) NOT NULL,
  card integer NOT NULL,
  description text NOT NULL,
  PRIMARY KEY (award_rule_id)
);

CREATE TABLE IF NOT EXISTS tbl_bug (
  bug_id serial,
  bug_title varchar(200) DEFAULT NULL,
  bug_status varchar(50) DEFAULT NULL,
  permission text DEFAULT NULL,
  notes text DEFAULT NULL,
  severity varchar(20) DEFAULT NULL,
  reproducibility text DEFAULT NULL,
  issue_no varchar(50) DEFAULT NULL,
  PRIMARY KEY (bug_id)
);

CREATE TABLE IF NOT EXISTS tbl_calls (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_card_config (
  card_config_id serial,
  name varchar(100) NOT NULL,
  date_create date DEFAULT NULL,
  subject_card integer DEFAULT 0,
  client_name integer DEFAULT 0,
  membership integer DEFAULT 0,
  company_name integer DEFAULT 0,
  member_since integer DEFAULT 0,
  custom_field integer DEFAULT 0,
  custom_field_content varchar(200) DEFAULT NULL,
  text_color varchar(25) DEFAULT NULL,
  PRIMARY KEY (card_config_id)
);

CREATE TABLE IF NOT EXISTS tbl_checklists (
  checklist_id serial,
  module varchar(32) DEFAULT NULL,
  module_id integer DEFAULT NULL,
  description text DEFAULT NULL,
  finished integer DEFAULT 0,
  create_datetime timestamp DEFAULT NULL,
  added_from integer DEFAULT NULL,
  finished_from integer DEFAULT NULL,
  list_order integer DEFAULT NULL,
  PRIMARY KEY (checklist_id)
);

CREATE TABLE IF NOT EXISTS tbl_client (
  client_id serial,
  name varchar(200) DEFAULT NULL,
  email varchar(200) DEFAULT NULL,
  short_name varchar(100) DEFAULT NULL,
  website varchar(200) DEFAULT NULL,
  phone varchar(50) DEFAULT NULL,
  mobile varchar(50) DEFAULT NULL,
  fax varchar(50) DEFAULT NULL,
  address text DEFAULT NULL,
  city varchar(100) DEFAULT NULL,
  zipcode varchar(50) DEFAULT NULL,
  currency varchar(10) DEFAULT 'USD',
  country varchar(100) DEFAULT NULL,
  vat varchar(100) DEFAULT NULL,
  permission text DEFAULT NULL,
  password text DEFAULT NULL,
  sms_notification smallint DEFAULT NULL,
  PRIMARY KEY (client_id)
);

CREATE TABLE IF NOT EXISTS tbl_client_menu (
  menu_id serial,
  label varchar(100) DEFAULT NULL,
  link varchar(200) DEFAULT NULL,
  icon varchar(50) DEFAULT NULL,
  parent integer DEFAULT 0,
  sort integer DEFAULT 0,
  status smallint DEFAULT 1,
  PRIMARY KEY (menu_id)
);

CREATE TABLE IF NOT EXISTS tbl_client_role (
  client_role_id serial,
  user_id integer DEFAULT 0,
  menu_id integer DEFAULT 0,
  PRIMARY KEY (client_role_id)
);

CREATE TABLE IF NOT EXISTS tbl_clock (
  clock_id serial,
  attendance_id integer DEFAULT 0,
  clockin_time time DEFAULT NULL,
  clockout_time time DEFAULT NULL,
  clocking_status smallint DEFAULT 0,
  latitude varchar(300) DEFAULT NULL,
  longitude varchar(300) DEFAULT NULL,
  location text DEFAULT NULL,
  PRIMARY KEY (clock_id)
);

CREATE TABLE IF NOT EXISTS tbl_clock_history (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_config (
  config_key varchar(100) NOT NULL,
  value text DEFAULT NULL,
  PRIMARY KEY (config_key)
);

CREATE TABLE IF NOT EXISTS tbl_countries (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_credit_note (
  credit_note_id serial,
  reference_no varchar(32) DEFAULT NULL,
  client_id integer DEFAULT NULL,
  project_id integer DEFAULT 0,
  credit_note_date varchar(50) DEFAULT NULL,
  credit_note_month varchar(20) DEFAULT NULL,
  credit_note_year varchar(10) DEFAULT NULL,
  currency varchar(32) DEFAULT 'USD',
  discount_percent integer DEFAULT NULL,
  notes text DEFAULT NULL,
  tax integer NOT NULL DEFAULT 0,
  total_tax text DEFAULT NULL,
  status varchar(20) NOT NULL DEFAULT 'open',
  date_saved timestamp NOT NULL DEFAULT '2018-12-12 11:00:00',
  emailed varchar(11) DEFAULT NULL,
  permission text DEFAULT NULL,
  client_visible varchar(20) NOT NULL DEFAULT 'No',
  discount_type varchar(100) NOT NULL,
  user_id integer NOT NULL DEFAULT 0,
  adjustment decimal(18,2) NOT NULL DEFAULT 0.00,
  discount_total decimal(18,2) NOT NULL DEFAULT 0.00,
  show_quantity_as varchar(20) NOT NULL,
  tags text DEFAULT NULL,
  warehouse_id integer DEFAULT NULL,
  PRIMARY KEY (credit_note_id)
);

CREATE TABLE IF NOT EXISTS tbl_credit_note_items (
  credit_note_items_id serial,
  credit_note_id integer NOT NULL,
  saved_items_id integer DEFAULT 0,
  item_tax_rate decimal(10,2) NOT NULL DEFAULT 0.00,
  item_tax_name text DEFAULT NULL,
  item_name varchar(150) DEFAULT 'Item Name',
  item_desc text DEFAULT NULL,
  unit_cost decimal(10,2) DEFAULT 0.00,
  quantity decimal(10,2) DEFAULT 0.00,
  item_tax_total decimal(10,2) DEFAULT 0.00,
  total_cost decimal(10,2) DEFAULT 0.00,
  date_saved timestamp NOT NULL DEFAULT '2018-12-12 11:00:00',
  unit varchar(200) DEFAULT NULL,
  hsn_code text DEFAULT NULL,
  "order" integer DEFAULT 0,
  PRIMARY KEY (credit_note_items_id)
);

CREATE TABLE IF NOT EXISTS tbl_credit_used (
  credit_used_id serial,
  invoices_id integer NOT NULL,
  credit_note_id integer NOT NULL,
  user_id integer NOT NULL,
  date date NOT NULL,
  date_applied timestamp NOT NULL,
  amount decimal(18,3) NOT NULL,
  payments_id integer DEFAULT NULL,
  PRIMARY KEY (credit_used_id)
);

CREATE TABLE IF NOT EXISTS tbl_currencies (
  code varchar(10) NOT NULL,
  name varchar(100) NOT NULL,
  symbol varchar(10) NOT NULL,
  PRIMARY KEY (code)
);

CREATE TABLE IF NOT EXISTS tbl_custom_field (
  custom_field_id serial,
  form_id integer DEFAULT 0,
  field_label varchar(200) DEFAULT NULL,
  field_type varchar(50) DEFAULT 'text',
  default_value text DEFAULT NULL,
  help_text varchar(255) DEFAULT NULL,
  required varchar(20) DEFAULT NULL,
  status varchar(20) DEFAULT 'active',
  show_on_table varchar(5) DEFAULT NULL,
  visible_for_admin varchar(11) DEFAULT NULL,
  visible_for_client varchar(11) DEFAULT NULL,
  PRIMARY KEY (custom_field_id)
);

CREATE TABLE IF NOT EXISTS tbl_customer_group (
  customer_group_id serial,
  type varchar(100) DEFAULT NULL,
  customer_group varchar(200) NOT NULL,
  description varchar(200) DEFAULT NULL,
  PRIMARY KEY (customer_group_id)
);

CREATE TABLE IF NOT EXISTS tbl_dashboard (
  id serial,
  name varchar(50) NOT NULL,
  col varchar(200) DEFAULT NULL,
  order_no integer NOT NULL DEFAULT 0,
  status smallint NOT NULL DEFAULT 0,
  report smallint NOT NULL DEFAULT 0,
  for_staff smallint DEFAULT 1,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_days (
  day_id serial,
  day varchar(20) DEFAULT NULL,
  PRIMARY KEY (day_id)
);

CREATE TABLE IF NOT EXISTS tbl_departments (
  departments_id serial,
  deptname varchar(200) DEFAULT NULL,
  department_head_id integer DEFAULT 0,
  encryption varchar(50) DEFAULT NULL,
  host varchar(200) DEFAULT NULL,
  username varchar(200) DEFAULT NULL,
  password varchar(200) DEFAULT NULL,
  mailbox varchar(200) DEFAULT NULL,
  unread_email smallint DEFAULT 0,
  delete_mail_after_import smallint DEFAULT 0,
  last_postmaster_run varchar(20) DEFAULT NULL,
  email varchar(50) DEFAULT NULL,
  PRIMARY KEY (departments_id)
);

CREATE TABLE IF NOT EXISTS tbl_designations (
  designations_id serial,
  departments_id integer DEFAULT 0,
  designations varchar(200) DEFAULT NULL,
  PRIMARY KEY (designations_id)
);

CREATE TABLE IF NOT EXISTS tbl_draft (
  id serial,
  attach_file text DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_email_templates (
  id serial,
  code varchar(20) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_employee_award (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_employee_bank (
  id serial,
  routing_number varchar(50) DEFAULT NULL,
  type_of_account varchar(20) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_employee_document (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_employee_payroll (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_estimate_items (
  estimate_items_id serial,
  estimates_id integer DEFAULT 0,
  total_cost decimal(18,2) DEFAULT 0.00,
  "order" integer DEFAULT 0,
  unit varchar(200) DEFAULT NULL,
  item_tax_name text DEFAULT NULL,
  saved_items_id integer DEFAULT 0,
  hsn_code text DEFAULT NULL,
  PRIMARY KEY (estimate_items_id)
);

CREATE TABLE IF NOT EXISTS tbl_estimates (
  estimates_id serial,
  reference_no varchar(100) DEFAULT NULL,
  client_id integer DEFAULT 0,
  status varchar(50) DEFAULT NULL,
  due_date date DEFAULT NULL,
  permission text DEFAULT NULL,
  discount_percent integer DEFAULT NULL,
  project_id integer DEFAULT 0,
  estimate_date varchar(50) DEFAULT NULL,
  estimate_month varchar(20) DEFAULT NULL,
  estimate_year varchar(10) DEFAULT NULL,
  invoices_id integer NOT NULL DEFAULT 0,
  discount_type varchar(100) NOT NULL,
  user_id integer NOT NULL DEFAULT 0,
  adjustment decimal(18,2) NOT NULL DEFAULT 0.00,
  discount_total decimal(18,2) NOT NULL DEFAULT 0.00,
  show_quantity_as varchar(20) NOT NULL,
  total_tax text DEFAULT NULL,
  alert_overdue smallint NOT NULL DEFAULT 0,
  tags text DEFAULT NULL,
  warehouse_id integer DEFAULT NULL,
  PRIMARY KEY (estimates_id)
);

CREATE TABLE IF NOT EXISTS tbl_expense_category (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_form (
  form_id serial,
  form_name varchar(200) DEFAULT NULL,
  tbl_name varchar(200) DEFAULT NULL,
  table_id varchar(110) DEFAULT NULL,
  PRIMARY KEY (form_id)
);

CREATE TABLE IF NOT EXISTS tbl_goal_tracking (
  goal_tracking_id serial,
  goal_type_id integer DEFAULT 0,
  account_id integer DEFAULT 0,
  achievement decimal(18,2) DEFAULT 0.00,
  end_date date DEFAULT NULL,
  PRIMARY KEY (goal_tracking_id)
);

CREATE TABLE IF NOT EXISTS tbl_goal_type (
  goal_type_id serial,
  type_name varchar(200) DEFAULT NULL,
  PRIMARY KEY (goal_type_id)
);

CREATE TABLE IF NOT EXISTS tbl_holiday (
  holiday_id serial,
  event_name varchar(200) DEFAULT NULL,
  description text DEFAULT NULL,
  start_date date DEFAULT NULL,
  end_date date DEFAULT NULL,
  PRIMARY KEY (holiday_id)
);

CREATE TABLE IF NOT EXISTS tbl_hourly_rate (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_inbox (
  id serial,
  attach_file text DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_income_category (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_invoices (
  invoices_id serial,
  reference_no varchar(100) DEFAULT NULL,
  client_id integer DEFAULT 0,
  status varchar(50) DEFAULT NULL,
  due_date date DEFAULT NULL,
  permission text DEFAULT NULL,
  discount_total decimal(18,2) DEFAULT 0.00,
  adjustment decimal(18,2) DEFAULT 0.00,
  inv_deleted varchar(10) DEFAULT 'No',
  invoice_date date DEFAULT NULL,
  project_id integer DEFAULT 0,
  user_id integer DEFAULT 0,
  invoice_month varchar(20) DEFAULT NULL,
  invoice_year varchar(10) DEFAULT NULL,
  recurring varchar(10) DEFAULT 'No',
  date_saved timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  discount_percent integer DEFAULT NULL,
  show_quantity_as varchar(20) DEFAULT NULL,
  notes text DEFAULT NULL,
  tags text DEFAULT NULL,
  client_visible varchar(10) DEFAULT 'No',
  allow_authorize_net varchar(100) NOT NULL DEFAULT 'No',
  allow_tappayment varchar(100) DEFAULT 'Yes',
  recur_start_date varchar(20) DEFAULT NULL,
  recur_end_date varchar(20) DEFAULT NULL,
  discount_type varchar(50) DEFAULT 'none',
  total_tax text DEFAULT NULL,
  allow_payumoney varchar(100) DEFAULT 'No',
  alert_overdue smallint NOT NULL DEFAULT 0,
  allow_razorpay varchar(100) DEFAULT 'No',
  warehouse_id integer DEFAULT NULL,
  PRIMARY KEY (invoices_id)
);

CREATE TABLE IF NOT EXISTS tbl_item_history (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_items (
  items_id serial,
  invoices_id integer DEFAULT 0,
  item_name varchar(255) DEFAULT NULL,
  total_cost decimal(18,2) DEFAULT 0.00,
  item_tax_total decimal(18,2) DEFAULT 0.00,
  "order" integer DEFAULT 0,
  item_tax_rate decimal(18,2) NOT NULL DEFAULT 0.00,
  quantity decimal(18,2) DEFAULT 0.00,
  unit_cost decimal(18,2) DEFAULT 0.00,
  unit varchar(200) DEFAULT NULL,
  item_tax_name text DEFAULT NULL,
  saved_items_id integer DEFAULT 0,
  hsn_code text DEFAULT NULL,
  PRIMARY KEY (items_id)
);

CREATE TABLE IF NOT EXISTS tbl_job_appliactions (
  id serial,
  send_email varchar(20) DEFAULT NULL,
  interview_date varchar(50) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_job_circular (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_kb_category (
  kb_category_id serial,
  category varchar(200) NOT NULL,
  description text DEFAULT NULL,
  type varchar(50) NOT NULL,
  sort integer NOT NULL,
  status smallint NOT NULL DEFAULT 1,
  PRIMARY KEY (kb_category_id)
);

CREATE TABLE IF NOT EXISTS tbl_knowledgebase (
  kb_id serial,
  kb_category_id integer NOT NULL,
  title text DEFAULT NULL,
  slug text DEFAULT NULL,
  description text DEFAULT NULL,
  attachments text DEFAULT NULL,
  for_all varchar(100) DEFAULT 'No',
  status smallint NOT NULL DEFAULT 1,
  total_view integer NOT NULL DEFAULT 0,
  created_by integer NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  sort integer NOT NULL DEFAULT 0,
  PRIMARY KEY (kb_id)
);

CREATE TABLE IF NOT EXISTS tbl_languages (
  language_id serial,
  code varchar(20) DEFAULT NULL,
  name varchar(50) DEFAULT NULL,
  icon varchar(50) DEFAULT NULL,
  active smallint DEFAULT 1,
  PRIMARY KEY (language_id)
);

CREATE TABLE IF NOT EXISTS tbl_lead_form (
  lead_form_id serial,
  form_key varchar(32) NOT NULL,
  form_name varchar(200) NOT NULL,
  lead_status_id integer NOT NULL,
  lead_source_id integer NOT NULL,
  "language" varchar(40) DEFAULT NULL,
  form_recaptcha integer NOT NULL DEFAULT 0,
  submit_btn_text varchar(40) DEFAULT NULL,
  submit_btn_msg text DEFAULT NULL,
  allow_duplicate integer NOT NULL DEFAULT 1,
  track_duplicate_field varchar(100) DEFAULT NULL,
  form_data text DEFAULT NULL,
  notify_lead_imported integer NOT NULL DEFAULT 1,
  permission text DEFAULT NULL,
  create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (lead_form_id)
);

CREATE TABLE IF NOT EXISTS tbl_lead_source (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_lead_status (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_leads (
  leads_id serial,
  lead_name varchar(200) DEFAULT NULL,
  permission text DEFAULT NULL,
  country varchar(50) DEFAULT NULL,
  state varchar(50) DEFAULT NULL,
  created_time timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  company_name varchar(255) DEFAULT NULL,
  title varchar(255) DEFAULT NULL,
  imported_from_email smallint DEFAULT 0,
  email_integration_uid varchar(30) DEFAULT NULL,
  tags text DEFAULT NULL,
  last_contact timestamp NULL DEFAULT NULL,
  from_form_id integer DEFAULT NULL,
  "language" varchar(100) DEFAULT NULL,
  PRIMARY KEY (leads_id)
);

CREATE TABLE IF NOT EXISTS tbl_leads_notes (
  notes_id serial,
  leads_id integer DEFAULT NULL,
  notes text DEFAULT NULL,
  contacted_indicator varchar(50) DEFAULT NULL,
  created_time timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  last_contact timestamp NULL DEFAULT NULL,
  user_id integer DEFAULT NULL,
  module varchar(50) DEFAULT NULL,
  module_field_id integer DEFAULT NULL,
  PRIMARY KEY (notes_id)
);

CREATE TABLE IF NOT EXISTS tbl_leave_application (
  id serial,
  leave_end_date date DEFAULT NULL,
  leave_type varchar(100) NOT NULL DEFAULT 'single_day',
  hours varchar(20) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_leave_category (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_locales (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_manufacturer (
  manufacturer_id serial,
  manufacturer varchar(100) NOT NULL,
  description text DEFAULT NULL,
  PRIMARY KEY (manufacturer_id)
);

CREATE TABLE IF NOT EXISTS tbl_menu (
  menu_id serial,
  label varchar(100) DEFAULT NULL,
  link varchar(200) DEFAULT NULL,
  icon varchar(50) DEFAULT NULL,
  parent integer DEFAULT 0,
  sort integer DEFAULT 0,
  status smallint DEFAULT 1,
  time timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (menu_id)
);

CREATE TABLE IF NOT EXISTS tbl_mettings (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_migrations (
  version bigint NOT NULL
);

CREATE TABLE IF NOT EXISTS tbl_milestones (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_modules (
  module_id serial,
  module_name varchar(55) NOT NULL,
  installed_version varchar(11) NOT NULL,
  active smallint NOT NULL DEFAULT 0,
  PRIMARY KEY (module_id)
);

CREATE TABLE IF NOT EXISTS tbl_notes (
  notes_id serial,
  user_id integer NOT NULL,
  is_client varchar(100) NOT NULL DEFAULT 'No',
  notes text DEFAULT NULL,
  added_by integer NOT NULL,
  added_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (notes_id)
);

CREATE TABLE IF NOT EXISTS tbl_notifications (
  notifications_id serial,
  to_user_id integer DEFAULT 0,
  from_user_id integer DEFAULT 0,
  name varchar(100) DEFAULT NULL,
  description text DEFAULT NULL,
  icon varchar(50) DEFAULT NULL,
  link varchar(255) DEFAULT NULL,
  value varchar(255) DEFAULT NULL,
  read smallint DEFAULT 0,
  read_inline smallint NOT NULL DEFAULT 0,
  date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (notifications_id)
);

CREATE TABLE IF NOT EXISTS tbl_online_payment (
  online_payment_id serial,
  gateway_name varchar(20) NOT NULL,
  icon text NOT NULL,
  field_1 varchar(100) DEFAULT NULL,
  field_2 varchar(100) DEFAULT NULL,
  field_3 varchar(100) DEFAULT NULL,
  field_4 varchar(100) DEFAULT NULL,
  field_5 varchar(100) DEFAULT NULL,
  link varchar(100) DEFAULT NULL,
  modal varchar(100) DEFAULT NULL,
  PRIMARY KEY (online_payment_id)
);

CREATE TABLE IF NOT EXISTS tbl_opportunities (
  opportunities_id serial,
  opportunity_name varchar(200) DEFAULT NULL,
  close_date date DEFAULT NULL,
  probability integer DEFAULT 0,
  permission text DEFAULT NULL,
  stages varchar(50) DEFAULT NULL,
  notes text DEFAULT NULL,
  PRIMARY KEY (opportunities_id)
);

CREATE TABLE IF NOT EXISTS tbl_opportunities_state_reason (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_outgoing_emails (
  id serial,
  sent_to varchar(64) DEFAULT NULL,
  sent_from varchar(64) DEFAULT NULL,
  subject text DEFAULT NULL,
  message text DEFAULT NULL,
  date_sent timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  delivered integer DEFAULT 0,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_overtime (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_payment_methods (
  payment_methods_id serial,
  method_name varchar(100) DEFAULT NULL,
  PRIMARY KEY (payment_methods_id)
);

CREATE TABLE IF NOT EXISTS tbl_payments (
  payments_id serial,
  invoices_id integer DEFAULT 0,
  trans_id varchar(100) DEFAULT NULL,
  currency varchar(10) DEFAULT NULL,
  amount decimal(18,2) DEFAULT 0.00,
  payment_method integer DEFAULT 0,
  payment_date date DEFAULT NULL,
  created_date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  month_paid varchar(2) DEFAULT NULL,
  year_paid varchar(4) DEFAULT NULL,
  account_id integer NOT NULL DEFAULT 0,
  PRIMARY KEY (payments_id)
);

CREATE TABLE IF NOT EXISTS tbl_performance_apprisal (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_performance_indicator (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_pinaction (
  pinaction_id serial,
  user_id integer NOT NULL,
  module_id integer NOT NULL,
  module_name varchar(30) DEFAULT NULL,
  PRIMARY KEY (pinaction_id)
);

CREATE TABLE IF NOT EXISTS tbl_priority (
  priority_id serial,
  priority varchar(200) DEFAULT NULL,
  PRIMARY KEY (priority_id)
);

CREATE TABLE IF NOT EXISTS tbl_private_chat (
  private_chat_id serial,
  chat_title varchar(500) NOT NULL,
  user_id integer NOT NULL,
  time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (private_chat_id)
);

CREATE TABLE IF NOT EXISTS tbl_private_chat_messages (
  private_chat_messages_id serial,
  private_chat_id integer NOT NULL,
  user_id integer NOT NULL,
  message text NOT NULL,
  message_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (private_chat_messages_id)
);

CREATE TABLE IF NOT EXISTS tbl_private_chat_users (
  private_chat_users_id serial,
  private_chat_id integer NOT NULL,
  user_id integer NOT NULL,
  to_user_id integer NOT NULL,
  active integer NOT NULL,
  unread integer NOT NULL,
  title varchar(200) NOT NULL,
  deleted integer NOT NULL DEFAULT 0,
  PRIMARY KEY (private_chat_users_id)
);

CREATE TABLE IF NOT EXISTS tbl_project (
  project_id serial,
  project_name varchar(200) DEFAULT NULL,
  client_id integer DEFAULT 0,
  progress integer DEFAULT 0,
  start_date date DEFAULT NULL,
  end_date date DEFAULT NULL,
  due_date date DEFAULT NULL,
  project_status varchar(50) DEFAULT NULL,
  permission text DEFAULT NULL,
  category_id integer DEFAULT 0,
  tags text DEFAULT NULL,
  timer_started_by integer DEFAULT 0,
  start_time varchar(50) DEFAULT NULL,
  timer_status varchar(10) DEFAULT 'off',
  description text DEFAULT NULL,
  calculate_progress varchar(100) DEFAULT NULL,
  estimate_hours varchar(100) DEFAULT NULL,
  billing_type varchar(100) DEFAULT NULL,
  alert_overdue smallint NOT NULL DEFAULT 0,
  project_no varchar(100) DEFAULT NULL,
  PRIMARY KEY (project_id)
);

CREATE TABLE IF NOT EXISTS tbl_project_settings (
  settings_id serial,
  settings varchar(100) NOT NULL,
  description varchar(255) NOT NULL,
  PRIMARY KEY (settings_id)
);

CREATE TABLE IF NOT EXISTS tbl_promotions (
  id serial,
  user_id integer NOT NULL,
  designation_id integer NOT NULL,
  from_designations integer NOT NULL,
  promotion_title varchar(190) NOT NULL,
  promotion_date date NOT NULL,
  description varchar(190) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_proposals (
  proposals_id serial,
  reference_no varchar(32) DEFAULT NULL,
  subject varchar(500) DEFAULT NULL,
  module varchar(50) DEFAULT NULL,
  module_id integer DEFAULT 0,
  proposal_date varchar(50) DEFAULT NULL,
  proposal_month varchar(50) NOT NULL,
  proposal_year varchar(20) NOT NULL,
  due_date varchar(40) DEFAULT NULL,
  currency varchar(32) DEFAULT 'USD',
  notes text NOT NULL,
  tax integer NOT NULL DEFAULT 0,
  total_tax varchar(200) NOT NULL,
  status varchar(20) NOT NULL DEFAULT 'draft',
  date_sent varchar(64) DEFAULT NULL,
  proposal_deleted varchar(100) NOT NULL DEFAULT 'No',
  emailed varchar(100) DEFAULT 'No',
  show_client varchar(100) DEFAULT 'No',
  convert varchar(100) NOT NULL DEFAULT 'No',
  convert_module varchar(200) DEFAULT NULL,
  convert_module_id integer DEFAULT 0,
  converted_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  permission text DEFAULT NULL,
  discount_type varchar(100) DEFAULT NULL,
  discount_percent integer NOT NULL DEFAULT 0,
  discount_total decimal(18,2) NOT NULL DEFAULT 0.00,
  user_id integer NOT NULL DEFAULT 0,
  adjustment decimal(18,2) NOT NULL DEFAULT 0.00,
  show_quantity_as varchar(20) DEFAULT NULL,
  allowed_cmments varchar(100) NOT NULL DEFAULT 'Yes',
  alert_overdue smallint DEFAULT 0,
  tags text DEFAULT NULL,
  warehouse_id integer DEFAULT NULL,
  PRIMARY KEY (proposals_id)
);

CREATE TABLE IF NOT EXISTS tbl_proposals_items (
  proposals_items_id serial,
  proposals_id integer NOT NULL,
  item_name varchar(150) DEFAULT 'Item Name',
  item_desc text DEFAULT NULL,
  quantity decimal(10,2) DEFAULT 0.00,
  unit_cost decimal(10,2) DEFAULT 0.00,
  item_tax_rate decimal(10,2) NOT NULL DEFAULT 0.00,
  item_tax_name text DEFAULT NULL,
  item_tax_total decimal(10,2) DEFAULT 0.00,
  total_cost decimal(10,2) DEFAULT 0.00,
  date_saved timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "order" integer DEFAULT 0,
  unit varchar(200) NOT NULL,
  saved_items_id integer DEFAULT 0,
  hsn_code text DEFAULT NULL,
  PRIMARY KEY (proposals_items_id)
);

CREATE TABLE IF NOT EXISTS tbl_purchase_items (
  items_id serial,
  purchase_id integer NOT NULL,
  item_tax_rate decimal(10,2) NOT NULL DEFAULT 0.00,
  item_tax_name text DEFAULT NULL,
  item_tax_total decimal(10,2) NOT NULL DEFAULT 0.00,
  quantity decimal(10,2) DEFAULT 0.00,
  total_cost decimal(10,2) DEFAULT 0.00,
  item_name varchar(255) DEFAULT 'Item Name',
  item_desc text DEFAULT NULL,
  unit_cost decimal(10,2) DEFAULT 0.00,
  "order" integer DEFAULT 0,
  date_saved timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  unit varchar(200) DEFAULT NULL,
  hsn_code text DEFAULT NULL,
  saved_items_id integer DEFAULT 0,
  PRIMARY KEY (items_id)
);

CREATE TABLE IF NOT EXISTS tbl_purchase_payments (
  payments_id serial,
  purchase_id integer DEFAULT NULL,
  trans_id varchar(64) DEFAULT NULL,
  payment_method varchar(64) DEFAULT NULL,
  amount text DEFAULT NULL,
  currency varchar(64) DEFAULT 'USD',
  notes varchar(255) DEFAULT NULL,
  payment_date date DEFAULT NULL,
  month_paid varchar(32) DEFAULT NULL,
  year_paid varchar(32) DEFAULT NULL,
  paid_to integer NOT NULL,
  paid_by integer DEFAULT NULL,
  created_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  account_id integer NOT NULL DEFAULT 0,
  PRIMARY KEY (payments_id)
);

CREATE TABLE IF NOT EXISTS tbl_purchases (
  purchase_id serial,
  supplier_id integer DEFAULT NULL,
  reference_no varchar(100) DEFAULT NULL,
  total decimal(20,2) DEFAULT NULL,
  update_stock varchar(100) DEFAULT 'Yes',
  status varchar(20) DEFAULT NULL,
  emailed varchar(100) DEFAULT NULL,
  date_sent varchar(20) DEFAULT NULL,
  created_by integer DEFAULT NULL,
  user_id integer DEFAULT NULL,
  purchase_date date DEFAULT NULL,
  due_date date DEFAULT NULL,
  discount_type varchar(100) DEFAULT NULL,
  discount_percent decimal(10,2) DEFAULT NULL,
  adjustment decimal(18,2) DEFAULT NULL,
  discount_total decimal(18,2) DEFAULT NULL,
  show_quantity_as varchar(10) DEFAULT NULL,
  permission text DEFAULT NULL,
  created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  total_tax text DEFAULT NULL,
  tax decimal(20,2) DEFAULT NULL,
  notes text DEFAULT NULL,
  tags text DEFAULT NULL,
  warehouse_id integer DEFAULT NULL,
  stock_updated varchar(100) NOT NULL DEFAULT 'No',
  PRIMARY KEY (purchase_id)
);

CREATE TABLE IF NOT EXISTS tbl_quotation_details (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_quotationforms (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_quotations (
  id serial,
  is_convert varchar(100) NOT NULL DEFAULT 'No',
  convert_module varchar(20) DEFAULT NULL,
  convert_module_id integer DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_reminders (
  reminder_id serial,
  description text DEFAULT NULL,
  date timestamp NOT NULL,
  notified varchar(100) NOT NULL DEFAULT 'No',
  module varchar(200) NOT NULL,
  module_id integer NOT NULL,
  user_id varchar(40) NOT NULL,
  notify_by_email varchar(100) NOT NULL DEFAULT 'No',
  created_by integer NOT NULL,
  PRIMARY KEY (reminder_id)
);

CREATE TABLE IF NOT EXISTS tbl_resignations (
  id serial,
  employee_id integer NOT NULL,
  notice_date date NOT NULL,
  resignation_date date NOT NULL,
  description varchar(190) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_return_stock (
  return_stock_id serial,
  invoices_id integer DEFAULT NULL,
  reference_no varchar(100) DEFAULT NULL,
  total decimal(20,2) DEFAULT NULL,
  update_stock varchar(100) DEFAULT 'Yes',
  status varchar(20) DEFAULT NULL,
  emailed varchar(100) DEFAULT NULL,
  date_sent varchar(20) DEFAULT NULL,
  created_by integer DEFAULT NULL,
  user_id integer DEFAULT NULL,
  return_stock_date date DEFAULT NULL,
  due_date date DEFAULT NULL,
  discount_type varchar(100) DEFAULT NULL,
  discount_percent decimal(10,2) DEFAULT NULL,
  adjustment decimal(18,2) DEFAULT NULL,
  discount_total decimal(18,2) DEFAULT NULL,
  show_quantity_as varchar(10) DEFAULT NULL,
  permission text DEFAULT NULL,
  created timestamp DEFAULT NULL,
  total_tax text DEFAULT NULL,
  tax decimal(20,2) DEFAULT NULL,
  notes text DEFAULT NULL,
  module varchar(100) DEFAULT NULL,
  module_id integer DEFAULT NULL,
  main_status varchar(200) DEFAULT NULL,
  warehouse_id integer DEFAULT NULL,
  PRIMARY KEY (return_stock_id)
);

CREATE TABLE IF NOT EXISTS tbl_return_stock_items (
  items_id serial,
  return_stock_id integer NOT NULL,
  item_tax_rate decimal(10,2) NOT NULL DEFAULT 0.00,
  item_tax_name text DEFAULT NULL,
  item_tax_total decimal(10,2) NOT NULL DEFAULT 0.00,
  quantity decimal(10,2) DEFAULT 0.00,
  total_cost decimal(10,2) DEFAULT 0.00,
  item_name varchar(255) DEFAULT 'Item Name',
  item_desc text DEFAULT NULL,
  unit_cost decimal(10,2) DEFAULT 0.00,
  "order" integer DEFAULT 0,
  date_saved timestamp DEFAULT NULL,
  unit varchar(200) DEFAULT NULL,
  hsn_code text DEFAULT NULL,
  saved_items_id integer DEFAULT 0,
  invoice_items_id integer DEFAULT NULL,
  PRIMARY KEY (items_id)
);

CREATE TABLE IF NOT EXISTS tbl_return_stock_payments (
  payments_id serial,
  return_stock_id integer DEFAULT NULL,
  trans_id varchar(64) DEFAULT NULL,
  payment_method varchar(64) DEFAULT NULL,
  amount text DEFAULT NULL,
  currency varchar(64) DEFAULT 'USD',
  notes varchar(255) DEFAULT NULL,
  payment_date date DEFAULT NULL,
  month_paid varchar(32) DEFAULT NULL,
  year_paid varchar(32) DEFAULT NULL,
  module varchar(200) DEFAULT NULL,
  paid_to integer DEFAULT NULL,
  paid_by integer DEFAULT NULL,
  created_date timestamp NULL DEFAULT NULL,
  account_id integer NOT NULL DEFAULT 0,
  PRIMARY KEY (payments_id)
);

CREATE TABLE IF NOT EXISTS tbl_saas_menu (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_salary_allowance (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_salary_deduction (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_salary_payment (
  id serial,
  deduct_from integer NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_salary_payment_allowance (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_salary_payment_deduction (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_salary_payment_details (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_salary_payslip (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_salary_template (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_saved_items (
  saved_items_id serial,
  item_name varchar(200) DEFAULT NULL,
  code varchar(100) DEFAULT NULL,
  permission text DEFAULT NULL,
  tax_rates_id text DEFAULT NULL,
  customer_group_id integer NOT NULL DEFAULT 0,
  unit_type varchar(200) DEFAULT NULL,
  hsn_code text DEFAULT NULL,
  manufacturer_id integer DEFAULT NULL,
  barcode_symbology varchar(50) NOT NULL,
  upload_file text DEFAULT NULL,
  cost_price decimal(20,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (saved_items_id)
);

CREATE TABLE IF NOT EXISTS tbl_sent (
  id serial,
  attach_file text DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_sessions (
  id varchar(128) NOT NULL,
  ip_address varchar(45) NOT NULL,
  timestamp integer NOT NULL DEFAULT 0,
  data text NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_status (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_stock (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_stock_category (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_stock_sub_category (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_suppliers (
  supplier_id serial,
  name varchar(200) DEFAULT NULL,
  mobile varchar(20) DEFAULT NULL,
  phone varchar(20) DEFAULT NULL,
  email varchar(50) DEFAULT NULL,
  address text DEFAULT NULL,
  permission text DEFAULT NULL,
  vat varchar(200) DEFAULT NULL,
  PRIMARY KEY (supplier_id)
);

CREATE TABLE IF NOT EXISTS tbl_tags (
  tag_id serial,
  name varchar(300) DEFAULT NULL,
  style text DEFAULT NULL,
  PRIMARY KEY (tag_id)
);

CREATE TABLE IF NOT EXISTS tbl_task (
  task_id serial,
  task_name varchar(200) DEFAULT NULL,
  project_id integer DEFAULT 0,
  task_status varchar(50) DEFAULT NULL,
  due_date timestamp DEFAULT NULL,
  permission text DEFAULT NULL,
  timer_started_by integer DEFAULT 0,
  start_time varchar(50) DEFAULT NULL,
  tags text DEFAULT NULL,
  timer_status varchar(10) DEFAULT 'off',
  task_progress integer DEFAULT 0,
  index_no integer DEFAULT NULL,
  task_description text DEFAULT NULL,
  task_start_date date DEFAULT NULL,
  task_hour varchar(10) DEFAULT NULL,
  hourly_rate decimal(18,2) DEFAULT 0.00,
  milestones_order integer NOT NULL DEFAULT 0,
  sub_task_id integer DEFAULT NULL,
  calculate_progress varchar(200) DEFAULT NULL,
  transactions_id integer DEFAULT NULL,
  category_id integer DEFAULT NULL,
  module varchar(50) DEFAULT NULL,
  module_field_id integer DEFAULT NULL,
  PRIMARY KEY (task_id)
);

CREATE TABLE IF NOT EXISTS tbl_task_comment (
  id serial,
  attachments_id integer DEFAULT 0,
  comments_reply_id integer NOT NULL DEFAULT 0,
  uploaded_files_id integer DEFAULT 0,
  module varchar(50) DEFAULT NULL,
  module_field_id integer DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_tasks (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_tasks_timer (
  id serial,
  task_id integer DEFAULT NULL,
  timer_status varchar(100) NOT NULL DEFAULT 'off',
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_tax_rates (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_terminations (
  id serial,
  employee_id integer NOT NULL,
  attachment text DEFAULT NULL,
  notice_date date NOT NULL,
  termination_date date NOT NULL,
  termination_type varchar(190) NOT NULL,
  description varchar(190) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_tickets (
  tickets_id serial,
  subject varchar(255) DEFAULT NULL,
  status varchar(50) DEFAULT NULL,
  permission text DEFAULT NULL,
  project_id integer DEFAULT 0,
  email varchar(50) DEFAULT NULL,
  tags text DEFAULT NULL,
  PRIMARY KEY (tickets_id)
);

CREATE TABLE IF NOT EXISTS tbl_tickets_replies (
  id serial,
  ticket_reply_id integer DEFAULT 0,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_todo (
  todo_id serial,
  user_id integer DEFAULT 0,
  created_date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  due_date date DEFAULT NULL,
  title varchar(500) DEFAULT NULL,
  status integer NOT NULL DEFAULT 0,
  assigned integer NOT NULL DEFAULT 0,
  "order" integer DEFAULT 1,
  PRIMARY KEY (todo_id)
);

CREATE TABLE IF NOT EXISTS tbl_total (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_training (
  id serial,
  upload_file text DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_transactions (
  transactions_id serial,
  name varchar(200) DEFAULT NULL,
  type varchar(50) DEFAULT NULL,
  amount decimal(18,2) DEFAULT 0.00,
  date date DEFAULT NULL,
  project_id integer DEFAULT 0,
  permission text DEFAULT NULL,
  account_id integer DEFAULT 0,
  status varchar(100) NOT NULL DEFAULT 'non_approved',
  category_id integer DEFAULT NULL,
  tags text DEFAULT NULL,
  recurring_type varchar(50) DEFAULT NULL,
  payment_methods_id varchar(100) DEFAULT NULL,
  create_date timestamp DEFAULT NULL,
  repeat_every integer DEFAULT NULL,
  recurring varchar(100) DEFAULT NULL,
  total_cycles integer DEFAULT NULL,
  done_cycles integer DEFAULT NULL,
  custom_recurring smallint DEFAULT 0,
  last_recurring_date date DEFAULT NULL,
  recurring_from integer DEFAULT NULL,
  transaction_prefix varchar(50) DEFAULT NULL,
  warehouse_id integer DEFAULT NULL,
  PRIMARY KEY (transactions_id)
);

CREATE TABLE IF NOT EXISTS tbl_transfer (
  id serial,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_transfer_item (
  transfer_item_id serial,
  reference_no varchar(50) DEFAULT NULL,
  date varchar(100) DEFAULT NULL,
  status varchar(100) DEFAULT NULL,
  shipping_cost varchar(100) DEFAULT NULL,
  notes text DEFAULT NULL,
  attachment text DEFAULT NULL,
  from_warehouse_id integer NOT NULL,
  to_warehouse_id integer NOT NULL,
  user_id integer DEFAULT NULL,
  show_quantity_as varchar(20) DEFAULT NULL,
  tax decimal(18,3) DEFAULT NULL,
  total_tax text NOT NULL,
  permission text DEFAULT NULL,
  PRIMARY KEY (transfer_item_id)
);

CREATE TABLE IF NOT EXISTS tbl_transfer_itemlist (
  transfer_itemlist_id serial,
  transfer_item_id integer NOT NULL,
  saved_items_id integer DEFAULT 0,
  warehouse_id integer DEFAULT NULL,
  item_tax_rate decimal(10,2) DEFAULT 0.00,
  item_tax_name text DEFAULT NULL,
  item_name varchar(150) DEFAULT 'Item Name',
  item_desc text DEFAULT NULL,
  unit_cost decimal(10,2) DEFAULT 0.00,
  quantity decimal(10,2) DEFAULT 0.00,
  item_tax_total decimal(10,2) DEFAULT 0.00,
  total_cost decimal(10,2) DEFAULT 0.00,
  date_saved timestamp NOT NULL DEFAULT '2018-12-12 04:00:00',
  unit varchar(200) DEFAULT NULL,
  hsn_code text DEFAULT NULL,
  "order" integer DEFAULT 0,
  PRIMARY KEY (transfer_itemlist_id)
);

CREATE TABLE IF NOT EXISTS tbl_user_role (
  user_role_id serial,
  designations_id integer DEFAULT 0,
  menu_id integer DEFAULT 0,
  view smallint DEFAULT 0,
  created smallint DEFAULT 0,
  edited smallint DEFAULT 0,
  deleted smallint DEFAULT 0,
  PRIMARY KEY (user_role_id)
);

CREATE TABLE IF NOT EXISTS tbl_users (
  user_id serial,
  username varchar(200) NOT NULL,
  password varchar(255) NOT NULL,
  email varchar(200) NOT NULL,
  role_id smallint NOT NULL DEFAULT 3,
  activated smallint NOT NULL DEFAULT 1,
  banned smallint NOT NULL DEFAULT 0,
  ban_reason varchar(255) DEFAULT NULL,
  new_password_key varchar(100) DEFAULT NULL,
  new_pass_key varchar(100) DEFAULT NULL,
  last_ip varchar(45) DEFAULT NULL,
  last_login timestamp DEFAULT NULL,
  created timestamp DEFAULT NULL,
  modified timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  online_time bigint DEFAULT 0,
  permission text DEFAULT NULL,
  PRIMARY KEY (user_id)
);

CREATE TABLE IF NOT EXISTS tbl_warehouse (
  warehouse_id serial,
  warehouse_name varchar(200) DEFAULT NULL,
  permission text DEFAULT NULL,
  PRIMARY KEY (warehouse_id)
);

CREATE TABLE IF NOT EXISTS tbl_warehouses_products (
  id serial,
  product_id integer NOT NULL,
  warehouse_id integer NOT NULL,
  quantity decimal(15,4) NOT NULL,
  rack varchar(55) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_warnings (
  id serial,
  warning_to integer NOT NULL,
  warning_by integer NOT NULL,
  warning_type integer NOT NULL,
  attachment text DEFAULT NULL,
  subject varchar(190) NOT NULL,
  warning_date date NOT NULL,
  description varchar(190) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tbl_working_days (
  working_days_id serial,
  day_id integer DEFAULT 0,
  flag smallint DEFAULT 1,
  start_hours varchar(20) NOT NULL DEFAULT '00:00:00',
  end_hours varchar(20) NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (working_days_id)
);

CREATE TABLE IF NOT EXISTS tbl_workplace (
  id serial,
  PRIMARY KEY (id)
);

INSERT INTO tbl_migrations (version) VALUES (600);

INSERT INTO tbl_config (config_key, value) VALUES
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

INSERT INTO tbl_currencies (code, name, symbol) VALUES
('USD', 'US Dollar', '$'),
('EUR', 'Euro', '€'),
('GBP', 'Pound Sterling', '£'),
('NGN', 'Nigerian Naira', '₦');

INSERT INTO tbl_languages (code, name, icon, active) VALUES
('english', 'English', 'en', 1);

INSERT INTO tbl_migrations (version) VALUES (600);

INSERT INTO tbl_days (day_id, day) VALUES
(1, 'Monday'), (2, 'Tuesday'), (3, 'Wednesday'), (4, 'Thursday'), (5, 'Friday'), (6, 'Saturday'), (7, 'Sunday');

INSERT INTO tbl_working_days (day_id, flag) VALUES
(1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 0), (7, 0);

INSERT INTO tbl_dashboard (id, name, col, order_no, status, report, for_staff) VALUES
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

INSERT INTO tbl_menu (menu_id, label, link, icon, parent, sort, status) VALUES
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


-- app-referenced columns missing from the MySQL source
ALTER TABLE tbl_warehouse     ADD COLUMN IF NOT EXISTS status varchar(20) DEFAULT 'published';
ALTER TABLE tbl_client        ADD COLUMN IF NOT EXISTS language varchar(50) DEFAULT NULL;
ALTER TABLE tbl_client        ADD COLUMN IF NOT EXISTS date_added timestamp DEFAULT NULL;
ALTER TABLE tbl_inbox         ADD COLUMN IF NOT EXISTS inbox_id integer DEFAULT NULL;
ALTER TABLE tbl_job_circular  ADD COLUMN IF NOT EXISTS status varchar(20) DEFAULT 'published';
ALTER TABLE tbl_job_circular  ADD COLUMN IF NOT EXISTS posted_date timestamp DEFAULT NULL;

SELECT setval(pg_get_serial_sequence('tbl_account_details','account_details_id'), COALESCE((SELECT MAX(account_details_id) FROM tbl_account_details), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_accounts','account_id'), COALESCE((SELECT MAX(account_id) FROM tbl_accounts), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_activities','activities_id'), COALESCE((SELECT MAX(activities_id) FROM tbl_activities), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_advance_salary','id'), COALESCE((SELECT MAX(id) FROM tbl_advance_salary), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_allowed_ip','allowed_ip_id'), COALESCE((SELECT MAX(allowed_ip_id) FROM tbl_allowed_ip), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_announcements','announcements_id'), COALESCE((SELECT MAX(announcements_id) FROM tbl_announcements), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_assign_item','id'), COALESCE((SELECT MAX(id) FROM tbl_assign_item), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_attachments','id'), COALESCE((SELECT MAX(id) FROM tbl_attachments), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_attachments_files','id'), COALESCE((SELECT MAX(id) FROM tbl_attachments_files), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_attendance','attendance_id'), COALESCE((SELECT MAX(attendance_id) FROM tbl_attendance), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_award_points','award_points_id'), COALESCE((SELECT MAX(award_points_id) FROM tbl_award_points), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_award_program','award_program_id'), COALESCE((SELECT MAX(award_program_id) FROM tbl_award_program), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_award_rule','award_rule_id'), COALESCE((SELECT MAX(award_rule_id) FROM tbl_award_rule), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_bug','bug_id'), COALESCE((SELECT MAX(bug_id) FROM tbl_bug), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_calls','id'), COALESCE((SELECT MAX(id) FROM tbl_calls), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_card_config','card_config_id'), COALESCE((SELECT MAX(card_config_id) FROM tbl_card_config), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_checklists','checklist_id'), COALESCE((SELECT MAX(checklist_id) FROM tbl_checklists), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_client','client_id'), COALESCE((SELECT MAX(client_id) FROM tbl_client), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_client_menu','menu_id'), COALESCE((SELECT MAX(menu_id) FROM tbl_client_menu), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_client_role','client_role_id'), COALESCE((SELECT MAX(client_role_id) FROM tbl_client_role), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_clock','clock_id'), COALESCE((SELECT MAX(clock_id) FROM tbl_clock), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_clock_history','id'), COALESCE((SELECT MAX(id) FROM tbl_clock_history), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_countries','id'), COALESCE((SELECT MAX(id) FROM tbl_countries), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_credit_note','credit_note_id'), COALESCE((SELECT MAX(credit_note_id) FROM tbl_credit_note), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_credit_note_items','credit_note_items_id'), COALESCE((SELECT MAX(credit_note_items_id) FROM tbl_credit_note_items), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_credit_used','credit_used_id'), COALESCE((SELECT MAX(credit_used_id) FROM tbl_credit_used), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_custom_field','custom_field_id'), COALESCE((SELECT MAX(custom_field_id) FROM tbl_custom_field), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_customer_group','customer_group_id'), COALESCE((SELECT MAX(customer_group_id) FROM tbl_customer_group), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_dashboard','id'), COALESCE((SELECT MAX(id) FROM tbl_dashboard), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_days','day_id'), COALESCE((SELECT MAX(day_id) FROM tbl_days), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_departments','departments_id'), COALESCE((SELECT MAX(departments_id) FROM tbl_departments), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_designations','designations_id'), COALESCE((SELECT MAX(designations_id) FROM tbl_designations), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_draft','id'), COALESCE((SELECT MAX(id) FROM tbl_draft), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_email_templates','id'), COALESCE((SELECT MAX(id) FROM tbl_email_templates), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_employee_award','id'), COALESCE((SELECT MAX(id) FROM tbl_employee_award), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_employee_bank','id'), COALESCE((SELECT MAX(id) FROM tbl_employee_bank), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_employee_document','id'), COALESCE((SELECT MAX(id) FROM tbl_employee_document), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_employee_payroll','id'), COALESCE((SELECT MAX(id) FROM tbl_employee_payroll), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_estimate_items','estimate_items_id'), COALESCE((SELECT MAX(estimate_items_id) FROM tbl_estimate_items), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_estimates','estimates_id'), COALESCE((SELECT MAX(estimates_id) FROM tbl_estimates), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_expense_category','id'), COALESCE((SELECT MAX(id) FROM tbl_expense_category), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_form','form_id'), COALESCE((SELECT MAX(form_id) FROM tbl_form), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_goal_tracking','goal_tracking_id'), COALESCE((SELECT MAX(goal_tracking_id) FROM tbl_goal_tracking), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_goal_type','goal_type_id'), COALESCE((SELECT MAX(goal_type_id) FROM tbl_goal_type), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_holiday','holiday_id'), COALESCE((SELECT MAX(holiday_id) FROM tbl_holiday), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_hourly_rate','id'), COALESCE((SELECT MAX(id) FROM tbl_hourly_rate), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_inbox','id'), COALESCE((SELECT MAX(id) FROM tbl_inbox), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_income_category','id'), COALESCE((SELECT MAX(id) FROM tbl_income_category), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_invoices','invoices_id'), COALESCE((SELECT MAX(invoices_id) FROM tbl_invoices), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_item_history','id'), COALESCE((SELECT MAX(id) FROM tbl_item_history), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_items','items_id'), COALESCE((SELECT MAX(items_id) FROM tbl_items), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_job_appliactions','id'), COALESCE((SELECT MAX(id) FROM tbl_job_appliactions), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_job_circular','id'), COALESCE((SELECT MAX(id) FROM tbl_job_circular), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_kb_category','kb_category_id'), COALESCE((SELECT MAX(kb_category_id) FROM tbl_kb_category), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_knowledgebase','kb_id'), COALESCE((SELECT MAX(kb_id) FROM tbl_knowledgebase), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_languages','language_id'), COALESCE((SELECT MAX(language_id) FROM tbl_languages), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_lead_form','lead_form_id'), COALESCE((SELECT MAX(lead_form_id) FROM tbl_lead_form), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_lead_source','id'), COALESCE((SELECT MAX(id) FROM tbl_lead_source), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_lead_status','id'), COALESCE((SELECT MAX(id) FROM tbl_lead_status), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_leads','leads_id'), COALESCE((SELECT MAX(leads_id) FROM tbl_leads), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_leads_notes','notes_id'), COALESCE((SELECT MAX(notes_id) FROM tbl_leads_notes), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_leave_application','id'), COALESCE((SELECT MAX(id) FROM tbl_leave_application), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_leave_category','id'), COALESCE((SELECT MAX(id) FROM tbl_leave_category), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_locales','id'), COALESCE((SELECT MAX(id) FROM tbl_locales), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_manufacturer','manufacturer_id'), COALESCE((SELECT MAX(manufacturer_id) FROM tbl_manufacturer), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_menu','menu_id'), COALESCE((SELECT MAX(menu_id) FROM tbl_menu), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_mettings','id'), COALESCE((SELECT MAX(id) FROM tbl_mettings), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_milestones','id'), COALESCE((SELECT MAX(id) FROM tbl_milestones), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_modules','module_id'), COALESCE((SELECT MAX(module_id) FROM tbl_modules), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_notes','notes_id'), COALESCE((SELECT MAX(notes_id) FROM tbl_notes), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_notifications','notifications_id'), COALESCE((SELECT MAX(notifications_id) FROM tbl_notifications), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_online_payment','online_payment_id'), COALESCE((SELECT MAX(online_payment_id) FROM tbl_online_payment), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_opportunities','opportunities_id'), COALESCE((SELECT MAX(opportunities_id) FROM tbl_opportunities), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_opportunities_state_reason','id'), COALESCE((SELECT MAX(id) FROM tbl_opportunities_state_reason), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_outgoing_emails','id'), COALESCE((SELECT MAX(id) FROM tbl_outgoing_emails), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_overtime','id'), COALESCE((SELECT MAX(id) FROM tbl_overtime), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_payment_methods','payment_methods_id'), COALESCE((SELECT MAX(payment_methods_id) FROM tbl_payment_methods), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_payments','payments_id'), COALESCE((SELECT MAX(payments_id) FROM tbl_payments), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_performance_apprisal','id'), COALESCE((SELECT MAX(id) FROM tbl_performance_apprisal), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_performance_indicator','id'), COALESCE((SELECT MAX(id) FROM tbl_performance_indicator), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_pinaction','pinaction_id'), COALESCE((SELECT MAX(pinaction_id) FROM tbl_pinaction), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_priority','priority_id'), COALESCE((SELECT MAX(priority_id) FROM tbl_priority), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_private_chat','private_chat_id'), COALESCE((SELECT MAX(private_chat_id) FROM tbl_private_chat), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_private_chat_messages','private_chat_messages_id'), COALESCE((SELECT MAX(private_chat_messages_id) FROM tbl_private_chat_messages), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_private_chat_users','private_chat_users_id'), COALESCE((SELECT MAX(private_chat_users_id) FROM tbl_private_chat_users), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_project','project_id'), COALESCE((SELECT MAX(project_id) FROM tbl_project), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_project_settings','settings_id'), COALESCE((SELECT MAX(settings_id) FROM tbl_project_settings), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_promotions','id'), COALESCE((SELECT MAX(id) FROM tbl_promotions), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_proposals','proposals_id'), COALESCE((SELECT MAX(proposals_id) FROM tbl_proposals), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_proposals_items','proposals_items_id'), COALESCE((SELECT MAX(proposals_items_id) FROM tbl_proposals_items), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_purchase_items','items_id'), COALESCE((SELECT MAX(items_id) FROM tbl_purchase_items), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_purchase_payments','payments_id'), COALESCE((SELECT MAX(payments_id) FROM tbl_purchase_payments), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_purchases','purchase_id'), COALESCE((SELECT MAX(purchase_id) FROM tbl_purchases), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_quotation_details','id'), COALESCE((SELECT MAX(id) FROM tbl_quotation_details), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_quotationforms','id'), COALESCE((SELECT MAX(id) FROM tbl_quotationforms), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_quotations','id'), COALESCE((SELECT MAX(id) FROM tbl_quotations), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_reminders','reminder_id'), COALESCE((SELECT MAX(reminder_id) FROM tbl_reminders), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_resignations','id'), COALESCE((SELECT MAX(id) FROM tbl_resignations), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_return_stock','return_stock_id'), COALESCE((SELECT MAX(return_stock_id) FROM tbl_return_stock), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_return_stock_items','items_id'), COALESCE((SELECT MAX(items_id) FROM tbl_return_stock_items), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_return_stock_payments','payments_id'), COALESCE((SELECT MAX(payments_id) FROM tbl_return_stock_payments), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_saas_menu','id'), COALESCE((SELECT MAX(id) FROM tbl_saas_menu), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_salary_allowance','id'), COALESCE((SELECT MAX(id) FROM tbl_salary_allowance), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_salary_deduction','id'), COALESCE((SELECT MAX(id) FROM tbl_salary_deduction), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_salary_payment','id'), COALESCE((SELECT MAX(id) FROM tbl_salary_payment), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_salary_payment_allowance','id'), COALESCE((SELECT MAX(id) FROM tbl_salary_payment_allowance), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_salary_payment_deduction','id'), COALESCE((SELECT MAX(id) FROM tbl_salary_payment_deduction), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_salary_payment_details','id'), COALESCE((SELECT MAX(id) FROM tbl_salary_payment_details), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_salary_payslip','id'), COALESCE((SELECT MAX(id) FROM tbl_salary_payslip), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_salary_template','id'), COALESCE((SELECT MAX(id) FROM tbl_salary_template), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_saved_items','saved_items_id'), COALESCE((SELECT MAX(saved_items_id) FROM tbl_saved_items), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_sent','id'), COALESCE((SELECT MAX(id) FROM tbl_sent), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_status','id'), COALESCE((SELECT MAX(id) FROM tbl_status), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_stock','id'), COALESCE((SELECT MAX(id) FROM tbl_stock), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_stock_category','id'), COALESCE((SELECT MAX(id) FROM tbl_stock_category), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_stock_sub_category','id'), COALESCE((SELECT MAX(id) FROM tbl_stock_sub_category), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_suppliers','supplier_id'), COALESCE((SELECT MAX(supplier_id) FROM tbl_suppliers), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_tags','tag_id'), COALESCE((SELECT MAX(tag_id) FROM tbl_tags), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_task','task_id'), COALESCE((SELECT MAX(task_id) FROM tbl_task), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_task_comment','id'), COALESCE((SELECT MAX(id) FROM tbl_task_comment), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_tasks','id'), COALESCE((SELECT MAX(id) FROM tbl_tasks), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_tasks_timer','id'), COALESCE((SELECT MAX(id) FROM tbl_tasks_timer), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_tax_rates','id'), COALESCE((SELECT MAX(id) FROM tbl_tax_rates), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_terminations','id'), COALESCE((SELECT MAX(id) FROM tbl_terminations), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_tickets','tickets_id'), COALESCE((SELECT MAX(tickets_id) FROM tbl_tickets), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_tickets_replies','id'), COALESCE((SELECT MAX(id) FROM tbl_tickets_replies), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_todo','todo_id'), COALESCE((SELECT MAX(todo_id) FROM tbl_todo), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_total','id'), COALESCE((SELECT MAX(id) FROM tbl_total), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_training','id'), COALESCE((SELECT MAX(id) FROM tbl_training), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_transactions','transactions_id'), COALESCE((SELECT MAX(transactions_id) FROM tbl_transactions), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_transfer','id'), COALESCE((SELECT MAX(id) FROM tbl_transfer), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_transfer_item','transfer_item_id'), COALESCE((SELECT MAX(transfer_item_id) FROM tbl_transfer_item), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_transfer_itemlist','transfer_itemlist_id'), COALESCE((SELECT MAX(transfer_itemlist_id) FROM tbl_transfer_itemlist), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_user_role','user_role_id'), COALESCE((SELECT MAX(user_role_id) FROM tbl_user_role), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_users','user_id'), COALESCE((SELECT MAX(user_id) FROM tbl_users), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_warehouse','warehouse_id'), COALESCE((SELECT MAX(warehouse_id) FROM tbl_warehouse), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_warehouses_products','id'), COALESCE((SELECT MAX(id) FROM tbl_warehouses_products), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_warnings','id'), COALESCE((SELECT MAX(id) FROM tbl_warnings), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_working_days','working_days_id'), COALESCE((SELECT MAX(working_days_id) FROM tbl_working_days), 0) + 1, false);

SELECT setval(pg_get_serial_sequence('tbl_workplace','id'), COALESCE((SELECT MAX(id) FROM tbl_workplace), 0) + 1, false);


CREATE OR REPLACE FUNCTION touch_modified() RETURNS trigger AS $$
BEGIN NEW.modified = CURRENT_TIMESTAMP; RETURN NEW; END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_tbl_proposals_modified BEFORE UPDATE ON tbl_proposals FOR EACH ROW EXECUTE FUNCTION touch_modified();

CREATE TRIGGER trg_tbl_users_modified BEFORE UPDATE ON tbl_users FOR EACH ROW EXECUTE FUNCTION touch_modified();


-- deferred indexes
CREATE INDEX tbl_account_details_user_id ON tbl_account_details (user_id);
CREATE UNIQUE INDEX tbl_proposals_reference_no ON tbl_proposals (reference_no);
CREATE INDEX tbl_reminders_rel_id ON tbl_reminders (module);
CREATE INDEX tbl_reminders_rel_type ON tbl_reminders (user_id);
CREATE INDEX tbl_sessions_ci_sessions_timestamp ON tbl_sessions (timestamp);
CREATE UNIQUE INDEX tbl_transfer_item_reference_no ON tbl_transfer_item (reference_no);
CREATE UNIQUE INDEX tbl_users_username ON tbl_users (username);
CREATE UNIQUE INDEX tbl_users_email ON tbl_users (email);
CREATE INDEX tbl_warehouses_products_product_id ON tbl_warehouses_products (product_id);
CREATE INDEX tbl_warehouses_products_warehouse_id ON tbl_warehouses_products (warehouse_id);


CREATE OR REPLACE FUNCTION rerp_int_bool_eq(int, boolean) RETURNS boolean AS $$ SELECT $1 = (CASE WHEN $2 THEN 1 ELSE 0 END) $$ LANGUAGE sql IMMUTABLE;
CREATE OPERATOR = (PROCEDURE = rerp_int_bool_eq, LEFTARG = int, RIGHTARG = boolean, COMMUTATOR = =);
CREATE OR REPLACE FUNCTION rerp_int_bool_ne(int, boolean) RETURNS boolean AS $$ SELECT $1 <> (CASE WHEN $2 THEN 1 ELSE 0 END) $$ LANGUAGE sql IMMUTABLE;
CREATE OPERATOR <> (PROCEDURE = rerp_int_bool_ne, LEFTARG = int, RIGHTARG = boolean, NEGATOR = =);

