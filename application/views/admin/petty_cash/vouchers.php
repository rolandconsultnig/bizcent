<?= message_box('success'); ?>
<?= message_box('error'); ?>

<div class="panel panel-custom">
    <div class="panel-heading">
        <div class="panel-title">
            <strong><i class="fa fa-file-text-o"></i> <?= lang('petty_cash_vouchers') ?> (Cash Disbursements)</strong>
            <div class="pull-right">
                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addVoucherModal">
                    <i class="fa fa-plus"></i> Record Cash Voucher
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="DataTables">
                <thead>
                <tr class="bg-gray-lighter">
                    <th><?= lang('voucher_no') ?></th>
                    <th>Date</th>
                    <th>Petty Cash Box</th>
                    <th>Payee</th>
                    <th>Category</th>
                    <th class="text-right">Amount</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($vouchers)): foreach ($vouchers as $v): ?>
                    <tr>
                        <td><strong><?= $v->voucher_no ?></strong></td>
                        <td><?= display_date($v->date) ?></td>
                        <td><?= $v->account_name ?></td>
                        <td><strong><?= $v->payee ?></strong></td>
                        <td><span class="label label-info"><?= $v->category ?></span></td>
                        <td class="text-right"><strong class="text-danger"><?= display_money($v->amount) ?></strong></td>
                        <td><?= $v->description ?: '-' ?></td>
                        <td><span class="label label-success"><?= strtoupper($v->status) ?></span></td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addVoucherModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?= base_url('admin/petty_cash/save_voucher') ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-money"></i> Issue Petty Cash Disbursement Voucher</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Petty Cash Account <span class="text-danger">*</span></label>
                        <select name="petty_account_id" class="form-control" required>
                            <?php if (!empty($accounts)): foreach ($accounts as $acc): ?>
                                <option value="<?= $acc->petty_account_id ?>"><?= $acc->account_name ?> (Balance: <?= display_money($acc->current_balance) ?>)</option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date <span class="text-danger">*</span></label>
                        <input type="text" name="date" class="form-control datepicker" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Payee (Recipient) <span class="text-danger">*</span></label>
                        <input type="text" name="payee" required placeholder="Person or Vendor paid" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Expense Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-control" required>
                            <option value="Office Supplies">Office Supplies & Stationery</option>
                            <option value="Postage & Courier">Postage & Courier Services</option>
                            <option value="Refreshments & Hospitality">Refreshments & Staff Hospitality</option>
                            <option value="Local Transport & Taxi">Local Transport & Taxi / Fuel</option>
                            <option value="Repairs & Maintenance">Minor Repairs & Maintenance</option>
                            <option value="Cleaning & Sanitation">Cleaning & Sanitation Supplies</option>
                            <option value="Sundry Expenses">Sundry / Miscellaneous Expenses</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount (Cash Paid) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" required placeholder="0.00" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Purpose / Description</label>
                        <textarea name="description" rows="2" class="form-control" placeholder="Explanation of expense"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Issue Voucher & Deduct Cash</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
