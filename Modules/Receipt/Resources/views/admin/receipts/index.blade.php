@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('receipt::receipts.title.receipts') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('receipt::receipts.title.receipts') }}</li>
    </ol>
@stop

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ Module::asset('dashboard:vendor/jquery-ui/themes/blitzer/jquery-ui.min.css') }}">

<style>
    .searchable-input, .searchable-select {
        margin-bottom: 15px;
        min-width: 220px;
    }
    .btn-export-excel {
        margin-left: 10px;
    }
</style>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.receipt.receipt.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('receipt::receipts.button.create receipt') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    <div class="wraper_filter_form">
                        <form method="GET" action="" accept-charset="UTF-8" class="col-md-12 form-inline pull-left filter-table-advance">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ trans('receipt::receipts.table.username') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <input id="filter_username" class="form-control searchable-input" value="" placeholder="{{ trans('receipt::receipts.table.username') }}" name="username" type="text" data-column-index="1"> 
                                </div>                                                               
                            </div>                            
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ trans('receipt::receipts.table.created date from') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <input data-compare="bigger" data-type="date" readonly="readonly" id="filter_created_at_from" class="form-control searchable-input" value="" placeholder="{{ trans('receipt::receipts.table.created date from') }}" name="created_at_from" type="text" data-column-index="2">
                                </div>
                                
                                <div class="col-md-2 col-md-offset-2">
                                    <label>{{ trans('receipt::receipts.table.created date to') }}</label>
                                </div>
                                 
                                <div class="col-md-2">
                                    <input data-compare="smaller" data-type="date" readonly="readonly" id="filter_created_at_to" class="form-control searchable-input" value="" placeholder="{{ trans('receipt::receipts.table.created date to') }}" name="created_at_to" type="text" data-column-index="2">                                          
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ trans('receipt::receipts.table.payment_mode') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <select id="filter_payment_mode" class="form-control searchable-select" name="payment_mode" data-column-index="4">
                                        <option selected="selected" value="">{{ trans('receipt::receipts.label.empty_option_payment_mode') }}</option>
                                        @if (count($paymentMode) > 0)                                           
                                            <?php foreach ($paymentMode as $key => $value) : ?>
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            <?php endforeach; ?>
                                        @endif
                                    </select> 
                                </div>                                
                            </div>  
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">                                    
                                        <a class="btn btn-primary filter-table-reset">Reset</a>
                                        <a class="btn btn-primary btn-export-excel">
                                            <i class="fa fa-download" aria-hidden="true"></i> {{ trans('item::items.button.export') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
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
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
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
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.receipt.receipt.edit', [$receipt->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.receipt.receipt.destroy', [$receipt->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>                            
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('receipt::receipts.table.transaction id') }}</th>
                                <th>{{ trans('receipt::receipts.table.username') }}</th>
                                <th>{{ trans('receipt::receipts.table.transaction date') }}</th>
                                <th>{{ trans('receipt::receipts.table.amount') }}</th>
                                <th>{{ trans('receipt::receipts.table.payment mode') }}</th>
                                <th>{{ trans('receipt::receipts.table.promote days') }}</th>
                                <th>{{ trans('receipt::receipts.table.item id') }}</th>
                                <th>{{ trans('receipt::receipts.table.item name') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('receipt::receipts.title.create receipt') }}</dd>
    </dl>
@stop


@push('js-stack')
    <script src="{{ Module::asset('dashboard:vendor/jquery-ui/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.receipt.receipt.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.btn-export-excel').on('click', function(){
                var filter_username = $('#filter_username').val();
                var filter_payment_mode = $('#filter_payment_mode').val();               
                var filter_created_at_from = $('#filter_created_at_from').val();
                var filter_created_at_to = $('#filter_created_at_to').val();
                
                var url = '{{ URL::route("admin.receipt.receipt.export") }}';
                var fullUrl = url + '?username=' + filter_username
                    + '&payment_mode=' + filter_payment_mode
                    + '&created_at_from=' + filter_created_at_from + '&created_at_to=' + filter_created_at_to;
                window.location.replace(fullUrl);                

            });    
            
            $('.selectize').selectize();
            
            $('#filter_created_at_from').datepicker({
                dateFormat: 'dd/mm/yy'
            });
            
            $('#filter_created_at_to').datepicker({
                dateFormat: 'dd/mm/yy'
            });
            
            var dtable = $('.data-table').DataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 2, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                    }
            });
                                   
            var normalizeDate = function(dateString) {
                
                if (dateString == '') {
                    return dateString;
                }
                var parts = dateString.split('/');
                var date = new Date(parts[2], parts[1] - 1, parts[0]); 
                
                var normalized = date.getFullYear() + '' + (("0" + (date.getMonth() + 1)).slice(-2)) + '' + ("0" + date.getDate()).slice(-2);
                
                return normalized;
            }
            
            var filterByDate = function(column, startDate, endDate) {
            // Custom filter syntax requires pushing the new filter to the global filter array
                $.fn.dataTableExt.afnFiltering.push(
                    function( oSettings, aData, iDataIndex ) {
                        
                        var startDate = $('#filter_created_at_from').val(),
                        endDate = $('#filter_created_at_to').val();
                        
                        var rowDate = normalizeDate(aData[column]),
                            start = normalizeDate(startDate),
                            end = normalizeDate(endDate);
                    
                        console.log(startDate);
                        // If our date from the row is between the start and end
                        if (start == '' && end == '') {
                            return true;
                        } else if (rowDate >= start && end == '' && start != ''){
                            return true;
                        } else if (rowDate <= end && start == '' && end !== ''){
                            return true;
                        } else if (start <= rowDate && rowDate <= end) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                );
            };
    
            setTimeout(function(){
                $('.searchable-select').on('keyup change', function() {
                    //clear global search values
                    dtable.search('');
                    
                    if (this.value != "") {
                        dtable.column($(this).data('columnIndex')).search("^" + $(this).find('option:selected').text() + "$", true).draw();
                    } else {
                        dtable.column($(this).data('columnIndex')).search("").draw();
                    }
                });
                
                $('.searchable-input').on('keyup change', function() {
                    //clear global search values
                    dtable.search('');
                    
                    if ($(this).data('type') == 'date') {                                                
                        filterByDate($(this).data('columnIndex')); 
                        dtable.draw();
                    } else {
                        dtable.column($(this).data('columnIndex')).search(this.value).draw();
                    }
                });
                
                
                $(".dataTables_filter input").on('keyup change', function() {                 
                    //clear input values
                    $('.searchable-input').val('');
                    $('.searchable-select').val('');
                    
                    //clear column search values
                    dtable.columns().search('');                    
                    dtable.draw();
                });
                
                $(".filter-table-reset").on('click', function(e) {                                        
                    //clear input values
                    $('.searchable-input').val('');
                    $('.searchable-select').val('');
                    
                    //clear column search values
                    dtable.columns().search('');                    
                    dtable.draw();
                });
            });
        });
    </script>
@endpush
