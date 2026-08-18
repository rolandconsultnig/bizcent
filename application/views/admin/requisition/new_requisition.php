<div class="panel panel-custom">
    <div class="panel-heading">
        <div class="panel-title">
            <strong><i class="fa fa-pencil-square-o"></i> <?= !empty($requisition) ? 'Edit Requisition' : lang('new_requisition') ?></strong>
            <div class="pull-right">
                <a href="<?= base_url('admin/requisition/my_requisitions') ?>" class="btn btn-xs btn-default">
                    <i class="fa fa-arrow-left"></i> Back to My Requisitions
                </a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <form method="post" action="<?= base_url('admin/requisition/save_requisition/' . (!empty($requisition) ? $requisition->requisition_id : '')) ?>" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= lang('title') ?> <span class="text-danger">*</span></label>
                <div class="col-sm-7">
                    <input type="text" name="title" required value="<?= !empty($requisition) ? $requisition->title : '' ?>" placeholder="e.g. Office Supplies for Marketing Team, Dual Monitors, Travel Expenses" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?= lang('department') ?></label>
                <div class="col-sm-4">
                    <select name="departments_id" class="form-control select_box">
                        <option value="">Select Department</option>
                        <?php if (!empty($all_departments)): foreach ($all_departments as $d): ?>
                            <option value="<?= $d->departments_id ?>" <?= (!empty($requisition) && $requisition->departments_id == $d->departments_id) ? 'selected' : '' ?>><?= $d->deptname ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?= lang('priority') ?></label>
                <div class="col-sm-3">
                    <select name="priority" class="form-control select_box">
                        <option value="low" <?= (!empty($requisition) && $requisition->priority == 'low') ? 'selected' : '' ?>>Low</option>
                        <option value="medium" <?= (empty($requisition) || $requisition->priority == 'medium') ? 'selected' : '' ?>>Medium</option>
                        <option value="high" <?= (!empty($requisition) && $requisition->priority == 'high') ? 'selected' : '' ?>>High</option>
                        <option value="urgent" <?= (!empty($requisition) && $requisition->priority == 'urgent') ? 'selected' : '' ?>>Urgent</option>
                    </select>
                </div>
                <label class="col-sm-2 control-label"><?= lang('expected_date') ?></label>
                <div class="col-sm-2">
                    <input type="text" name="expected_date" class="form-control datepicker" value="<?= !empty($requisition) ? $requisition->expected_date : date('Y-m-d', strtotime('+7 days')) ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?= lang('purpose') ?></label>
                <div class="col-sm-7">
                    <textarea name="purpose" rows="3" class="form-control" placeholder="Justification or business rationale for this requisition..."><?= !empty($requisition) ? $requisition->purpose : '' ?></textarea>
                </div>
            </div>

            <hr>
            <h4><i class="fa fa-list"></i> Requisition Items</h4>
            <div class="table-responsive">
                <table class="table table-bordered" id="req_items_table">
                    <thead>
                    <tr class="bg-gray-lighter">
                        <th width="30%">Item Name <span class="text-danger">*</span></th>
                        <th width="30%">Description / Specs</th>
                        <th width="10%">Qty</th>
                        <th width="10%">Unit</th>
                        <th width="15%">Est. Unit Price</th>
                        <th width="5%"></th>
                    </tr>
                    </thead>
                    <tbody id="req_items_body">
                    <?php if (!empty($requisition_items)): foreach ($requisition_items as $item): ?>
                        <tr>
                            <td><input type="text" name="item_name[]" class="form-control" required value="<?= $item->item_name ?>"></td>
                            <td><input type="text" name="item_desc[]" class="form-control" value="<?= $item->description ?>"></td>
                            <td><input type="number" step="any" name="quantity[]" class="form-control req-calc" value="<?= $item->quantity ?>"></td>
                            <td><input type="text" name="unit[]" class="form-control" value="<?= $item->unit ?>"></td>
                            <td><input type="number" step="0.01" name="unit_price[]" class="form-control req-calc" value="<?= $item->unit_price ?>"></td>
                            <td><button type="button" class="btn btn-danger btn-xs remove-row"><i class="fa fa-trash"></i></button></td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td><input type="text" name="item_name[]" class="form-control" required placeholder="Item / Service Name"></td>
                            <td><input type="text" name="item_desc[]" class="form-control" placeholder="Description or specifications"></td>
                            <td><input type="number" step="any" name="quantity[]" class="form-control req-calc" value="1"></td>
                            <td><input type="text" name="unit[]" class="form-control" value="pcs"></td>
                            <td><input type="number" step="0.01" name="unit_price[]" class="form-control req-calc" value="0.00"></td>
                            <td><button type="button" class="btn btn-danger btn-xs remove-row"><i class="fa fa-trash"></i></button></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
                <button type="button" id="add_item_btn" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Add Another Item</button>
            </div>

            <hr>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-paper-plane"></i> Submit Requisition</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#add_item_btn').click(function() {
        var row = '<tr>' +
            '<td><input type="text" name="item_name[]" class="form-control" required placeholder="Item / Service Name"></td>' +
            '<td><input type="text" name="item_desc[]" class="form-control" placeholder="Description or specifications"></td>' +
            '<td><input type="number" step="any" name="quantity[]" class="form-control req-calc" value="1"></td>' +
            '<td><input type="text" name="unit[]" class="form-control" value="pcs"></td>' +
            '<td><input type="number" step="0.01" name="unit_price[]" class="form-control req-calc" value="0.00"></td>' +
            '<td><button type="button" class="btn btn-danger btn-xs remove-row"><i class="fa fa-trash"></i></button></td>' +
            '</tr>';
        $('#req_items_body').append(row);
    });

    $(document).on('click', '.remove-row', function() {
        if ($('#req_items_body tr').length > 1) {
            $(this).closest('tr').remove();
        }
    });
});
</script>
