<div class="panel panel-custom">
    <div class="panel-heading">
        <div class="panel-title">
            <strong><i class="fa fa-table"></i> <?= lang('general_ledger') ?></strong>
        </div>
    </div>
    <div class="panel-body">
        <form method="get" action="<?= base_url('admin/accounting/general_ledger') ?>" class="form-inline bg-gray-lighter" style="padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <div class="form-group">
                <label>Select Account: </label>
                <select name="account_id" class="form-control select_box" style="min-width: 250px;">
                    <option value="">-- Choose Account --</option>
                    <?php if (!empty($accounts)): foreach ($accounts as $acc): ?>
                        <option value="<?= $acc->account_id ?>" <?= ($selected_account_id == $acc->account_id) ? 'selected' : '' ?>><?= $acc->account_code ?> - <?= $acc->account_name ?> (<?= ucfirst($acc->account_type) ?>)</option>
                    <?php endforeach; endif; ?>
                </select>
            </div>
            <div class="form-group" style="margin-left: 15px;">
                <label>From: </label>
                <input type="text" name="start_date" class="form-control datepicker" value="<?= $start_date ?>">
            </div>
            <div class="form-group" style="margin-left: 15px;">
                <label>To: </label>
                <input type="text" name="end_date" class="form-control datepicker" value="<?= $end_date ?>">
            </div>
            <button type="submit" class="btn btn-primary" style="margin-left: 15px;"><i class="fa fa-filter"></i> Filter Ledger</button>
        </form>

        <?php if (!empty($account)): ?>
            <div class="well well-sm" style="background:#fff; border-left: 4px solid #5d9cec;">
                <h4 style="margin: 0 0 5px 0;"><strong><?= $account->account_code ?> - <?= $account->account_name ?></strong></h4>
                <p style="margin: 0;">Account Type: <span class="label label-info"><?= strtoupper($account->account_type) ?></span> | Current Balance: <strong class="text-primary"><?= display_money($account->balance) ?></strong></p>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr class="bg-gray-lighter">
                        <th>Date</th>
                        <th>Entry No</th>
                        <th>Reference</th>
                        <th>Memo / Description</th>
                        <th class="text-right">Debit</th>
                        <th class="text-right">Credit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($transactions)): foreach ($transactions as $tx): ?>
                        <tr>
                            <td><?= display_date($tx->entry_date) ?></td>
                            <td><strong><a data-toggle="modal" data-target="#myModal_lg" href="<?= base_url('admin/accounting/view_journal/' . $tx->journal_id) ?>"><?= $tx->entry_number ?></a></strong></td>
                            <td><?= $tx->reference_no ?: '-' ?></td>
                            <td><?= $tx->memo ?: $tx->notes ?: '-' ?></td>
                            <td class="text-right"><?= $tx->debit > 0 ? display_money($tx->debit) : '-' ?></td>
                            <td class="text-right"><?= $tx->credit > 0 ? display_money($tx->credit) : '-' ?></td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="6" class="text-center text-muted">No journal transactions recorded for this account in the selected date range.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> Please select an account above to view its detailed ledger transactions and debit/credit history.
            </div>
        <?php endif; ?>
    </div>
</div>
