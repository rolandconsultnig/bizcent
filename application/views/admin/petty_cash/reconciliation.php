<div class="panel panel-custom">
    <div class="panel-heading">
        <div class="panel-title">
            <strong><i class="fa fa-history"></i> <?= lang('reconciliation_log') ?> & Audit Statement</strong>
            <div class="pull-right">
                <button type="button" class="btn btn-xs btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print Statement</button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <form method="get" action="<?= base_url('admin/petty_cash/reconciliation') ?>" class="form-inline bg-gray-lighter" style="padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <div class="form-group">
                <label>Select Petty Cash Box: </label>
                <select name="account_id" class="form-control select_box" style="min-width: 250px;">
                    <?php if (!empty($accounts)): foreach ($accounts as $acc): ?>
                        <option value="<?= $acc->petty_account_id ?>" <?= ($selected_account_id == $acc->petty_account_id) ? 'selected' : '' ?>><?= $acc->account_name ?></option>
                    <?php endforeach; endif; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-left: 15px;"><i class="fa fa-filter"></i> Load Audit Log</button>
        </form>

        <?php if (!empty($account)): ?>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-sm-4">
                    <div class="well well-sm" style="background:#fff; border-left: 4px solid #5d9cec;">
                        <small class="text-muted">Account Name</small>
                        <h4 style="margin: 3px 0 0 0;"><strong><?= $account->account_name ?></strong></h4>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="well well-sm" style="background:#fff; border-left: 4px solid #f05050;">
                        <small class="text-muted">Float Limit</small>
                        <h4 style="margin: 3px 0 0 0;"><strong><?= display_money($account->float_limit) ?></strong></h4>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="well well-sm" style="background:#fff; border-left: 4px solid #27c24c;">
                        <small class="text-muted">Current Physical Cash Balance</small>
                        <h4 style="margin: 3px 0 0 0;"><strong class="text-success"><?= display_money($account->current_balance) ?></strong></h4>
                    </div>
                </div>
            </div>

            <!-- Disbursements Table -->
            <h4><i class="fa fa-arrow-circle-down text-danger"></i> Cash Disbursements (Vouchers)</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr class="bg-gray-lighter">
                        <th>Voucher No</th>
                        <th>Date</th>
                        <th>Payee</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th class="text-right">Amount Disbursed</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $tot_vouch = 0; if (!empty($vouchers)): foreach ($vouchers as $v): $tot_vouch += $v->amount; ?>
                        <tr>
                            <td><strong><?= $v->voucher_no ?></strong></td>
                            <td><?= display_date($v->date) ?></td>
                            <td><?= $v->payee ?></td>
                            <td><span class="label label-info"><?= $v->category ?></span></td>
                            <td><?= $v->description ?: '-' ?></td>
                            <td class="text-right"><strong class="text-danger"><?= display_money($v->amount) ?></strong></td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="6" class="text-center text-muted">No disbursement vouchers recorded yet.</td></tr>
                    <?php endif; ?>
                    <tr class="bg-gray-lighter">
                        <td colspan="5" class="text-right"><strong>Total Disbursed:</strong></td>
                        <td class="text-right"><strong class="text-danger"><?= display_money($tot_vouch) ?></strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Replenishments Table -->
            <h4 style="margin-top: 30px;"><i class="fa fa-arrow-circle-up text-success"></i> Float Replenishments</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr class="bg-gray-lighter">
                        <th>Ref No</th>
                        <th>Date Approved</th>
                        <th>Reason</th>
                        <th class="text-right">Amount Replenished</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $tot_rep = 0; if (!empty($replenishments)): foreach ($replenishments as $r): $tot_rep += $r->requested_amount; ?>
                        <tr>
                            <td><strong><?= $r->ref_no ?></strong></td>
                            <td><?= display_datetime($r->approved_date) ?></td>
                            <td><?= $r->reason ?: '-' ?></td>
                            <td class="text-right"><strong class="text-success"><?= display_money($r->requested_amount) ?></strong></td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="4" class="text-center text-muted">No float replenishments recorded yet.</td></tr>
                    <?php endif; ?>
                    <tr class="bg-gray-lighter">
                        <td colspan="3" class="text-right"><strong>Total Replenished:</strong></td>
                        <td class="text-right"><strong class="text-success"><?= display_money($tot_rep) ?></strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
