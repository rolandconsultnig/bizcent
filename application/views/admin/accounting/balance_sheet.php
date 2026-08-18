<div class="panel panel-custom">
    <div class="panel-heading">
        <div class="panel-title">
            <strong><i class="fa fa-bar-chart"></i> <?= lang('balance_sheet') ?> (Assets = Liabilities + Equity)</strong>
            <div class="pull-right">
                <button type="button" class="btn btn-xs btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <!-- Assets Column -->
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background: #edf1f2;">
                        <h4 class="panel-title"><strong><i class="fa fa-building text-info"></i> Assets</strong></h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tbody>
                            <?php $total_assets = 0; if (!empty($assets)): foreach ($assets as $a): $total_assets += $a->balance; ?>
                                <tr>
                                    <td><?= $a->account_code ?> - <?= $a->account_name ?></td>
                                    <td class="text-right"><strong><?= display_money($a->balance) ?></strong></td>
                                </tr>
                            <?php endforeach; endif; ?>
                            <tr class="bg-gray-lighter" style="font-size: 15px;">
                                <td><strong>Total Assets:</strong></td>
                                <td class="text-right"><strong class="text-primary"><?= display_money($total_assets) ?></strong></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Liabilities & Equity Column -->
            <div class="col-sm-6">
                <!-- Liabilities -->
                <div class="panel panel-default">
                    <div class="panel-heading" style="background: #edf1f2;">
                        <h4 class="panel-title"><strong><i class="fa fa-credit-card text-warning"></i> Liabilities</strong></h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tbody>
                            <?php $total_liab = 0; if (!empty($liabilities)): foreach ($liabilities as $l): $total_liab += $l->balance; ?>
                                <tr>
                                    <td><?= $l->account_code ?> - <?= $l->account_name ?></td>
                                    <td class="text-right"><strong><?= display_money($l->balance) ?></strong></td>
                                </tr>
                            <?php endforeach; endif; ?>
                            <tr class="bg-gray-lighter" style="font-size: 15px;">
                                <td><strong>Total Liabilities:</strong></td>
                                <td class="text-right"><strong class="text-warning"><?= display_money($total_liab) ?></strong></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Equity -->
                <div class="panel panel-default">
                    <div class="panel-heading" style="background: #edf1f2;">
                        <h4 class="panel-title"><strong><i class="fa fa-pie-chart text-success"></i> Equity & Retained Earnings</strong></h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tbody>
                            <?php $total_eq = 0; if (!empty($equity)): foreach ($equity as $e): $total_eq += $e->balance; ?>
                                <tr>
                                    <td><?= $e->account_code ?> - <?= $e->account_name ?></td>
                                    <td class="text-right"><strong><?= display_money($e->balance) ?></strong></td>
                                </tr>
                            <?php endforeach; endif; ?>
                            <tr>
                                <td>Current Period Net Income (P&L)</td>
                                <td class="text-right"><strong><?= display_money($net_income) ?></strong></td>
                            </tr>
                            <?php $total_eq += $net_income; ?>
                            <tr class="bg-gray-lighter" style="font-size: 15px;">
                                <td><strong>Total Equity:</strong></td>
                                <td class="text-right"><strong class="text-success"><?= display_money($total_eq) ?></strong></td>
                            </tr>
                            <tr class="bg-gray-lighter" style="font-size: 16px; border-top: 2px solid #ddd;">
                                <td><strong>Total Liabilities & Equity:</strong></td>
                                <td class="text-right"><strong class="text-primary"><?= display_money($total_liab + $total_eq) ?></strong></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
