<?= message_box('success'); ?>
<?= message_box('error'); ?>

<div class="panel panel-custom">
    <div class="panel-heading">
        <div class="panel-title">
            <strong><i class="fa fa-list-alt"></i> <?= lang('all_requisitions') ?> (Department & Staff Requests)</strong>
            <div class="pull-right">
                <a href="<?= base_url('admin/requisition/new_requisition') ?>" class="btn btn-xs btn-primary">
                    <i class="fa fa-plus"></i> <?= lang('new_requisition') ?>
                </a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="DataTables">
                <thead>
                <tr>
                    <th><?= lang('requisition_no') ?></th>
                    <th><?= lang('staff') ?></th>
                    <th><?= lang('title') ?></th>
                    <th><?= lang('department') ?></th>
                    <th><?= lang('priority') ?></th>
                    <th><?= lang('total_amount') ?></th>
                    <th><?= lang('expected_date') ?></th>
                    <th><?= lang('status') ?></th>
                    <th><?= lang('action') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($all_requisitions)): foreach ($all_requisitions as $v_req): ?>
                    <tr>
                        <td><strong><a data-toggle="modal" data-target="#myModal_lg" href="<?= base_url('admin/requisition/view_details/' . $v_req->requisition_id) ?>"><?= $v_req->requisition_no ?></a></strong></td>
                        <td><?= $v_req->fullname ?: 'Staff' ?></td>
                        <td><?= $v_req->title ?></td>
                        <td><span class="label label-info"><?= $v_req->deptname ?: 'General' ?></span></td>
                        <td>
                            <?php
                            $p_cls = 'label-default';
                            if ($v_req->priority == 'urgent') $p_cls = 'label-danger';
                            elseif ($v_req->priority == 'high') $p_cls = 'label-warning';
                            elseif ($v_req->priority == 'medium') $p_cls = 'label-primary';
                            ?>
                            <span class="label <?= $p_cls ?>"><?= strtoupper($v_req->priority) ?></span>
                        </td>
                        <td><strong><?= display_money($v_req->total_amount) ?></strong></td>
                        <td><?= display_date($v_req->expected_date) ?></td>
                        <td>
                            <?php
                            $s_cls = 'label-warning';
                            if ($v_req->status == 'approved') $s_cls = 'label-success';
                            elseif ($v_req->status == 'rejected') $s_cls = 'label-danger';
                            elseif ($v_req->status == 'fulfilled') $s_cls = 'label-purple';
                            ?>
                            <span class="label <?= $s_cls ?>"><?= strtoupper($v_req->status) ?></span>
                        </td>
                        <td>
                            <a data-toggle="modal" data-target="#myModal_lg" class="btn btn-info btn-xs" href="<?= base_url('admin/requisition/view_details/' . $v_req->requisition_id) ?>" title="Review / Action"><i class="fa fa-eye"></i></a>
                            <?php if ($v_req->status == 'pending'): ?>
                                <a class="btn btn-success btn-xs" href="<?= base_url('admin/requisition/change_status/' . $v_req->requisition_id . '/approved') ?>" onclick="return confirm('Approve this requisition?');" title="Approve"><i class="fa fa-check"></i></a>
                                <a class="btn btn-danger btn-xs" href="<?= base_url('admin/requisition/change_status/' . $v_req->requisition_id . '/rejected') ?>" onclick="return confirm('Reject this requisition?');" title="Reject"><i class="fa fa-times"></i></a>
                            <?php elseif ($v_req->status == 'approved'): ?>
                                <a class="btn btn-purple btn-xs" href="<?= base_url('admin/requisition/change_status/' . $v_req->requisition_id . '/fulfilled') ?>" onclick="return confirm('Mark items as received / fulfilled?');" title="Mark Fulfilled"><i class="fa fa-truck"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
