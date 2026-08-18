<?= message_box('success'); ?>
<?= message_box('error'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-custom">
            <div class="panel-heading">
                <div class="panel-title">
                    <strong><i class="fa fa-check-square-o"></i> Unified Corporate Approvals Hub</strong>
                </div>
            </div>
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_req" role="tab" data-toggle="tab"><i class="fa fa-shopping-basket"></i> Staff Requisitions <span class="badge badge-info"><?= count($pending_requisitions) ?></span></a></li>
                    <li role="presentation"><a href="#tab_petty" role="tab" data-toggle="tab"><i class="fa fa-refresh"></i> Petty Cash Replenishments <span class="badge badge-warning"><?= count($pending_replenishments) ?></span></a></li>
                    <li role="presentation"><a href="#tab_leave" role="tab" data-toggle="tab"><i class="fa fa-calendar-times-o"></i> Leave Applications <span class="badge badge-primary"><?= count($pending_leaves) ?></span></a></li>
                    <li role="presentation"><a href="#tab_adv" role="tab" data-toggle="tab"><i class="fa fa-money"></i> Advance Salary <span class="badge badge-purple"><?= count($pending_advances) ?></span></a></li>
                </ul>

                <div class="tab-content" style="padding-top: 15px;">
                    <!-- Staff Requisitions -->
                    <div role="tabpanel" class="tab-pane active" id="tab_req">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr class="bg-gray-lighter">
                                    <th>Req No</th>
                                    <th>Staff</th>
                                    <th>Department</th>
                                    <th>Title</th>
                                    <th>Priority</th>
                                    <th class="text-right">Total Amount</th>
                                    <th>Submitted Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($pending_requisitions)): foreach ($pending_requisitions as $r): ?>
                                    <tr>
                                        <td><strong><a data-toggle="modal" data-target="#myModal_lg" href="<?= base_url('admin/requisition/view_details/' . $r->requisition_id) ?>"><?= $r->requisition_no ?></a></strong></td>
                                        <td><?= $r->fullname ?: 'Staff' ?></td>
                                        <td><?= $r->deptname ?: 'General' ?></td>
                                        <td><?= $r->title ?></td>
                                        <td><span class="label label-warning"><?= strtoupper($r->priority) ?></span></td>
                                        <td class="text-right"><strong class="text-primary"><?= display_money($r->total_amount) ?></strong></td>
                                        <td><?= display_datetime($r->created_at) ?></td>
                                        <td class="text-center">
                                            <a data-toggle="modal" data-target="#myModal_lg" class="btn btn-info btn-xs" href="<?= base_url('admin/requisition/view_details/' . $r->requisition_id) ?>" title="View"><i class="fa fa-eye"></i></a>
                                            <a class="btn btn-success btn-xs" href="<?= base_url('admin/approvals/action_item/requisition/' . $r->requisition_id . '/approve') ?>" onclick="return confirm('Approve this requisition?');"><i class="fa fa-check"></i> Approve</a>
                                            <a class="btn btn-danger btn-xs" href="<?= base_url('admin/approvals/action_item/requisition/' . $r->requisition_id . '/reject') ?>" onclick="return confirm('Reject this requisition?');"><i class="fa fa-times"></i> Reject</a>
                                        </td>
                                    </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="8" class="text-center text-muted"><i class="fa fa-check-circle text-success"></i> No pending staff requisitions awaiting review.</td></tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Petty Cash Replenishments -->
                    <div role="tabpanel" class="tab-pane" id="tab_petty">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr class="bg-gray-lighter">
                                    <th>Ref No</th>
                                    <th>Petty Cash Box</th>
                                    <th>Requested By</th>
                                    <th class="text-right">Amount</th>
                                    <th>Reason</th>
                                    <th>Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($pending_replenishments)): foreach ($pending_replenishments as $p): ?>
                                    <tr>
                                        <td><strong><?= $p->ref_no ?></strong></td>
                                        <td><?= $p->account_name ?></td>
                                        <td><?= $p->requester_name ?: 'Custodian' ?></td>
                                        <td class="text-right"><strong class="text-success"><?= display_money($p->requested_amount) ?></strong></td>
                                        <td><?= $p->reason ?: '-' ?></td>
                                        <td><?= display_datetime($p->created_at) ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-success btn-xs" href="<?= base_url('admin/approvals/action_item/replenishment/' . $p->replenishment_id . '/approve') ?>" onclick="return confirm('Approve float replenishment?');"><i class="fa fa-check"></i> Approve</a>
                                            <a class="btn btn-danger btn-xs" href="<?= base_url('admin/approvals/action_item/replenishment/' . $p->replenishment_id . '/reject') ?>" onclick="return confirm('Reject replenishment?');"><i class="fa fa-times"></i> Reject</a>
                                        </td>
                                    </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="7" class="text-center text-muted"><i class="fa fa-check-circle text-success"></i> No pending petty cash replenishment requests.</td></tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Leave Applications -->
                    <div role="tabpanel" class="tab-pane" id="tab_leave">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr class="bg-gray-lighter">
                                    <th>Staff Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Reason</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($pending_leaves)): foreach ($pending_leaves as $l): ?>
                                    <tr>
                                        <td><?= $l->fullname ?></td>
                                        <td><?= display_date($l->leave_start_date) ?></td>
                                        <td><?= display_date($l->leave_end_date) ?></td>
                                        <td><?= $l->reason ?: '-' ?></td>
                                        <td>
                                            <a class="btn btn-primary btn-xs" href="<?= base_url('admin/leave_management/index/view_details/' . $l->leave_application_id) ?>"><i class="fa fa-eye"></i> Review Application</a>
                                        </td>
                                    </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="5" class="text-center text-muted"><i class="fa fa-check-circle text-success"></i> No pending leave applications.</td></tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Advance Salary -->
                    <div role="tabpanel" class="tab-pane" id="tab_adv">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr class="bg-gray-lighter">
                                    <th>Staff Name</th>
                                    <th class="text-right">Amount</th>
                                    <th>Deduct Month</th>
                                    <th>Reason</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($pending_advances)): foreach ($pending_advances as $a): ?>
                                    <tr>
                                        <td><?= $a->fullname ?></td>
                                        <td class="text-right"><strong><?= display_money($a->advance_amount) ?></strong></td>
                                        <td><?= $a->deduct_month ?></td>
                                        <td><?= $a->reason ?: '-' ?></td>
                                        <td>
                                            <a class="btn btn-primary btn-xs" href="<?= base_url('admin/payroll/advance_salary') ?>"><i class="fa fa-eye"></i> Manage Advance</a>
                                        </td>
                                    </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="5" class="text-center text-muted"><i class="fa fa-check-circle text-success"></i> No pending advance salary requests.</td></tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
