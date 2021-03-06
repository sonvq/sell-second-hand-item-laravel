@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('mobilelog::mobilelogs.title.mobilelogs') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('mobilelog::mobilelogs.title.mobilelogs') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.mobilelog.mobilelog.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('mobilelog::mobilelogs.button.create mobilelog') }}
                    </a>
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
                                <th>{{ trans('mobilelog::mobilelogs.table.id') }}</th>
                                <th>{{ trans('mobilelog::mobilelogs.table.file name') }}</th>
                                <th>{{ trans('mobilelog::mobilelogs.table.function name') }}</th>
                                <th>{{ trans('mobilelog::mobilelogs.table.content') }}</th>
                                <th>{{ trans('mobilelog::mobilelogs.table.author') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($mobilelogs)): ?>
                            <?php foreach ($mobilelogs as $mobilelog): ?>
                            <tr>
                                <td>
                                    {{ $mobilelog->id }}
                                </td>
                                <td>
                                    {{ $mobilelog->file_name }}
                                </td>
                                <td>
                                    {{ $mobilelog->function_name }}
                                </td>
                                <td>
                                    {{ $mobilelog->content }}
                                </td>
                                <td>
                                    <?php $appuser = $mobilelog->appuser; ?>
                                    @if ($appuser)
                                        {{ $appuser->email }}
                                    @endif
                                </td>
                                <td>
                                    {{ $mobilelog->created_at }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.mobilelog.mobilelog.edit', [$mobilelog->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.mobilelog.mobilelog.destroy', [$mobilelog->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('mobilelog::mobilelogs.table.id') }}</th>
                                <th>{{ trans('mobilelog::mobilelogs.table.file name') }}</th>
                                <th>{{ trans('mobilelog::mobilelogs.table.function name') }}</th>
                                <th>{{ trans('mobilelog::mobilelogs.table.content') }}</th>
                                <th>{{ trans('mobilelog::mobilelogs.table.author') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
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
        <dd>{{ trans('mobilelog::mobilelogs.title.create mobilelog') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.mobilelog.mobilelog.create') ?>" }
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
