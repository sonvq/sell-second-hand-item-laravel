@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('pages::pages.title.pages') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('pages::pages.title.pages') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.pages.pages.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('pages::pages.button.create pages') }}
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
                                <th>{{ trans('pages::pages.table.id') }}</th>
                                <th>{{ trans('pages::pages.table.page_type') }}</th>
                                <th>{{ trans('pages::pages.table.description') }}</th>
                                <th>{{ trans('pages::pages.table.status') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($pages)): ?>
                            <?php foreach ($pages as $pages): ?>
                            <tr>
                                <td>
                                    <a href="{{ route('admin.pages.pages.edit', [$pages->id]) }}">
                                        {{ $pages->id }}
                                    </a>
                                </td>
                                <td>
                                    <?php $arrPageType = config('asgard.pages.config.page_type'); ?>
                                    @if (isset($arrPageType[$pages->page_type]))
                                        {{ $arrPageType[$pages->page_type] }}
                                    @endif                                    
                                </td>
                                <td>
                                    {{ str_limit($pages->description, 100, '...') }}
                                </td>
                                <td>
                                    <?php $arrPageType = config('asgard.pages.config.status'); ?>
                                    @if (isset($arrPageType[$pages->status]))
                                        {{ $arrPageType[$pages->status] }}
                                    @endif    
                                </td>
                                <td>
                                    {{ $pages->created_at }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.pages.pages.edit', [$pages->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.pages.pages.destroy', [$pages->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('pages::pages.table.id') }}</th>
                                <th>{{ trans('pages::pages.table.page_type') }}</th>
                                <th>{{ trans('pages::pages.table.description') }}</th>
                                <th>{{ trans('pages::pages.table.status') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
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
        <dd>{{ trans('pages::pages.title.create pages') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.pages.pages.create') ?>" }
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
