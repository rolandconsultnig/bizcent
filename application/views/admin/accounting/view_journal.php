<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
        <i class="fa fa-book"></i> Journal Entry Voucher: <strong><?= $journal->entry_number ?></strong>
    </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-6">
            <p><strong>Entry Date:</strong> <?= display_date($journal->entry_date) ?></p>
            <p><strong>Reference:</strong> <?= $journal->reference_no ?: '-' ?></p>
        </div>
        <div class="col-sm-6">
            <p><strong>Created Date:</strong> <?= display_datetime($journal->created_at) ?></p>
            <p><strong>Notes:</strong> <?= $journal->notes ?: '-' ?></p>
        </div>
    </div>

    <h4><i class="fa fa-table"></i> Double-Entry Breakdown</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
            <tr class="bg-gray-lighter">
                <th>Account Code</th>
                <th>Account Name</th>
                <th>Memo / Description</th>
                <th class="text-right">Debit</th>
                <th class="text-right">Credit</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($items)): foreach ($items as $it): ?>
                <tr>
                    <td><strong><?= $it->account_code ?></strong></td>
                    <td><?= $it->account_name ?> <span class="label label-default"><?= ucfirst($it->account_type) ?></span></td>
                    <td><?= $it->memo ?: '-' ?></td>
                    <td class="text-right"><?= $it->debit > 0 ? display_money($it->debit) : '-' ?></td>
                    <td class="text-right"><?= $it->credit > 0 ? display_money($it->credit) : '-' ?></td>
                </tr>
            <?php endforeach; endif; ?>
            <tr class="bg-gray-lighter" style="font-size: 15px;">
                <td colspan="3" class="text-right"><strong>Totals:</strong></td>
                <td class="text-right"><strong class="text-success"><?= display_money($journal->total_debit) ?></strong></td>
                <td class="text-right"><strong class="text-success"><?= display_money($journal->total_credit) ?></strong></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
