@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('item::items.title.items') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('item::items.title.items') }}</li>
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
<!--                    <a href="{{ route('admin.item.item.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('item::items.button.create item') }}
                    </a>-->
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    <div class="wraper_filter_form">
                        <form method="GET" action="" accept-charset="UTF-8" class="col-md-12 form-inline pull-left filter-table-advance">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ trans('item::items.table.title') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <input id="filter_title" class="form-control searchable-input" value="" placeholder="{{ trans('item::items.table.title') }}" name="title" type="text" data-column-index="1"> 
                                </div>
                                <div class="col-md-2 col-md-offset-2">
                                    <label>{{ trans('item::items.table.category') }}</label>
                                </div>
                                 
                                <div class="col-md-2">
                                    <div class='form-group'>
                                        <select id="filter_category" class="form-control searchable-select" name="category" data-column-index="2">
                                            <option selected="selected" value="">{{ trans('item::items.table.select category') }}</option>
                                            @if (count($categories) > 0)                                           
                                                <?php foreach ($categories as $item) : ?>
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                <?php endforeach; ?>
                                            @endif
                                        </select>            
                                    </div>                                          
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ trans('item::items.table.username') }}</label>
                                </div>
                                 
                                <div class="col-md-2">
                                    <div class='form-group'>
                                        <input id="filter_username" class="form-control searchable-input" value="" placeholder="{{ trans('item::items.table.username') }}" name="username" type="text" data-column-index="5">            
                                    </div>                                          
                                </div>
                                
                                <div class="col-md-2 col-md-offset-2">
                                    <label>{{ trans('item::items.table.subcategory') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <div class='form-group'>
                                        <select id="filter_subcategory" class="form-control searchable-select" name="subcategory" data-column-index="3">
                                            <option selected="selected" value="">{{ trans('item::items.table.select sub category') }}</option>
                                            @if (count($subcategories) > 0)                                           
                                                <?php foreach ($subcategories as $item) : ?>
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                <?php endforeach; ?>
                                            @endif
                                        </select>            
                                    </div> 
                                </div>
                                                                
                            </div>
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ trans('item::items.table.created date from') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <input data-compare="bigger" data-type="date" readonly="readonly" id="filter_created_at_from" class="form-control searchable-input" value="" placeholder="{{ trans('item::items.table.created date from') }}" name="created_at_from" type="text" data-column-index="6">
                                </div>
                                
                                <div class="col-md-2 col-md-offset-2">
                                    <label>{{ trans('item::items.table.created date to') }}</label>
                                </div>
                                 
                                <div class="col-md-2">
                                    <input data-compare="smaller" data-type="date" readonly="readonly" id="filter_created_at_to" class="form-control searchable-input" value="" placeholder="{{ trans('item::items.table.created date to') }}" name="created_at_to" type="text" data-column-index="6">                                          
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ trans('item::items.table.status') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <select id="filter_status" class="form-control searchable-select" name="status" data-column-index="7">
                                        <option selected="selected" value="">{{ trans('item::items.table.select status') }}</option>
                                        <option value="selling">Available</option>
                                        <option value="sold">Sold</option>
                                    </select>
                                </div>  
                                
                                <div class="col-md-2 col-md-offset-2">
                                    <label>{{ trans('item::items.table.featured') }}</label>
                                </div>
                                 
                                <div class="col-md-2">
                                    <select id="filter_featured" class="form-control searchable-select" name="featured" data-column-index="10">
                                        <option selected="selected" value="">{{ trans('item::items.table.select featured') }}</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
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
                                <th>{{ trans('item::items.table.id') }}</th>
                                <th>{{ trans('item::items.table.title') }}</th>
                                <th>{{ trans('item::items.table.category') }}</th>  
                                <th>{{ trans('item::items.table.subcategory') }}</th> 
                                <th width='200'>{{ trans('item::items.table.description') }}</th> 
                                <th>{{ trans('item::items.table.username') }}</th> 
                                <th>{{ trans('item::items.table.created date') }}</th>                                                                
                                <th>{{ trans('item::items.table.status') }}</th>   
                                <th>{{ trans('item::items.table.original price') }}</th>
                                <th>{{ trans('item::items.table.final price') }}</th> 
                                <th>{{ trans('item::items.table.featured') }}</th>
                                <th>{{ trans('item::items.table.photos') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($items)): ?>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td>
                                            {{ $item->id }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.item.item.edit', [$item->id]) }}">
                                                {{ $item->title }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($item->category)
                                                {{ $item->category->name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->subcategory)
                                                {{ $item->subcategory->name }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->description }}
                                        </td>
                                        <td>
                                            @if ($item->appuser)
                                                {{ $item->appuser->username }}
                                            @endif
                                        </td>                                
                                        <td>                                    
                                            {{ date('d/m/Y', strtotime($item->created_at)) }}
                                        </td>
                                        <td>
                                            @if ($item->sell_status == 'selling')
                                                Available
                                            @else 
                                                Sold
                                            @endif
                                        </td>
                                        <td>                                    
                                            {{ $item->price_number }}
                                        </td>
                                        <td>                                    
                                            {{ $item->discount_price_number }}
                                        </td>
                                        <td>                                    
                                            <?php if ($item->featured == 0) : ?>
                                                No
                                            <?php else : ?>
                                                Yes
                                            <?php endif; ?>
                                        </td>
                                        <td>                                    
                                            <?php $firstPhoto = $item->gallery->first() ?>
                                            <?php if ($firstPhoto) : ?>
                                                <img src="<?php echo $firstPhoto->thumb_file_url; ?>" />
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.item.item.edit', [$item->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
<!--                                                <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.item.item.destroy', [$item->id]) }}"><i class="fa fa-trash"></i></button>-->
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('item::items.table.id') }}</th>
                                <th>{{ trans('item::items.table.title') }}</th>
                                <th>{{ trans('item::items.table.category') }}</th>  
                                <th>{{ trans('item::items.table.subcategory') }}</th>
                                <th>{{ trans('item::items.table.description') }}</th> 
                                <th>{{ trans('item::items.table.username') }}</th>                                   
                                <th>{{ trans('item::items.table.created date') }}</th>
                                <th>{{ trans('item::items.table.status') }}</th> 
                                <th>{{ trans('item::items.table.original price') }}</th>    
                                <th>{{ trans('item::items.table.final price') }}</th> 
                                <th>{{ trans('item::items.table.featured') }}</th>
                                <th>{{ trans('item::items.table.photos') }}</th>
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
        <dd>{{ trans('item::items.title.create item') }}</dd>
    </dl>
@stop


@push('js-stack')
    <script src="{{ Module::asset('dashboard:vendor/jquery-ui/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.item.item.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.btn-export-excel').on('click', function(){
                var filter_title = $('#filter_title').val();
                var filter_username = $('#filter_username').val();
                var filter_category = $('#filter_category').val();
                var filter_subcategory = $('#filter_subcategory').val();
                var filter_status = $('#filter_status').val();
                var filter_created_at_from = $('#filter_created_at_from').val();
                var filter_created_at_to = $('#filter_created_at_to').val();
                var filter_featured = $('#filter_featured').val();
                
                var url = '{{ URL::route("admin.item.item.export") }}';
                var fullUrl = url + '?title=' + filter_title + '&username=' + filter_username
                    + '&category_id=' + filter_category + '&subcategory_id=' + filter_subcategory + '&sell_status=' + filter_status
                    + '&created_at_from=' + filter_created_at_from + '&created_at_to=' + filter_created_at_to
                    + '&featured=' + filter_featured;
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
            
            var filterByDate = function(column, startDate, endDate) {
                
            // Custom filter syntax requires pushing the new filter to the global filter array
                $.fn.dataTableExt.afnFiltering.push(
                    function( oSettings, aData, iDataIndex ) {
                        
                        var startDate = $('#filter_created_at_from').val(),
                        endDate = $('#filter_created_at_to').val();
                        
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
