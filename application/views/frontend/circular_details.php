<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<?php if (!empty($circular_details)):
$last_date = $circular_details->last_date;
$current_time = date('Y-m-d');
$is_expired = false;
if (!empty($last_date) && $current_time > $last_date) {
    $is_expired = true;
    $ribon = 'danger';
    $text = lang('expired');
} else {
    $ribon = 'success';
    if (!empty($last_date)) {
        $datetime1 = new DateTime($current_time);
        $datetime2 = new DateTime($last_date);
        $interval = $datetime1->diff($datetime2);
        $text = $interval->format('%a') . ' ' . lang('days') . ' ' . lang('left');
    } else {
        $text = lang('active');
    }
}
$designation = '-';
if (!empty($circular_details->designations_id)) {
    $design_info = $this->db->where('designations_id', $circular_details->designations_id)->get('tbl_designations')->row();
    if (!empty($design_info)) {
        $designation = $design_info->designations;
    }
}

// Clean Word and HTML artifacts
$clean_description = clean_job_html($circular_details->description);
?>

<style>
.job-detail-header {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 30px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.job-detail-title {
    font-size: 24px;
    font-weight: 700;
    color: #0f172a;
    margin-top: 0;
    margin-bottom: 8px;
    letter-spacing: -0.01em;
}
.job-detail-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 28px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.job-sidebar-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.job-sidebar-item {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
}
.job-sidebar-item:last-child {
    border-bottom: none;
}
.job-sidebar-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: #eff6ff;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-size: 15px;
    flex-shrink: 0;
}
.job-sidebar-label {
    font-size: 12px;
    color: #64748b;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.03em;
}
.job-sidebar-value {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
}
.job-content {
    font-size: 15px;
    line-height: 1.75;
    color: #334155;
}
.job-content h1, .job-content h2, .job-content h3, .job-content h4 {
    color: #0f172a;
    font-weight: 700;
    margin-top: 24px;
    margin-bottom: 12px;
}
.job-content ul, .job-content ol {
    padding-left: 20px;
    margin-bottom: 16px;
}
.job-content li {
    margin-bottom: 8px;
}
.btn-apply-primary {
    background: #2563eb;
    color: #ffffff !important;
    font-weight: 600;
    font-size: 15px;
    border-radius: 10px;
    padding: 12px 24px;
    text-align: center;
    display: block;
    width: 100%;
    transition: all 0.15s ease;
    border: none;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    text-decoration: none !important;
}
.btn-apply-primary:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
}
</style>

<div class="job-detail-header">
    <div class="row">
        <div class="col-md-8">
            <a href="<?= base_url() ?>career" class="text-muted" style="font-size: 13px; margin-bottom: 8px; display: inline-block;">
                <i class="fa fa-arrow-left"></i> <?= lang('back') ?> <?= lang('to') ?> <?= lang('all_job_circular') ?>
            </a>
            <h1 class="job-detail-title"><?= htmlspecialchars($circular_details->job_title) ?></h1>
            <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center; margin-top: 10px;">
                <span class="label label-info" style="font-size: 12px; padding: 5px 10px; border-radius: 6px;">
                    <i class="fa fa-id-badge"></i> <?= htmlspecialchars($designation) ?>
                </span>
                <span class="label label-<?= $ribon ?>" style="font-size: 12px; padding: 5px 10px; border-radius: 6px;">
                    <i class="fa fa-clock-o"></i> <?= $text ?>
                </span>
                <span class="label label-default" style="font-size: 12px; padding: 5px 10px; border-radius: 6px;">
                    <i class="fa fa-briefcase"></i> <?= lang($circular_details->employment_type) ?>
                </span>
            </div>
        </div>
        <div class="col-md-4 text-right" style="padding-top: 15px;">
            <?= btn_pdf('frontend/jobs_posted_pdf/' . $circular_details->job_circular_id) ?>
        </div>
    </div>
</div>

