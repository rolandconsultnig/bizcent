<?php
if (!empty($circular_info->designations_id)) {
    $design_info = $this->db->where('designations_id', $circular_info->designations_id)->get('tbl_designations')->row();
    $designation = $design_info->designations;
} else {
    $designation = '-';
}
?>
<div class="panel panel-custom">
    <div class="panel-heading">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                class="sr-only">Close</span></button>
        <div class="panel-title">
            <strong><?= $circular_info->job_title . ' ( ' . $designation . ' ) ' ?></strong>
        </div>
    </div>
    <div class="panel-body form-horizontal">
        <form method="post" data-parsley-validate="" novalidate=""
              action="<?php echo base_url() ?>frontend/save_job_application/<?php echo $circular_info->job_circular_id; ?>"
              class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= lang('name') ?> <span class="required"> *</span></label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <span class="input-group-addon" id=""><i class="fa fa-user"></i></span>
                        <input required type="text"  name="name" class="form-control"
                               placeholder="<?= lang('enter') . ' ' . lang('fullname') ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= lang('email') ?> <span class="required"> *</span></label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <span class="input-group-addon" id=""><i class="fa fa-envelope"></i></span>
                        <input required type="text" data-parsley-type="email" name="email" class="form-control"
                               placeholder="<?= lang('enter') . ' ' . lang('email') . ' ' . lang('address') ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= lang('mobile') ?> <span class="required"> *</span></label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <span class="input-group-addon" id=""><i class="fa fa-phone"></i></span>
                        <input required type="text" data-parsley-type="number" name="mobile" class="form-control"
                               placeholder="<?= lang('enter') . ' ' . lang('mobile') . ' ' . lang('number') ?> ">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= lang('cover_later') ?> </label>
                <div class="col-sm-9">
                    <textarea name="cover_letter" class="form-control" rows="4" placeholder="Briefly describe your background, skills, and why you are a great fit for this role..."></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= lang('resume') ?> / Credentials <span class="required"> *</span></label>
                <div class="col-sm-9">
                    <input required type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx,.zip,.rar">
                    <small class="text-muted"><i class="fa fa-info-circle"></i> Supported formats: PDF, DOC, DOCX, ZIP (Max 10MB)</small>
                </div>
            </div>
            <div class="margin pull-right" style="margin-top: 15px;">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
                <button id="btn_emp" type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> <?= lang('apply_now') ?></button>
            </div>
        </form>

    </div>
</div>
