@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('message::messages.title.messages') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('message::messages.title.messages') }}</li>
    </ol>
@stop

@section('styles')
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
<!--                    <a href="{{ route('admin.message.message.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('message::messages.button.create message') }}
                    </a>-->
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    <div class="wraper_filter_form">
                        <form method="GET" action="" accept-charset="UTF-8" class="col-md-12 form-inline pull-left filter-table-advance">
                            <div class="row">
                                <div class="col-md-1">
                                    <label>{{ trans('message::messages.table.username 1') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <input id="filter_username" class="form-control searchable-input" value="" placeholder="Username" name="username" type="text" data-column-index="1"> 
                                </div>
                                <div class="col-md-1 col-md-offset-1">
                                    <label>{{ trans('message::messages.table.username 2') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <input id="filter_full_name" class="form-control searchable-input" value="" placeholder="Full name" name="full_name" type="text" data-column-index="2">
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
                                <th>{{ trans('message::messages.table.message id') }}</th>
                                <th>{{ trans('message::messages.table.username 1') }}</th>
                                <th>{{ trans('message::messages.table.username 2') }}</th>
                                <th>{{ trans('message::messages.table.item id') }}</th>
                                <th>{{ trans('message::messages.table.item title') }}</th>
                                <th>{{ trans('message::messages.table.last updated') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($messages) && count($messages) > 0): ?>
                                <?php foreach ($messages as $message): ?>
                                <tr>
                                    <td>
                                        {{ $message->id }}                                    
                                    </td>
                                    <td>
                                        <?php $seller = $message->seller; ?>
                                        @if ($seller)
                                            {{ $seller->username }}
                                        @endif                                        
                                    </td>
                                    <td>
                                        <?php $buyer = $message->buyer; ?>
                                        @if ($buyer)
                                            {{ $buyer->username }}
                                        @endif                                        
                                    </td>
                                    <?php $item = $message->item; ?>
                                    <td>                                        
                                        @if ($item)
                                            {{ $item->id }}
                                        @endif                                        
                                    </td>
                                    <td>                                        
                                        @if ($item)
                                            {{ $item->title }}
                                        @endif                                        
                                    </td>
                                    <td>        
                                        @if ($item)
                                            {{ date('d/m/Y H:i:s', strtotime($item->updated_at)) }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.message.message.edit', [$message->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('message::messages.table.username 1') }}</th>
                                <th>{{ trans('message::messages.table.username 2') }}</th>
                                <th>{{ trans('message::messages.table.item id') }}</th>
                                <th>{{ trans('message::messages.table.item title') }}</th>
                                <th>{{ trans('message::messages.table.last updated') }}</th>
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
        <dd>{{ trans('message::messages.title.create message') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.message.message.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.selectize').selectize();
            
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

                    dtable.column($(this).data('columnIndex')).search(this.value).draw();
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
