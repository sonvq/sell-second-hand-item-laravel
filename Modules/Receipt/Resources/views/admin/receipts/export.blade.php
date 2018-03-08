<html>
    <head>
        <title>
            {{ trans('appuser::appusers.title.user export sheet name') }}
        </title>
    </head>
    <body>
        <div class="panel-body">
            <table class="table table-striped table-condensed table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>{{ trans('receipt::receipts.table.transaction id') }}</th>
                        <th>{{ trans('receipt::receipts.table.username') }}</th>
                        <th>{{ trans('receipt::receipts.table.transaction date') }}</th>
                        <th>{{ trans('receipt::receipts.table.amount') }}</th>
                        <th>{{ trans('receipt::receipts.table.payment mode') }}</th>
                        <th>{{ trans('receipt::receipts.table.promote days') }}</th>
                        <th>{{ trans('receipt::receipts.table.item id') }}</th>
                        <th>{{ trans('receipt::receipts.table.item name') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($receipts)): ?>
                        <?php foreach ($receipts as $receipt): ?>
                        <tr>
                            <td>
                                {{ $receipt->transaction_ref_id }}
                            </td>
                            <td>
                                <?php $appuser = $receipt->appuser; ?>
                                @if ($appuser)
                                    {{ $appuser->username }}
                                @endif                                    
                            </td>
                            <td>
                                {{ date('d/m/Y', strtotime($receipt->created_at)) }}                            
                            </td>                                
                            <td>
                                {{ $receipt->amount_due }}
                            </td>
                            <td>
                                <?php $arrPaymentMode = config('asgard.receipt.config.payment_mode'); ?>
                                @if (isset($receipt->payment_mode) && !empty($receipt->payment_mode) && isset($arrPaymentMode[$receipt->payment_mode]))
                                    {{ $arrPaymentMode[$receipt->payment_mode] }}
                                @endif
                            </td>
                            <td>
                                {{ $receipt->total_promo_days }}
                            </td>
                            <td>
                                {{ $receipt->item_id }}
                            </td>
                            <td>
                                <?php $item = $receipt->item; ?>
                                @if ($item)
                                    {{ $item->title }}
                                @endif

                            </td>                        
                        </tr>                            
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>