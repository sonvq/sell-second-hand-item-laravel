@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('subcategory::subcategories.title.subcategories') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('subcategory::subcategories.title.subcategories') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.subcategory.subcategory.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('subcategory::subcategories.button.create subcategory') }}
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
                                <th>{{ trans('subcategory::subcategories.table.id') }}</th>
                                <th>{{ trans('subcategory::subcategories.table.name') }}</th>
                                <th>{{ trans('subcategory::subcategories.table.category') }}</th>
                                <th>{{ trans('subcategory::subcategories.table.status') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th>{{ trans('subcategory::subcategories.table.updated at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($subcategories)): ?>
                            <?php foreach ($subcategories as $subcategory): ?>
                            <tr>
                                <td>
                                    {{ $subcategory->id }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.subcategory.subcategory.edit', [$subcategory->id]) }}">
                                        {{ $subcategory->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.category.category.edit', [$subcategory->category->id]) }}">
                                        {{ $subcategory->category->name }}
                                    </a>
                                </td>
                                <td>
                                    <?php $subcategoryStatusArr = config('asgard.subcategory.config.status'); ?>
                                    <?php if(isset($subcategoryStatusArr[$subcategory->status]) && !empty($subcategoryStatusArr[$subcategory->status])) : ?> 
                                        {{ $subcategoryStatusArr[$subcategory->status] }}
                                    <?php else: ?>
                                        {{ $subcategory->status }}
                                    <?php endif; ?>                                        
                                </td>
                                <td>
                                    {{ $subcategory->created_at }}
                                </td>
                                <td>
                                    {{ $subcategory->updated_at }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.subcategory.subcategory.edit', [$subcategory->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
<!--                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.subcategory.subcategory.destroy', [$subcategory->id]) }}"><i class="fa fa-trash"></i></button>-->
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('subcategory::subcategories.table.id') }}</th>
                                <th>{{ trans('subcategory::subcategories.table.name') }}</th>
                                <th>{{ trans('subcategory::subcategories.table.category') }}</th>
                                <th>{{ trans('subcategory::subcategories.table.status') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th>{{ trans('subcategory::subcategories.table.updated at') }}</th>
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
        <dd>{{ trans('subcategory::subcategories.title.create subcategory') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.subcategory.subcategory.create') ?>" }
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
