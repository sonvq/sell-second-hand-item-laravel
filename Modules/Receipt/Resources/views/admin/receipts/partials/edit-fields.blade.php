@section('styles')
<link rel="stylesheet" type="text/css" href="{{ Module::asset('dashboard:vendor/jquery-ui/themes/blitzer/jquery-ui.min.css') }}">

@stop

<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group'>
                {!! Form::label("name", trans('receipt::receipts.form.full name')) !!}
                <input name="full_name" readonly="true" value="" id="full_name" class="form-control" />                                
            </div>
        </div>
    </div>  
    <div class="row">
        <div class="col-sm-4">            
            <div class='form-group{{ $errors->has("appuser_id") ? ' has-error' : '' }}'>
                {!! Form::label("appuser_id", trans('receipt::receipts.form.phone number')) !!}
                {!! Form::select('appuser_id', $appusers, $receipt->appuser_id, ['class' => 'selectize', 'id' => 'appuser_id']) !!}
                {!! $errors->first("appuser_id", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>  
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group'>
                {!! Form::label("username", trans('receipt::receipts.form.username')) !!}
                <input name="username" readonly="true" value="" id="username" class="form-control" />                                
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-4">            
            <div class='form-group{{ $errors->has("item_id") ? ' has-error' : '' }}'>
                {!! Form::label("item_id", trans('receipt::receipts.form.item name')) !!}
                <div class="item_wrapper">
                    {!! Form::select('item_id', $items, $receipt->item_id, ['class' => '', 'id' => 'item_id']) !!}
                </div>
                {!! $errors->first("item_id", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div> 
    
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("total_promo_days") ? ' has-error' : '' }}'>
                {!! Form::label("total_promo_days", trans('receipt::receipts.form.total promo days')) !!}
                {!! Form::number("total_promo_days", $receipt->total_promo_days, ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('receipt::receipts.form.total promo days')]) !!}
                {!! $errors->first("total_promo_days", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("promo_period_from") ? ' has-error' : '' }}'>
                {!! Form::label("promo_period_from", trans('receipt::receipts.form.promo period from')) !!}
                {!! Form::text("promo_period_from", date('d/m/Y', strtotime($receipt->promo_period_from)), ['id' => 'promo_period_from', 'readonly' => true, 'class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('receipt::receipts.form.promo period from')]) !!}
                {!! $errors->first("promo_period_from", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("promo_period_to") ? ' has-error' : '' }}'>
                {!! Form::label("promo_period_to", trans('receipt::receipts.form.promo period to')) !!}
                {!! Form::text("promo_period_to", date('d/m/Y', strtotime($receipt->promo_period_to)), ['id' => 'promo_period_to', 'readonly' => true, 'class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('receipt::receipts.form.promo period to')]) !!}
                {!! $errors->first("promo_period_to", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-4">            
            <div class='form-group{{ $errors->has("payment_mode") ? ' has-error' : '' }}'>
                {!! Form::label("payment_mode", trans('receipt::receipts.form.payment mode')) !!}
                {!! Form::select('payment_mode', $paymentMode, $receipt->payment_mode, ['class' => 'selectize', 'id' => 'payment_mode']) !!}
                {!! $errors->first("payment_mode", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-4">            
            <div class='form-group{{ $errors->has("transaction_type") ? ' has-error' : '' }}'>
                {!! Form::label("transaction_type", trans('receipt::receipts.form.transaction type')) !!}
                {!! Form::select('transaction_type', config('asgard.receipt.config.transaction_type'), $receipt->transaction_type, ['class' => 'selectize', 'id' => 'transaction_type']) !!}
                {!! $errors->first("transaction_type", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("transaction_ref_id") ? ' has-error' : '' }}'>
                {!! Form::label("transaction_ref_id", trans('receipt::receipts.form.transaction ref id')) !!}
                {!! Form::text("transaction_ref_id", $receipt->transaction_ref_id, ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('receipt::receipts.form.transaction ref id')]) !!}
                {!! $errors->first("transaction_ref_id", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("remarks") ? ' has-error' : '' }}'>
                {!! Form::label("remarks", trans('receipt::receipts.form.remarks')) !!}
                {!! Form::textarea("remarks", $receipt->remarks, ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('receipt::receipts.form.remarks')]) !!}
                {!! $errors->first("remarks", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("amount_due") ? ' has-error' : '' }}'>
                {!! Form::label("amount_due", trans('receipt::receipts.form.amount due')) !!}
                {!! Form::text("amount_due", $receipt->amount_due, ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('receipt::receipts.form.amount due')]) !!}
                {!! $errors->first("amount_due", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>

@push('js-stack')
    <script src="{{ Module::asset('dashboard:vendor/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            var itemSelect = $('#item_id').selectize();
            $('.selectize').selectize();
            
            $('#promo_period_from').datepicker({
                dateFormat: 'dd/mm/yy'
            });
            
            $('#promo_period_to').datepicker({
                dateFormat: 'dd/mm/yy'
            });
            
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.receipt.receipt.index') ?>" }
                ]
            });
            
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
            
            $('#appuser_id').on('change', function() {
                var selectedId = $(this).val();
                if (selectedId == 0) {
                    $('#full_name').val('');
                    $('#username').val('');
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url: '<?= route('admin.appuser.appuser.user.info.by.id') ?>',
                    data: {appuser_id: selectedId},
                    success: function(data) {
                        $('#full_name').val(data.user.full_name);
                        $('#username').val(data.user.username);
                        console.log(data);
                        itemSelect[0].selectize.clearOptions();
                        $('.item_wrapper').empty();
                        $('.item_wrapper').append(
                            '<select class="selectize" id="item_id" name="item_id"><option value="0" selected="selected">Select item</option></select>'
                        );
                        if(data.items.length > 0) {                            
                            data.items.forEach(function(item, index) {
                                var optionHtml = '<option value="' + item.id + '">' + item.title + '</option>'
                                $('#item_id').append(optionHtml);
                            });
                                                        
                        } 
                        setTimeout(function(){
                            $('#item_id').selectize();    
                        });
                    }
                });
            });
            
            setTimeout(function(){
                var selectedAppuserId = $('#appuser_id').val();
                if (selectedAppuserId > 0) {
                    $.ajax({
                        type: 'GET',
                        url: '<?= route('admin.appuser.appuser.user.info.by.id') ?>',
                        data: {appuser_id: selectedAppuserId},
                        success: function(data) {
                             $('#full_name').val(data.user.full_name);
                            $('#username').val(data.user.username);
                            console.log(data);
                            var old_item_id = {{ $receipt->item_id }}
                            itemSelect[0].selectize.clearOptions();
                            $('.item_wrapper').empty();
                            $('.item_wrapper').append(
                                '<select class="selectize" id="item_id" name="item_id"><option value="0" selected="selected">Select item</option></select>'
                            );
                            if(data.items.length > 0) {                            
                                data.items.forEach(function(item, index) {
                                    if (item.id == old_item_id) {
                                        var optionHtml = '<option selected value="' + item.id + '">' + item.title + '</option>'
                                    } else {
                                        var optionHtml = '<option value="' + item.id + '">' + item.title + '</option>'
                                    }
                                    $('#item_id').append(optionHtml);
                                });

                            } 
                            setTimeout(function(){
                                $('#item_id').selectize();    
                            });
                        }
                    });
                } else if (selectedAppuserId == 0) {
                    $('#full_name').val('');
                    $('#username').val('');
                }
            });
            
        });
    </script>
@endpush