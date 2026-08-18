<?= message_box('success'); ?>
<?= message_box('error'); ?>

<div class="panel panel-custom">
    <div class="panel-heading">
        <div class="panel-title">
            <strong><i class="fa fa-pencil-square-o"></i> <?= lang('journal_entries') ?> (General Journal)</strong>
            <div class="pull-right">
                <a href="<?= base_url('admin/accounting/new_journal_entry') ?>" class="btn btn-xs btn-primary">
                    <i class="fa fa-plus"></i> New Journal Entry
                </a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="DataTables">
                <thead>
                <tr>
                    <th><?= lang('entry_number') ?></th>
                    <th><?= lang('entry_date') ?></th>
                    <th>Reference</th>
                    <th>Notes / Narrative</th>
                    <th class="text-right">Total Debit</th>
                    <th class="text-right">Total Credit</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($journal_entries)): foreach ($journal_entries as $jv): ?>
                    <tr>
                        <td><strong><a data-toggle="modal" data-target="#myModal_lg" href="<?= base_url('admin/accounting/view_journal/' . $jv->journal_id) ?>"><?= $jv->entry_number ?></a></strong></td>
                        <td><?= display_date($jv->entry_date) ?></td>
                        <td><?= $jv->reference_no ?: '-' ?></td>
                        <td><?= $jv->notes ?: '-' ?></td>
                        <td class="text-right"><strong><?= display_money($jv->total_debit) ?></strong></td>
                        <td class="text-right"><strong><?= display_money($jv->total_credit) ?></strong></td>
                        <td><?= $jv->fullname ?: 'Admin' ?></td>
                        <td>
                            <a data-toggle="modal" data-target="#myModal_lg" class="btn btn-info btn-xs" href="<?= base_url('admin/accounting/view_journal/' . $jv->journal_id) ?>" title="View Entry"><i class="fa fa-eye"></i> View</a>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
