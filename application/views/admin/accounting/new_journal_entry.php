<?= message_box('error'); ?>

<div class="panel panel-custom">
    <div class="panel-heading">
        <div class="panel-title">
            <strong><i class="fa fa-pencil"></i> Create Double-Entry Journal Voucher</strong>
            <div class="pull-right">
                <a href="<?= base_url('admin/accounting/journal_entries') ?>" class="btn btn-xs btn-default">
                    <i class="fa fa-arrow-left"></i> Back to Journal Entries
                </a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <form method="post" action="<?= base_url('admin/accounting/save_journal_entry') ?>" class="form-horizontal">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?= lang('entry_date') ?> <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="entry_date" required class="form-control datepicker" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Reference No</label>
                        <div class="col-sm-8">
                            <input type="text" name="reference_no" placeholder="e.g. INV-1049, RCP-5501" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Notes</label>
                        <div class="col-sm-8">
                            <input type="text" name="notes" placeholder="Transaction memo / explanation" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <h4><i class="fa fa-balance-scale"></i> Journal Entry Lines (Double-Entry Bookkeeping)</h4>
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> Every journal entry must have balancing total debits and total credits.
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="jv_table">
                    <thead>
                    <tr class="bg-gray-lighter">
                        <th width="40%">Account <span class="text-danger">*</span></th>
                        <th width="25%">Description / Memo</th>
                        <th width="15%" class="text-right">Debit <span class="text-danger">*</span></th>
                        <th width="15%" class="text-right">Credit <span class="text-danger">*</span></th>
                        <th width="5%"></th>
                    </tr>
                    </thead>
                    <tbody id="jv_body">
                    <?php for ($i = 0; $i < 2; $i++): ?>
                        <tr>
                            <td>
                                <select name="account_id[]" class="form-control select_box" required style="width: 100%;">
                                    <option value="">Select Account</option>
                                    <?php if (!empty($accounts)): foreach ($accounts as $acc): ?>
                                        <option value="<?= $acc->account_id ?>"><?= $acc->account_code ?> - <?= $acc->account_name ?> (<?= ucfirst($acc->account_type) ?>)</option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </td>
                            <td><input type="text" name="memo[]" placeholder="Line memo" class="form-control"></td>
                            <td><input type="number" step="0.01" name="debit[]" value="0.00" class="form-control text-right jv-calc jv-debit"></td>
                            <td><input type="number" step="0.01" name="credit[]" value="0.00" class="form-control text-right jv-calc jv-credit"></td>
                            <td><button type="button" class="btn btn-danger btn-xs remove-row"><i class="fa fa-trash"></i></button></td>
                        </tr>
                    <?php endfor; ?>
                    </tbody>
                    <tfoot>
                    <tr class="bg-gray-lighter" style="font-size: 15px;">
                        <td colspan="2" class="text-right"><strong>Totals:</strong></td>
                        <td class="text-right"><strong id="total_debit_display">$0.00</strong></td>
                        <td class="text-right"><strong id="total_credit_display">$0.00</strong></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <span id="balance_status" class="label label-danger" style="font-size: 13px;">Out of Balance by $0.00</span>
                        </td>
                    </tr>
                    </tfoot>
                </table>
                <button type="button" id="add_jv_line" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Add Account Line</button>
            </div>

            <hr>
            <div class="form-group">
                <div class="col-sm-12 text-center">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-check-circle"></i> Post Journal Entry</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    function recalcTotals() {
        var totalDeb = 0;
        var totalCred = 0;
        $('.jv-debit').each(function() {
            var v = parseFloat($(this).val()) || 0;
            totalDeb += v;
        });
        $('.jv-credit').each(function() {
            var v = parseFloat($(this).val()) || 0;
            totalCred += v;
        });

        $('#total_debit_display').text('$' + totalDeb.toFixed(2));
        $('#total_credit_display').text('$' + totalCred.toFixed(2));

        var diff = Math.abs(totalDeb - totalCred);
        if (diff < 0.001 && totalDeb > 0) {
            $('#balance_status').removeClass('label-danger').addClass('label-success').text('Balanced (Debits = Credits)');
        } else {
            $('#balance_status').removeClass('label-success').addClass('label-danger').text('Out of Balance by $' + diff.toFixed(2));
        }
    }

    $(document).on('input change', '.jv-calc', function() {
        recalcTotals();
    });

    $('#add_jv_line').click(function() {
        var options = '<?= addslashes(implode('', array_map(function($acc) { return '<option value="' . $acc->account_id . '">' . $acc->account_code . ' - ' . addslashes($acc->account_name) . ' (' . ucfirst($acc->account_type) . ')</option>'; }, $accounts))) ?>';
        var row = '<tr>' +
            '<td><select name="account_id[]" class="form-control" required><option value="">Select Account</option>' + options + '</select></td>' +
            '<td><input type="text" name="memo[]" placeholder="Line memo" class="form-control"></td>' +
            '<td><input type="number" step="0.01" name="debit[]" value="0.00" class="form-control text-right jv-calc jv-debit"></td>' +
            '<td><input type="number" step="0.01" name="credit[]" value="0.00" class="form-control text-right jv-calc jv-credit"></td>' +
            '<td><button type="button" class="btn btn-danger btn-xs remove-row"><i class="fa fa-trash"></i></button></td>' +
            '</tr>';
        $('#jv_body').append(row);
    });

    $(document).on('click', '.remove-row', function() {
        if ($('#jv_body tr').length > 2) {
            $(this).closest('tr').remove();
            recalcTotals();
        }
    });

    recalcTotals();
});
</script>
