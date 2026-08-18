<style>
    .settings-nav-group {
        margin-bottom: 18px;
    }
    .settings-group-title {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #8892a0;
        font-weight: 700;
        padding: 6px 12px;
        margin-bottom: 4px;
        background: #f8fafc;
        border-radius: 6px;
        border-left: 3px solid #23b7e5;
    }
    .settings-group-nav {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }
    .settings-group-nav li a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 6px;
        color: #4c5a67;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.15s;
        margin-bottom: 2px;
    }
    .settings-group-nav li a:hover {
        background-color: #f1f4f8;
        color: #23b7e5;
    }
    .settings-group-nav li.active a {
        background-color: #23b7e5;
        color: #ffffff;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(35, 183, 229, 0.35);
    }
    .settings-group-nav li.active a i {
        color: #ffffff;
    }
    .settings-group-nav li a i {
        font-size: 14px;
        width: 16px;
        text-align: center;
        color: #8892a0;
    }
</style>

<div class="row">
    <!-- Left Categorized Navigation Sidebar -->
    <div class="col-md-3">
        <div class="panel panel-custom">
            <div class="panel-heading" style="padding: 12px 15px; border-bottom: 1px solid #edf1f2;">
                <div class="panel-title" style="font-size: 14px; font-weight: 700;">
                    <i class="fa fa-cogs text-primary"></i> <?= lang('settings') ?>
                </div>
            </div>
            <div class="panel-body" style="padding: 12px; max-height: 82vh; overflow-y: auto;">
                <?php
                $settings_categories = [
                    '🏢 General & Branding' => [
                        'company_details' => ['link' => 'admin/settings', 'icon' => 'fa fa-building-o', 'key' => 'general'],
                        'system_settings' => ['link' => 'admin/settings/system', 'icon' => 'fa fa-sliders', 'key' => 'system'],
                        'theme_settings' => ['link' => 'admin/settings/theme', 'icon' => 'fa fa-paint-brush', 'key' => 'theme'],
                        'translations' => ['link' => 'admin/settings/translations', 'icon' => 'fa fa-language', 'key' => 'translations']
                    ],
                    '📧 Communication & Alerts' => [
                        'email_settings' => ['link' => 'admin/settings/email', 'icon' => 'fa fa-envelope-o', 'key' => 'email'],
                        'email_notification' => ['link' => 'admin/settings/email_notification', 'icon' => 'fa fa-bell-o', 'key' => 'email_notification'],
                        'email_integration' => ['link' => 'admin/settings/email_integration', 'icon' => 'fa fa-inbox', 'key' => 'email_integration'],
                        'sms_settings' => ['link' => 'admin/settings/sms_settings', 'icon' => 'fa fa-commenting-o', 'key' => 'sms_settings'],
                        'templates' => ['link' => 'admin/settings/templates', 'icon' => 'fa fa-file-code-o', 'key' => 'templates']
                    ],
                    '💰 Finance & Invoicing' => [
                        'all_currency' => ['link' => 'admin/settings/all_currency', 'icon' => 'fa fa-money', 'key' => 'all_currency'],
                        'payment_method' => ['link' => 'admin/settings/payment_method', 'icon' => 'fa fa-credit-card', 'key' => 'payment_method'],
                        'payments' => ['link' => 'admin/settings/payments', 'icon' => 'fa fa-paypal', 'key' => 'payments'],
                        'invoice_settings' => ['link' => 'admin/settings/invoice', 'icon' => 'fa fa-file-text-o', 'key' => 'invoice'],
                        'estimate_settings' => ['link' => 'admin/settings/estimate', 'icon' => 'fa fa-calculator', 'key' => 'estimate'],
                        'proposal_settings' => ['link' => 'admin/settings/proposals', 'icon' => 'fa fa-paperclip', 'key' => 'proposals'],
                        'income_category' => ['link' => 'admin/settings/income_category', 'icon' => 'fa fa-tags', 'key' => 'income_category'],
                        'expense_category' => ['link' => 'admin/settings/expense_category', 'icon' => 'fa fa-tags', 'key' => 'expense_category']
                    ],
                    '👥 HRM & Workplace Policies' => [
                        'working_days' => ['link' => 'admin/settings/working_days', 'icon' => 'fa fa-calendar-check-o', 'key' => 'working_days'],
                        'leave_category' => ['link' => 'admin/settings/leave_category', 'icon' => 'fa fa-calendar-times-o', 'key' => 'leave_category'],
                        'allowed_ip' => ['link' => 'admin/settings/allowed_ip', 'icon' => 'fa fa-shield', 'key' => 'allowed_ip'],
                        'customer_group' => ['link' => 'admin/settings/customer_group', 'icon' => 'fa fa-users', 'key' => 'customer_group'],
                        'lead_source' => ['link' => 'admin/settings/lead_source', 'icon' => 'fa fa-filter', 'key' => 'lead_source'],
                        'lead_status' => ['link' => 'admin/settings/lead_status', 'icon' => 'fa fa-tasks', 'key' => 'lead_status']
                    ],
                    '🔒 System & Maintenance' => [
                        'custom_field' => ['link' => 'admin/settings/custom_field', 'icon' => 'fa fa-plus-square-o', 'key' => 'custom_field'],
                        'database_backup' => ['link' => 'admin/settings/database_backup', 'icon' => 'fa fa-database', 'key' => 'database_backup'],
                        'cronjob' => ['link' => 'admin/settings/cronjob', 'icon' => 'fa fa-clock-o', 'key' => 'cronjob'],
                        'tags' => ['link' => 'admin/settings/tags', 'icon' => 'fa fa-tag', 'key' => 'tags'],
                        'tickets' => ['link' => 'admin/settings/tickets', 'icon' => 'fa fa-ticket', 'key' => 'tickets'],
                        'projects' => ['link' => 'admin/settings/projects', 'icon' => 'fa fa-folder-open-o', 'key' => 'projects'],
                        'calendar_settings' => ['link' => 'admin/settings/calendar_settings', 'icon' => 'fa fa-calendar', 'key' => 'calendar_settings']
                    ]
                ];

                $last_segment = end($this->uri->segments);
                if ($last_segment == 'settings' || empty($last_segment)) {
                    $last_segment = 'general';
                }

                foreach ($settings_categories as $cat_title => $items) {
                    echo '<div class="settings-nav-group">';
                    echo '<div class="settings-group-title">' . $cat_title . '</div>';
                    echo '<ul class="settings-group-nav">';
                    foreach ($items as $label => $data) {
                        $is_active = ($data['key'] == $last_segment || ($data['key'] == 'general' && $last_segment == 'settings'));
                        $active_class = $is_active ? 'active' : '';
                        $lbl_text = lang($label) ?: ucwords(str_replace('_', ' ', $label));
                        echo '<li class="' . $active_class . '">';
                        echo '<a href="' . base_url($data['link']) . '">';
                        echo '<i class="' . $data['icon'] . '"></i>';
                        echo '<span>' . $lbl_text . '</span>';
                        echo '</a>';
                        echo '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Right Settings Content Panel -->
    <div class="col-md-9">
        <?php
        $load = explode('/', $load_setting);
        if (!empty($load[1])) {
            $this->load->view($load_setting);
        } else {
            $this->load->view('admin/settings/' . $load_setting);
        }
        ?>
    </div>
</div>