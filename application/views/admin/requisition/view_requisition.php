<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
        <i class="fa fa-file-text-o"></i> Requisition Voucher: <strong><?= $requisition->requisition_no ?></strong>
        <?php
        $s_cls = 'label-warning';
        if ($requisition->status == 'approved') $s_cls = 'label-success';
        elseif ($requisition->status == 'rejected') $s_cls = 'label-danger';
        elseif ($requisition->status == 'fulfilled') $s_cls = 'label-purple';
        ?>
        <span class="label <?= $s_cls ?> pull-right" style="margin-right: 15px; font-size: 13px;"><?= strtoupper($requisition->status) ?></span>
    </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-6">
            <p><strong>Title:</strong> <?= $requisition->title ?></p>
            <p><strong>Requested By:</strong> <?= $requisition->fullname ?: 'Staff Member' ?></p>
            <p><strong>Department:</strong> <?= $requisition->deptname ?: 'General Operations' ?></p>
        </div>
        <div class="col-sm-6">
            <p><strong>Expected Date:</strong> <?= display_date($requisition->expected_date) ?></p>
            <p><strong>Submission Date:</strong> <?= display_datetime($requisition->created_at) ?></p>
            <p><strong>Priority:</strong> <span class="label label-primary"><?= strtoupper($requisition->priority) ?></span></p>
        </div>
    </div>

    <?php if (!empty($requisition->purpose)): ?>
        <div class="well well-sm" style="background:#f9f9f9;">
            <strong>Purpose & Justification:</strong><br>
            <?= nl2br($requisition->purpose) ?>
        </div>
    <?php endif; ?>

    <h4><i class="fa fa-list"></i> Requested Items</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
            <tr class="bg-gray-lighter">
                <th>#</th>
                <th>Item Name</th>
                <th>Description / Specification</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Total Price</th>
            </tr>
            </thead>
            <tbody>
            <?php $count = 1; if (!empty($requisition_items)): foreach ($requisition_items as $item): ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><strong><?= $item->item_name ?></strong></td>
                    <td><?= $item->description ?: '-' ?></td>
                    <td class="text-center"><?= $item->quantity ?> <?= $item->unit ?></td>
                    <td class="text-right"><?= display_money($item->unit_price) ?></td>
                    <td class="text-right"><strong><?= display_money($item->total_price) ?></strong></td>
                </tr>
            <?php endforeach; endif; ?>
            <tr class="bg-gray-lighter">
                <td colspan="5" class="text-right"><strong>Grand Total Amount:</strong></td>
                <td class="text-right"><strong class="text-primary" style="font-size: 16px;"><?= display_money($requisition->total_amount) ?></strong></td>
            </tr>
            </tbody>
        </table>
    </div>

    <?php if (!empty($requisition->approved_date)): ?>
        <div class="alert alert-info">
            <i class="fa fa-check-circle"></i> Reviewed & Actioned on <strong><?= display_datetime($requisition->approved_date) ?></strong>
            <?php if (!empty($requisition->rejection_reason)): ?>
                <br><strong>Reason:</strong> <?= $requisition->rejection_reason ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <?php if ($requisition->status == 'pending'): ?>
        <a href="<?= base_url('admin/requisition/change_status/' . $requisition->requisition_id . '/approved') ?>" class="btn btn-success"><i class="fa fa-check"></i> Approve Requisition</a>
        <a href="<?= base_url('admin/requisition/change_status/' . $requisition->requisition_id . '/rejected') ?>" class="btn btn-danger"><i class="fa fa-times"></i> Reject Requisition</a>
    <?php endif; ?>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