<div class="row">
    <!-- Main Description -->
    <div class="col-md-8">
        <div class="job-detail-card">
            <h3 style="margin-top: 0; margin-bottom: 18px; font-weight: 700; color: #0f172a; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
                <i class="fa fa-file-text-o text-primary" style="margin-right: 6px;"></i> Job Description & Overview
            </h3>

            <div class="job-content">
                <?= $clean_description ?>
            </div>

            <?php
            $show_custom_fields = custom_form_label(14, $circular_details->job_circular_id);
            if (!empty($show_custom_fields)): ?>
                <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid #f1f5f9;">
                    <h4 style="font-weight: 600; color: #0f172a; margin-bottom: 12px;">Additional Information</h4>
                    <?php foreach ($show_custom_fields as $c_label => $v_fields):
                        if (!empty($v_fields)): ?>
                            <p style="margin-bottom: 6px;"><strong><?= $c_label ?>:</strong> <?= $v_fields ?></p>
                        <?php endif;
                    endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sidebar Job Summary -->
    <div class="col-md-4">
        <div class="job-sidebar-card">
            <h4 style="margin-top: 0; margin-bottom: 16px; font-weight: 700; color: #0f172a;">
                <i class="fa fa-info-circle text-primary" style="margin-right: 6px;"></i> Position Overview
            </h4>

            <div class="job-sidebar-item">
                <div class="job-sidebar-icon"><i class="fa fa-briefcase"></i></div>
                <div>
                    <div class="job-sidebar-label"><?= lang('employment_type') ?></div>
                    <div class="job-sidebar-value"><?= lang($circular_details->employment_type) ?></div>
                </div>
            </div>

            <div class="job-sidebar-item">
                <div class="job-sidebar-icon"><i class="fa fa-users"></i></div>
                <div>
                    <div class="job-sidebar-label"><?= lang('vacancy_no') ?></div>
                    <div class="job-sidebar-value"><?= $circular_details->vacancy_no ?> Position(s)</div>
                </div>
            </div>

            <div class="job-sidebar-item">
                <div class="job-sidebar-icon"><i class="fa fa-graduation-cap"></i></div>
                <div>
                    <div class="job-sidebar-label"><?= lang('experience') ?></div>
                    <div class="job-sidebar-value"><?= htmlspecialchars($circular_details->experience) ?></div>
                </div>
            </div>

            <div class="job-sidebar-item">
                <div class="job-sidebar-icon"><i class="fa fa-user"></i></div>
                <div>
                    <div class="job-sidebar-label"><?= lang('age') ?></div>
                    <div class="job-sidebar-value"><?= htmlspecialchars($circular_details->age) ?></div>
                </div>
            </div>

            <div class="job-sidebar-item">
                <div class="job-sidebar-icon"><i class="fa fa-money"></i></div>
                <div>
                    <div class="job-sidebar-label"><?= lang('salary_range') ?></div>
                    <div class="job-sidebar-value"><?= !empty($circular_details->salary_range) ? htmlspecialchars($circular_details->salary_range) : 'Competitive' ?></div>
                </div>
            </div>

            <div class="job-sidebar-item">
                <div class="job-sidebar-icon"><i class="fa fa-calendar-check-o"></i></div>
                <div>
                    <div class="job-sidebar-label"><?= lang('posted_date') ?></div>
                    <div class="job-sidebar-value"><?= display_date($circular_details->posted_date) ?></div>
                </div>
            </div>

            <div class="job-sidebar-item">
                <div class="job-sidebar-icon"><i class="fa fa-calendar-times-o"></i></div>
                <div>
                    <div class="job-sidebar-label"><?= lang('last_date') ?></div>
                    <div class="job-sidebar-value"><?= display_date($circular_details->last_date) ?></div>
                </div>
            </div>

            <div style="margin-top: 24px;">
                <?php if (!$is_expired): ?>
                    <a class="btn-apply-primary" data-toggle="modal" data-target="#myModal_lg" href="<?= base_url() ?>frontend/apply_jobs/<?= $circular_details->job_circular_id ?>">
                        <i class="fa fa-paper-plane" style="margin-right: 6px;"></i> <?= lang('apply_now') ?>
                    </a>
                <?php else: ?>
                    <button class="btn btn-default btn-block disabled" style="padding: 12px; font-weight: 600;" disabled>
                        <i class="fa fa-ban" style="margin-right: 4px;"></i> <?= lang('expired') ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>
