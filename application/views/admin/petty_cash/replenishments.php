<?= message_box('success'); ?>
<?= message_box('error'); ?>

<div class="panel panel-custom">
    <div class="panel-heading">
        <div class="panel-title">
            <strong><i class="fa fa-refresh"></i> <?= lang('replenishments') ?> (Petty Cash Float Replenishment)</strong>
            <div class="pull-right">
                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addReplenishModal">
                    <i class="fa fa-plus"></i> Request Replenishment
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="DataTables">
                <thead>
                <tr class="bg-gray-lighter">
                    <th>Ref No</th>
                    <th>Date Requested</th>
                    <th>Petty Cash Box</th>
                    <th>Requested By</th>
                    <th class="text-right">Amount</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($replenishments)): foreach ($replenishments as $r): ?>
                    <tr>
                        <td><strong><?= $r->ref_no ?></strong></td>
                        <td><?= display_datetime($r->created_at) ?></td>
                        <td><?= $r->account_name ?></td>
                        <td><?= $r->requester_name ?: 'Custodian' ?></td>
                        <td class="text-right"><strong class="text-primary"><?= display_money($r->requested_amount) ?></strong></td>
                        <td><?= $r->reason ?: '-' ?></td>
                        <td>
                            <?php
                            $cls = 'label-warning';
                            if ($r->status == 'approved') $cls = 'label-success';
                            elseif ($r->status == 'rejected') $cls = 'label-danger';
                            ?>
                            <span class="label <?= $cls ?>"><?= strtoupper($r->status) ?></span>
                        </td>
                        <td>
                            <?php if ($r->status == 'pending'): ?>
                                <a class="btn btn-xs btn-success" href="<?= base_url('admin/petty_cash/change_replenishment_status/' . $r->replenishment_id . '/approved') ?>" onclick="return confirm('Approve this cash replenishment and credit the petty cash box?');"><i class="fa fa-check"></i> Approve</a>
                                <a class="btn btn-xs btn-danger" href="<?= base_url('admin/petty_cash/change_replenishment_status/' . $r->replenishment_id . '/rejected') ?>" onclick="return confirm('Reject this replenishment request?');"><i class="fa fa-times"></i> Reject</a>
                            <?php else: ?>
                                <span class="text-muted"><i class="fa fa-check-circle"></i> Completed</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addReplenishModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?= base_url('admin/petty_cash/save_replenishment') ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-refresh"></i> Request Petty Cash Float Replenishment</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Petty Cash Box <span class="text-danger">*</span></label>
                        <select name="petty_account_id" class="form-control" required>
                            <?php if (!empty($accounts)): foreach ($accounts as $acc): ?>
                                <option value="<?= $acc->petty_account_id ?>"><?= $acc->account_name ?> (Current Balance: <?= display_money($acc->current_balance) ?> / Limit: <?= display_money($acc->float_limit) ?>)</option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Requested Replenishment Amount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="requested_amount" required placeholder="Amount to top up into cash box" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Reason / Notes</label>
                        <textarea name="reason" rows="2" class="form-control" placeholder="Float exhausted due to regular office expenses"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Submit Request</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
