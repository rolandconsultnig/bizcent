<?= message_box('success'); ?>
<?= message_box('error'); ?>

<div class="panel panel-custom">
    <div class="panel-heading">
        <div class="panel-title">
            <strong><i class="fa fa-university"></i> <?= lang('petty_cash_accounts') ?></strong>
            <div class="pull-right">
                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addPettyAccountModal">
                    <i class="fa fa-plus"></i> Add Petty Cash Box
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr class="bg-gray-lighter">
                    <th>Account Name</th>
                    <th>Designated Custodian</th>
                    <th class="text-right">Float Limit</th>
                    <th class="text-right">Current Cash Balance</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($accounts)): foreach ($accounts as $acc): ?>
                    <tr>
                        <td><strong><?= $acc->account_name ?></strong></td>
                        <td><?= $acc->custodian_name ?: 'Office Administrator' ?></td>
                        <td class="text-right"><?= display_money($acc->float_limit) ?></td>
                        <td class="text-right"><strong class="text-success" style="font-size: 15px;"><?= display_money($acc->current_balance) ?></strong></td>
                        <td><span class="label label-success">ACTIVE</span></td>
                        <td>
                            <a class="btn btn-xs btn-default" href="<?= base_url('admin/petty_cash/reconciliation?account_id=' . $acc->petty_account_id) ?>"><i class="fa fa-history"></i> Reconciliation Log</a>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="6" class="text-center text-muted">No petty cash accounts configured yet.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addPettyAccountModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?= base_url('admin/petty_cash/save_account') ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> New Petty Cash Account</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Account / Box Name <span class="text-danger">*</span></label>
                        <input type="text" name="account_name" required placeholder="e.g. Front Desk Petty Cash Fund" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Custodian (Staff In-Charge) <span class="text-danger">*</span></label>
                        <select name="custodian_id" class="form-control" required>
                            <?php if (!empty($users)): foreach ($users as $u): ?>
                                <option value="<?= $u->user_id ?>"><?= $u->username ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Float Limit <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="float_limit" value="1000.00" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Initial Opening Cash Balance <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="current_balance" value="1000.00" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Account</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
