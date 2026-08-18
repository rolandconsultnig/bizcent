<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<style>
.career-hero {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border-radius: 16px;
    padding: 36px 30px;
    margin-bottom: 30px;
    color: #ffffff;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
}
.career-hero h2 {
    color: #ffffff;
    font-weight: 700;
    margin-top: 0;
    margin-bottom: 8px;
    letter-spacing: -0.02em;
}
.career-hero p {
    color: #94a3b8;
    font-size: 15px;
    margin-bottom: 0;
}
.job-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 24px;
    margin-bottom: 24px;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    display: flex;
    flex-direction: column;
    height: calc(100% - 24px);
}
.job-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
    border-color: #cbd5e1;
}
.job-card-title {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    margin-top: 0;
    margin-bottom: 6px;
    line-height: 1.35;
}
.job-card-title a {
    color: #0f172a;
    text-decoration: none;
    transition: color 0.15s;
}
.job-card-title a:hover {
    color: #3b82f6;
}
.job-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 600;
    gap: 4px;
}
.job-badge-primary {
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #dbeafe;
}
.job-badge-success {
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid #dcfce7;
}
.job-badge-warning {
    background: #fefce8;
    color: #ca8a04;
    border: 1px solid #fef9c3;
}
.job-meta-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px 12px;
    margin: 14px 0;
    padding: 12px 0;
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    color: #64748b;
}
.job-meta-item strong {
    color: #334155;
}
.job-description-preview {
    font-size: 13.5px;
    line-height: 1.6;
    color: #475569;
    margin-bottom: 18px;
    flex-grow: 1;
}
.btn-apply-card {
    background: #2563eb;
    color: #ffffff !important;
    font-weight: 600;
    font-size: 13.5px;
    border-radius: 8px;
    padding: 9px 16px;
    text-align: center;
    display: inline-block;
    width: 100%;
    transition: all 0.15s ease;
    border: none;
    text-decoration: none !important;
}
.btn-apply-card:hover {
    background: #1d4ed8;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}
</style>

<div class="career-hero">
    <h2><i class="fa fa-briefcase" style="margin-right: 8px; color: #60a5fa;"></i><?= lang('job_posted_list') ?></h2>
    <p>Explore current career opportunities and join our growing team. Find the position that fits your skillset.</p>
</div>

<div class="row">
    <?php
    $all_job_circular = $this->db->where('status', 'published')->order_by('posted_date', 'DESC')->get('tbl_job_circular')->result();

    if (!empty($all_job_circular)): foreach ($all_job_circular as $v_job_circular):
        $last_date = $v_job_circular->last_date;
        $current_time = date('Y-m-d');
        $is_expired = false;
        if (!empty($last_date) && $current_time > $last_date) {
            $is_expired = true;
            $badge_class = 'job-badge-warning';
            $badge_text = lang('expired');
        } else {
            $badge_class = 'job-badge-success';
            if (!empty($last_date)) {
                $datetime1 = new DateTime($current_time);
                $datetime2 = new DateTime($last_date);
                $interval = $datetime1->diff($datetime2);
                $badge_text = $interval->format('%a') . ' ' . lang('days') . ' ' . lang('left');
            } else {
                $badge_text = lang('active');
            }
        }

        $designation = '-';
        if (!empty($v_job_circular->designations_id)) {
            $design_info = $this->db->where('designations_id', $v_job_circular->designations_id)->get('tbl_designations')->row();
            if (!empty($design_info->designations)) {
                $designation = $design_info->designations;
            }
        }

        // Clean Microsoft Word and raw artifacts
        $clean_desc = clean_job_html($v_job_circular->description);
        $plain_text = strip_tags($clean_desc);
        $preview_len = 220;
        $desc_preview = (mb_strlen($plain_text) > $preview_len) ? mb_substr($plain_text, 0, $preview_len) . '...' : $plain_text;
        ?>
        <div class="col-md-6 col-lg-4" style="display: flex;">
            <div class="job-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                    <span class="job-badge job-badge-primary">
                        <i class="fa fa-id-badge"></i> <?= htmlspecialchars($designation) ?>
                    </span>
                    <span class="job-badge <?= $badge_class ?>">
                        <i class="fa fa-clock-o"></i> <?= $badge_text ?>
                    </span>
                </div>

                <h3 class="job-card-title">
                    <a href="<?= base_url() ?>frontend/circular_details/<?= $v_job_circular->job_circular_id ?>">
                        <?= htmlspecialchars($v_job_circular->job_title) ?>
                    </a>
                </h3>

                <div class="job-meta-grid">
                    <div class="job-meta-item">
                        <i class="fa fa-briefcase text-muted"></i> <strong>Type:</strong> <?= lang($v_job_circular->employment_type) ?>
                    </div>
                    <div class="job-meta-item">
                        <i class="fa fa-users text-muted"></i> <strong>Vacancy:</strong> <?= $v_job_circular->vacancy_no ?>
                    </div>
                    <div class="job-meta-item">
                        <i class="fa fa-graduation-cap text-muted"></i> <strong>Exp:</strong> <?= htmlspecialchars($v_job_circular->experience) ?>
                    </div>
                    <div class="job-meta-item">
                        <i class="fa fa-money text-muted"></i> <strong>Salary:</strong> <?= !empty($v_job_circular->salary_range) ? htmlspecialchars($v_job_circular->salary_range) : 'Competitive' ?>
                    </div>
                </div>

                <div class="job-description-preview">
                    <?= nl2br(htmlspecialchars($desc_preview)) ?>
                </div>

                <div>
                    <a href="<?= base_url() ?>frontend/circular_details/<?= $v_job_circular->job_circular_id ?>" class="btn-apply-card">
                        <?= lang('view_circular_details') ?> & <?= lang('apply_now') ?> <i class="fa fa-arrow-right" style="margin-left: 4px;"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; else: ?>
        <div class="col-xs-12">
            <div class="panel widget" style="border-radius: 12px; padding: 48px 20px; text-align: center; background: #ffffff; border: 1px dashed #cbd5e1;">
                <div style="font-size: 48px; color: #94a3b8; margin-bottom: 12px;"><i class="fa fa-folder-open-o"></i></div>
                <h4 style="font-weight: 600; color: #475569;"><?= lang('nothing_to_display') ?></h4>
                <p style="color: #94a3b8; font-size: 14px;">There are currently no active job openings available. Please check back later.</p>
            </div>
        </div>
    <?php endif; ?>
</div>
