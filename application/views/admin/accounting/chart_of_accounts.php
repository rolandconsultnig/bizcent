<?= message_box('success'); ?>
<?= message_box('error'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-custom">
            <div class="panel-heading">
                <div class="panel-title">
                    <strong><i class="fa fa-sitemap"></i> <?= lang('chart_of_accounts') ?> (COA)</strong>
                    <div class="pull-right">
                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addAccountModal">
                            <i class="fa fa-plus"></i> Add Account
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_assets" aria-controls="tab_assets" role="tab" data-toggle="tab"><i class="fa fa-building"></i> Assets (1000s)</a></li>
                    <li role="presentation"><a href="#tab_liabilities" aria-controls="tab_liabilities" role="tab" data-toggle="tab"><i class="fa fa-credit-card"></i> Liabilities (2000s)</a></li>
                    <li role="presentation"><a href="#tab_equity" aria-controls="tab_equity" role="tab" data-toggle="tab"><i class="fa fa-pie-chart"></i> Equity (3000s)</a></li>
                    <li role="presentation"><a href="#tab_revenue" aria-controls="tab_revenue" role="tab" data-toggle="tab"><i class="fa fa-line-chart text-success"></i> Revenue (4000s)</a></li>
                    <li role="presentation"><a href="#tab_expenses" aria-controls="tab_expenses" role="tab" data-toggle="tab"><i class="fa fa-shopping-cart text-danger"></i> Expenses (5000s)</a></li>
                </ul>

                <div class="tab-content" style="padding-top: 15px;">
                    <!-- Assets -->
                    <div role="tabpanel" class="tab-pane active" id="tab_assets">
                        <?= render_coa_table($assets, 'asset'); ?>
                    </div>
                    <!-- Liabilities -->
                    <div role="tabpanel" class="tab-pane" id="tab_liabilities">
                        <?= render_coa_table($liabilities, 'liability'); ?>
                    </div>
                    <!-- Equity -->
                    <div role="tabpanel" class="tab-pane" id="tab_equity">
                        <?= render_coa_table($equity, 'equity'); ?>
                    </div>
                    <!-- Revenue -->
                    <div role="tabpanel" class="tab-pane" id="tab_revenue">
                        <?= render_coa_table($revenue, 'revenue'); ?>
                    </div>
                    <!-- Expenses -->
                    <div role="tabpanel" class="tab-pane" id="tab_expenses">
                        <?= render_coa_table($expenses, 'expense'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function render_coa_table($accounts, $type) {
    $html = '<div class="table-responsive"><table class="table table-striped table-bordered">';
    $html .= '<thead><tr class="bg-gray-lighter"><th>Account Code</th><th>Account Name</th><th>Type</th><th class="text-right">Balance</th><th>Action</th></tr></thead><tbody>';
    if (!empty($accounts)) {
        $total = 0;
        foreach ($accounts as $acc) {
            $total += $acc->balance;
            $html .= '<tr>';
            $html .= '<td><strong>' . $acc->account_code . '</strong></td>';
            $html .= '<td>' . $acc->account_name . '</td>';
            $html .= '<td><span class="label label-default">' . strtoupper($acc->account_type) . '</span></td>';
            $html .= '<td class="text-right"><strong>' . display_money($acc->balance) . '</strong></td>';
            $html .= '<td><a class="btn btn-xs btn-default" href="' . base_url('admin/accounting/general_ledger?account_id=' . $acc->account_id) . '"><i class="fa fa-book"></i> Ledger</a></td>';
            $html .= '</tr>';
        }
        $html .= '<tr class="bg-gray-lighter"><td colspan="3" class="text-right"><strong>Total ' . ucfirst($type) . ' Balance:</strong></td><td class="text-right"><strong>' . display_money($total) . '</strong></td><td></td></tr>';
    } else {
        $html .= '<tr><td colspan="5" class="text-center text-muted">No accounts registered under this category.</td></tr>';
    }
    $html .= '</tbody></table></div>';
    return $html;
}
?>

<!-- Add Account Modal -->
<div class="modal fade" id="addAccountModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?= base_url('admin/accounting/save_account') ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Account to Chart of Accounts</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Account Code <span class="text-danger">*</span></label>
                        <input type="text" name="account_code" required placeholder="e.g. 1040, 2030, 5080" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Account Name <span class="text-danger">*</span></label>
                        <input type="text" name="account_name" required placeholder="e.g. Software Subscriptions Expense" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Account Type <span class="text-danger">*</span></label>
                        <select name="account_type" class="form-control" required>
                            <option value="asset">Asset (1000s)</option>
                            <option value="liability">Liability (2000s)</option>
                            <option value="equity">Equity (3000s)</option>
                            <option value="revenue">Revenue / Income (4000s)</option>
                            <option value="expense">Expense (5000s)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Opening Balance</label>
                        <input type="number" step="0.01" name="balance" value="0.00" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Description / Notes</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
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
