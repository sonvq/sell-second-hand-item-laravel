@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('notifications::notifications.title.notifications') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('notifications::notifications.title.notifications') }}</li>
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
                    <a href="{{ route('admin.notifications.notifications.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('notifications::notifications.button.create notifications') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    <div class="wraper_filter_form">
                        <form method="GET" action="" accept-charset="UTF-8" class="col-md-12 form-inline pull-left filter-table-advance">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ trans('notifications::notifications.table.name') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <input id="filter_name" class="form-control searchable-input" value="" placeholder="{{ trans('notifications::notifications.table.name') }}" name="name" type="text" data-column-index="1"> 
                                </div>                                
                            </div>                                                        
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ trans('notifications::notifications.table.broadcast group') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <div class='form-group'>
                                        <select id="filter_broadcast_id" class="form-control searchable-select" name="broadcast_id" data-column-index="2">
                                            <option selected="selected" value="">{{ trans('notifications::notifications.table.select broadcast group') }}</option>
                                            @if (count($broadcasts) > 0)                                           
                                                <?php foreach ($broadcasts as $item) : ?>
                                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                                <?php endforeach; ?>
                                            @endif
                                        </select>            
                                    </div> 
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ trans('notifications::notifications.table.schedule date from start') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <input data-compare="bigger" data-type="date_from" readonly="readonly" id="filter_schedule_date_from_start" class="has-date-picker form-control searchable-input" value="" placeholder="{{ trans('notifications::notifications.table.schedule date from start') }}" name="schedule_date_from_start" type="text" data-column-index="3">
                                </div>
                                
                                <div class="col-md-2 col-md-offset-2">
                                    <label>{{ trans('notifications::notifications.table.schedule date from end') }}</label>
                                </div>
                                 
                                <div class="col-md-2">
                                    <input data-compare="smaller" data-type="date_from" readonly="readonly" id="filter_schedule_date_from_end" class="has-date-picker form-control searchable-input" value="" placeholder="{{ trans('notifications::notifications.table.schedule date from end') }}" name="schedule_date_from_end" type="text" data-column-index="3">                                          
                                </div>
                            </div> 
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ trans('notifications::notifications.table.schedule date to start') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <input data-compare="bigger" data-type="date_to" readonly="readonly" id="filter_schedule_date_to_start" class="has-date-picker form-control searchable-input" value="" placeholder="{{ trans('notifications::notifications.table.schedule date to start') }}" name="schedule_date_to_start" type="text" data-column-index="4">
                                </div>
                                
                                <div class="col-md-2 col-md-offset-2">
                                    <label>{{ trans('notifications::notifications.table.schedule date to end') }}</label>
                                </div>
                                 
                                <div class="col-md-2">
                                    <input data-compare="smaller" data-type="date_to" readonly="readonly" id="filter_schedule_date_to_end" class="has-date-picker form-control searchable-input" value="" placeholder="{{ trans('notifications::notifications.table.schedule date to end') }}" name="schedule_date_to_end" type="text" data-column-index="4">                                          
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ trans('notifications::notifications.table.status') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <select id="filter_status" class="form-control searchable-select" name="status" data-column-index="5">
                                        <option selected="selected" value="">{{ trans('notifications::notifications.table.select status') }}</option>
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                        <option value="scheduled">Scheduled</option>                                        
                                    </select>
                                </div>                                
                            </div>  
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ trans('notifications::notifications.table.channels') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <select id="filter_status" class="form-control searchable-select" name="status" data-column-index="6">
                                        <option selected="selected" value="">{{ trans('notifications::notifications.table.select channels') }}</option>
                                        <option value="sms">SMS</option>   
                                        <option value="email">Email</option>       
                                        <option value="in_app_notification">In-app Notification</option>                                      
                                    </select>
                                </div>                                
                            </div>  
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">                                    
                                        <a class="btn btn-primary filter-table-reset">Reset</a>
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
                                <th>{{ trans('notifications::notifications.table.id') }}</th>
                                <th>{{ trans('notifications::notifications.table.name') }}</th>
                                <th>{{ trans('notifications::notifications.table.broadcast group') }}</th>
                                <th>{{ trans('notifications::notifications.table.schedule date from') }}</th>
                                <th>{{ trans('notifications::notifications.table.schedule date to') }}</th>
                                <th>{{ trans('notifications::notifications.table.status') }}</th>
                                <th>{{ trans('notifications::notifications.table.channels') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($notifications)): ?>
                            <?php foreach ($notifications as $notifications): ?>
                            <tr>
                                <td>
                                    {{ $notifications->id }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.notifications.notifications.edit', [$notifications->id]) }}">
                                        {{ $notifications->name }}
                                    </a>
                                </td>
                                <td>
                                    @if ($notifications->broadcast)
                                        {{ $notifications->broadcast->title }}
                                    @endif
                                </td>
                                <td>
                                    @if($notifications->schedule_date_from)
                                        {{ date('d/m/Y', strtotime($notifications->schedule_date_from)) }}
                                    @endif
                                </td>
                                <td>
                                    @if($notifications->schedule_date_to)
                                        {{ date('d/m/Y', strtotime($notifications->schedule_date_to)) }}
                                    @endif
                                </td>
                                <td>
                                    <?php $statusArray = config('asgard.notifications.config.status'); ?>
                                    @if (isset($statusArray[$notifications->status]))
                                        {{ $statusArray[$notifications->status] }}
                                    @endif
                                </td>
                                <td>
                                    <?php $statusArray = config('asgard.notifications.config.channels'); ?>
                                    @if (isset($statusArray[$notifications->channels]))
                                        {{ $statusArray[$notifications->channels] }}
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.notifications.notifications.edit', [$notifications->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.notifications.notifications.destroy', [$notifications->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('notifications::notifications.table.id') }}</th>
                                <th>{{ trans('notifications::notifications.table.name') }}</th>
                                <th>{{ trans('notifications::notifications.table.broadcast group') }}</th>
                                <th>{{ trans('notifications::notifications.table.schedule date from') }}</th>
                                <th>{{ trans('notifications::notifications.table.schedule date to') }}</th>
                                <th>{{ trans('notifications::notifications.table.status') }}</th> 
                                <th>{{ trans('notifications::notifications.table.channels') }}</th>
                                <th>{{ trans('core::core.table.actions') }}</th>
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
        <dd>{{ trans('notifications::notifications.title.create notifications') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script src="{{ Module::asset('dashboard:vendor/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.notifications.notifications.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {            
            $('.has-date-picker').datepicker({
                dateFormat: 'dd/mm/yy'
            });
            var dtable = $('.data-table').DataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
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
            
            var filterByDateFrom = function(column, startDate, endDate) {
                
            // Custom filter syntax requires pushing the new filter to the global filter array
                $.fn.dataTableExt.afnFiltering.push(
                    function( oSettings, aData, iDataIndex ) {
                        
                        var startDate = $('#filter_schedule_date_from_start').val(),
                        endDate = $('#filter_schedule_date_from_end').val();
                        
                        var rowDate = normalizeDate(aData[column]),
                            start = normalizeDate(startDate),
                            end = normalizeDate(endDate);
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
            
            var filterByDateTo = function(column, startDate, endDate) {
                
            // Custom filter syntax requires pushing the new filter to the global filter array
                $.fn.dataTableExt.afnFiltering.push(
                    function( oSettings, aData, iDataIndex ) {
                        
                        var startDate = $('#filter_schedule_date_to_start').val(),
                        endDate = $('#filter_schedule_date_to_end').val();
                        
                        var rowDate = normalizeDate(aData[column]),
                            start = normalizeDate(startDate),
                            end = normalizeDate(endDate);
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
                    
                    if ($(this).data('type') == 'date_from') {                                                
                        filterByDateFrom($(this).data('columnIndex')); 
                        dtable.draw();
                    } else if($(this).data('type') == 'date_to') {
                        filterByDateTo($(this).data('columnIndex')); 
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
