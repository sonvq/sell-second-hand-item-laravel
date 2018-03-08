@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('reporting::reportings.title.reportings') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('reporting::reportings.title.reportings') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
<!--                    <a href="{{ route('admin.reporting.reporting.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('reporting::reportings.button.create reporting') }}
                    </a>-->
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('reporting::reportings.table_list.report id') }}</th>
                                <th>{{ trans('reporting::reportings.table_list.sender') }}</th>
                                <th>{{ trans('reporting::reportings.table_list.receiver') }}</th>
                                <th>{{ trans('reporting::reportings.table_list.reporting reason') }}</th>
                                <th>{{ trans('reporting::reportings.table_list.item id') }}</th>
                                <th>{{ trans('reporting::reportings.table_list.item name') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($reportings)): ?>
                            <?php foreach ($reportings as $reporting): ?>
                            <tr>
                                <td>
                                    {{ $reporting->id }}
                                </td>
                                <td>
                                    <?php $sender = $reporting->sender; ?>
                                    @if ($sender)
                                        {{ $sender->username }}
                                    @endif                                    
                                </td>
                                <td>
                                    <?php $receiver = $reporting->receiver; ?>
                                    @if ($receiver)
                                        {{ $receiver->username }}
                                    @endif                                    
                                </td>
                                <td>
                                    <?php $reportReason = $reporting->reporting_reason; ?>
                                    @if ($reportReason)
                                        {{ $reportReason->name }}
                                    @endif                                    
                                </td>
                                <td>
                                    {{ $reporting->item_id }}
                                </td>
                                <td>
                                    <?php $item = $reporting->item; ?>
                                    @if ($item)
                                        {{ $item->title }}
                                    @endif                                    
                                </td>
                                <td>
                                    {{ $item->created_at }}
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('reporting::reportings.table_list.report id') }}</th>
                                <th>{{ trans('reporting::reportings.table_list.sender') }}</th>
                                <th>{{ trans('reporting::reportings.table_list.receiver') }}</th>
                                <th>{{ trans('reporting::reportings.table_list.reporting reason') }}</th>
                                <th>{{ trans('reporting::reportings.table_list.item id') }}</th>
                                <th>{{ trans('reporting::reportings.table_list.item name') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
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
        <dd>{{ trans('reporting::reportings.title.create reporting') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.reporting.reporting.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
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
        });
    </script>
@endpush
