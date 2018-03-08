@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('broadcast::broadcasts.title.broadcasts') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('broadcast::broadcasts.title.broadcasts') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.broadcast.broadcast.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('broadcast::broadcasts.button.create broadcast') }}
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
                                <th>{{ trans('broadcast::broadcasts.table.id') }}</th>
                                <th>{{ trans('broadcast::broadcasts.table.group name') }}</th>
                                <th>{{ trans('broadcast::broadcasts.table.interest') }}</th>
                                <th>{{ trans('broadcast::broadcasts.table.gender') }}</th>
                                <th>{{ trans('broadcast::broadcasts.table.age band') }}</th>
                                <th>{{ trans('broadcast::broadcasts.table.country') }}</th>
                                <th>{{ trans('broadcast::broadcasts.table.city') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($broadcasts)): ?>
                            <?php foreach ($broadcasts as $broadcast): ?>
                            <tr>
                                <td>
                                    {{ $broadcast->id }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.broadcast.broadcast.edit', [$broadcast->id]) }}">
                                        {{ $broadcast->title }}
                                    </a>
                                </td>
                                <td>
                                    @if (count($broadcast->interest) > 0)
                                        {{ str_limit(implode(', ', $broadcast->interest->pluck('name')->toArray()), $limit = 50, $end = '...') }}
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($broadcast->gender))
                                    <?php 
                                        $arrayConfigGender = config('asgard.broadcast.config.gender'); 
                                        $arrayGenderText = [];
                                        $arrayGender = explode(',', $broadcast->gender); 
                                        if (count($arrayGender) > 0) {
                                            foreach($arrayGender as $singleGender) {
                                                $arrayGenderText[] = $arrayConfigGender[$singleGender];
                                            }
                                        }
                                    ?>
                                    {{ implode(', ', $arrayGenderText) }}
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($broadcast->age_band))
                                    <?php 
                                        $arrayConfigAgeBand = config('asgard.broadcast.config.age_band'); 
                                        $arrayAgeBandText = [];
                                        $arrayAgeBand = explode(',', $broadcast->age_band); 
                                        if (count($arrayAgeBand) > 0) {
                                            foreach($arrayAgeBand as $singleAgeBand) {
                                                $arrayAgeBandText[] = $arrayConfigAgeBand[$singleAgeBand];
                                            }
                                        }
                                    ?>
                                    {{ implode(', ', $arrayAgeBandText) }}
                                    @endif
                                </td>
                                <td>
                                    @if (count($broadcast->city) > 0)
                                    <?php 
                                        $arrayCountryText = []; 
                                        foreach($broadcast->city as $singleCity) {
                                            $arrayCountryText[] = $singleCity->country->name;
                                        }
                                    ?>
                                    {{ implode(', ', array_unique($arrayCountryText)) }}
                                    @endif
                                </td>
                                <td>
                                    @if (count($broadcast->city) > 0)
                                    <?php 
                                        $arrayCountryText = []; 
                                        foreach($broadcast->city as $singleCity) {
                                            $arrayCountryText[] = $singleCity->name;
                                        }
                                    ?>
                                    {{ str_limit(implode(', ', array_unique($arrayCountryText)), $limit = 50, $end = '...') }}
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.broadcast.broadcast.edit', [$broadcast->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.broadcast.broadcast.destroy', [$broadcast->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('broadcast::broadcasts.table.id') }}</th>
                                <th>{{ trans('broadcast::broadcasts.table.group name') }}</th>
                                <th>{{ trans('broadcast::broadcasts.table.interest') }}</th>
                                <th>{{ trans('broadcast::broadcasts.table.gender') }}</th>
                                <th>{{ trans('broadcast::broadcasts.table.age band') }}</th>
                                <th>{{ trans('broadcast::broadcasts.table.country') }}</th>
                                <th>{{ trans('broadcast::broadcasts.table.city') }}</th>
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
        <dd>{{ trans('broadcast::broadcasts.title.create broadcast') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.broadcast.broadcast.create') ?>" }
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
