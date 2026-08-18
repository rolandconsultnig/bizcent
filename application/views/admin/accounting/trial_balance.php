<div class="panel panel-custom">
    <div class="panel-heading">
        <div class="panel-title">
            <strong><i class="fa fa-balance-scale"></i> <?= lang('trial_balance') ?></strong>
            <div class="pull-right">
                <button type="button" class="btn btn-xs btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr class="bg-gray-lighter">
                    <th width="15%">Account Code</th>
                    <th width="45%">Account Name</th>
                    <th width="20%" class="text-right">Debit Balance</th>
                    <th width="20%" class="text-right">Credit Balance</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $tot_deb = 0;
                $tot_cred = 0;
                if (!empty($accounts)): foreach ($accounts as $acc):
                    $is_debit_nature = in_array($acc->account_type, ['asset', 'expense']);
                    $deb = $is_debit_nature ? $acc->balance : 0;
                    $cred = !$is_debit_nature ? $acc->balance : 0;
                    $tot_deb += $deb;
                    $tot_cred += $cred;
                ?>
                    <tr>
                        <td><strong><?= $acc->account_code ?></strong></td>
                        <td><?= $acc->account_name ?> <span class="label label-default"><?= ucfirst($acc->account_type) ?></span></td>
                        <td class="text-right"><?= $deb > 0 ? display_money($deb) : '-' ?></td>
                        <td class="text-right"><?= $cred > 0 ? display_money($cred) : '-' ?></td>
                    </tr>
                <?php endforeach; endif; ?>
                <tr class="bg-gray-lighter" style="font-size: 16px;">
                    <td colspan="2" class="text-right"><strong>Total Trial Balance:</strong></td>
                    <td class="text-right"><strong class="text-primary"><?= display_money($tot_deb) ?></strong></td>
                    <td class="text-right"><strong class="text-primary"><?= display_money($tot_cred) ?></strong></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
