<div class="panel panel-custom">
    <div class="panel-heading">
        <div class="panel-title">
            <strong><i class="fa fa-line-chart"></i> <?= lang('income_statement') ?> (Profit & Loss Statement)</strong>
            <div class="pull-right">
                <button type="button" class="btn btn-xs btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <!-- Revenue Section -->
        <h4><i class="fa fa-arrow-circle-up text-success"></i> Operating Revenue & Income</h4>
        <table class="table table-striped table-bordered">
            <thead>
            <tr class="bg-gray-lighter">
                <th>Account Code</th>
                <th>Revenue Account</th>
                <th class="text-right">Amount</th>
            </tr>
            </thead>
            <tbody>
            <?php $total_rev = 0; if (!empty($revenue)): foreach ($revenue as $r): $total_rev += $r->balance; ?>
                <tr>
                    <td><strong><?= $r->account_code ?></strong></td>
                    <td><?= $r->account_name ?></td>
                    <td class="text-right"><?= display_money($r->balance) ?></td>
                </tr>
            <?php endforeach; endif; ?>
            <tr class="bg-gray-lighter" style="font-size: 15px;">
                <td colspan="2" class="text-right"><strong>Total Revenue / Turnover:</strong></td>
                <td class="text-right"><strong class="text-success"><?= display_money($total_rev) ?></strong></td>
            </tr>
            </tbody>
        </table>

        <!-- Expense Section -->
        <h4 style="margin-top: 30px;"><i class="fa fa-arrow-circle-down text-danger"></i> Operating Expenses</h4>
        <table class="table table-striped table-bordered">
            <thead>
            <tr class="bg-gray-lighter">
                <th>Account Code</th>
                <th>Expense Account</th>
                <th class="text-right">Amount</th>
            </tr>
            </thead>
            <tbody>
            <?php $total_exp = 0; if (!empty($expenses)): foreach ($expenses as $x): $total_exp += $x->balance; ?>
                <tr>
                    <td><strong><?= $x->account_code ?></strong></td>
                    <td><?= $x->account_name ?></td>
                    <td class="text-right"><?= display_money($x->balance) ?></td>
                </tr>
            <?php endforeach; endif; ?>
            <tr class="bg-gray-lighter" style="font-size: 15px;">
                <td colspan="2" class="text-right"><strong>Total Operating Expenses:</strong></td>
                <td class="text-right"><strong class="text-danger"><?= display_money($total_exp) ?></strong></td>
            </tr>
            </tbody>
        </table>

        <!-- Net Profit / Loss Summary Card -->
        <?php $net_profit = $total_rev - $total_exp; ?>
        <div class="well well-lg" style="margin-top: 30px; background: <?= $net_profit >= 0 ? '#eef9ee' : '#fceeee' ?>; border: 2px solid <?= $net_profit >= 0 ? '#27c24c' : '#f05050' ?>;">
            <div class="row">
                <div class="col-sm-8">
                    <h3 style="margin: 0; color: <?= $net_profit >= 0 ? '#27c24c' : '#f05050' ?>;">
                        <strong><?= $net_profit >= 0 ? '<i class="fa fa-trophy"></i> NET PROFIT' : '<i class="fa fa-exclamation-triangle"></i> NET LOSS' ?></strong>
                    </h3>
                    <p style="margin: 5px 0 0 0; color: #666;">Total Revenue (<?= display_money($total_rev) ?>) minus Total Expenses (<?= display_money($total_exp) ?>)</p>
                </div>
                <div class="col-sm-4 text-right">
                    <h2 style="margin: 0; color: <?= $net_profit >= 0 ? '#27c24c' : '#f05050' ?>;">
                        <strong><?= display_money(abs($net_profit)) ?></strong>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</div>
