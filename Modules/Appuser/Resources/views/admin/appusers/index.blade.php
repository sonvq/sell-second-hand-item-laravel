@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('appuser::appusers.title.appusers') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('appuser::appusers.title.appusers') }}</li>
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
<!--                    <a href="{{ route('admin.appuser.appuser.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('appuser::appusers.button.create appuser') }}
                    </a>-->
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">                    
                    <div class="wraper_filter_form">
                        <form method="GET" action="" accept-charset="UTF-8" class="col-md-12 form-inline pull-left filter-table-advance">
                            <div class="row">
                                <div class="col-md-1">
                                    <label>{{ trans('appuser::appusers.table.username') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <input id="filter_username" class="form-control searchable-input" value="" placeholder="Username" name="username" type="text" data-column-index="1"> 
                                </div>
                                <div class="col-md-1 col-md-offset-2">
                                    <label>{{ trans('appuser::appusers.table.city') }}</label>
                                </div>
                                 
                                <div class="col-md-2">
                                    <div class='form-group'>
                                        <select id="filter_city" class="form-control searchable-select" name="city" data-column-index="7">
                                            <option selected="selected" value="">Select city</option>
                                            @if (count($cities) > 0)                                           
                                                <?php foreach ($cities as $city) : ?>
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                <?php endforeach; ?>
                                            @endif
                                        </select>            
                                    </div>                                          
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-1">
                                    <label>{{ trans('appuser::appusers.table.fullname') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <input id="filter_full_name" class="form-control searchable-input" value="" placeholder="Full name" name="full_name" type="text" data-column-index="2">
                                </div>
                                <div class="col-md-1 col-md-offset-2">
                                    <label>{{ trans('appuser::appusers.table.report user?') }}</label>
                                </div>
                                 
                                <div class="col-md-2">
                                    <div class='form-group'>
                                        <select id="filter_report_user" class="form-control searchable-select" name="report_user" data-column-index="8">
                                            <option selected="selected" value="">{{ trans('appuser::appusers.table.select_report_user') }}</option>
                                            <option value="Y">Y</option>
                                            <option value="N">N</option>
                                        </select>            
                                    </div>                                          
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-1">
                                    <label>{{ trans('appuser::appusers.table.email') }}</label>
                                </div>
                                <div class="col-md-2">
                                    <input id="filter_email" class="form-control searchable-input" value="" placeholder="Email Address" name="email" type="text" data-column-index="3">
                                </div>
                                <div class="col-md-1 col-md-offset-2">
                                    <label>{{ trans('appuser::appusers.table.status') }}</label>
                                </div>
                                 
                                <div class="col-md-2">
                                    <div class='form-group'>
                                        <select id="filter_status" class="form-control searchable-select" name="status" data-column-index="10">
                                            <option selected="selected" value="">{{ trans('appuser::appusers.table.select_status') }}</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>            
                                    </div>                                          
                                </div>
                            </div>            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">                                    
                                        <a class="btn btn-primary filter-table-reset">Reset</a>
                                        <a class="btn btn-primary btn-export-excel">
                                            <i class="fa fa-download" aria-hidden="true"></i> {{ trans('appuser::appusers.button.export') }}
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
                        <table id="user-account" class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('appuser::appusers.table.id') }}</th>
                                <th>{{ trans('appuser::appusers.table.username') }}</th>
                                <th>{{ trans('appuser::appusers.table.fullname') }}</th>
                                <th>{{ trans('appuser::appusers.table.email') }}</th>
                                <th>{{ trans('appuser::appusers.table.mobile') }}</th>
                                <th>{{ trans('appuser::appusers.table.gender') }}</th>
                                <th>{{ trans('appuser::appusers.table.date_of_birth') }}</th>
                                <th>{{ trans('appuser::appusers.table.city') }}</th>
                                <th>{{ trans('appuser::appusers.table.report user?') }}</th>
                                <th>{{ trans('appuser::appusers.table.total_reported_case') }}</th>                                
                                <th>{{ trans('appuser::appusers.table.status') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($appusers) && (count($appusers) > 0)): ?>
                                <?php foreach ($appusers as $appuser): ?>
                                    <tr>
                                        <td>
                                            {{ $appuser->id }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.appuser.appuser.edit', [$appuser->id]) }}">
                                                {{ $appuser->username }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $appuser->full_name }}
                                        </td>
                                        <td>
                                            {{ $appuser->email }}
                                        </td>
                                        <td>
                                            {{ $appuser->phone_number }}
                                        </td>
                                        <td>
                                            @if ($appuser->gender == 'male')
                                                Male
                                            @else 
                                                Female
                                            @endif
                                        </td>
                                        <td>
                                            {{ date('d/m/Y', strtotime($appuser->date_of_birth)) }}
                                        </td>
                                        <td>
                                            <?php $cityUser = $appuser->city; ?>
                                            @if ($cityUser)
                                                {{ $cityUser->name }}
                                            @endif
                                        </td>   
                                        <td>
                                            @if ($appuser->report_receiver->count() > 0)
                                                Y
                                            @else
                                                N
                                            @endif
                                        </td>
                                        <td>
                                            {{ $appuser->report_receiver->count() }}
                                        </td>
                                        <td>
                                            @if ($appuser->status == 'active')
                                                Active
                                            @elseif ($appuser->status == 'inactive')
                                                Inactive
                                            @endif
                                        </td> 
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.appuser.appuser.edit', [$appuser->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
        <!--                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.appuser.appuser.destroy', [$appuser->id]) }}"><i class="fa fa-trash"></i></button>-->
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('appuser::appusers.table.id') }}</th>
                                <th>{{ trans('appuser::appusers.table.username') }}</th>
                                <th>{{ trans('appuser::appusers.table.fullname') }}</th>
                                <th>{{ trans('appuser::appusers.table.email') }}</th>
                                <th>{{ trans('appuser::appusers.table.mobile') }}</th>
                                <th>{{ trans('appuser::appusers.table.gender') }}</th>
                                <th>{{ trans('appuser::appusers.table.date_of_birth') }}</th>                                
                                <th>{{ trans('appuser::appusers.table.city') }}</th>
                                <th>{{ trans('appuser::appusers.table.report user?') }}</th>
                                <th>{{ trans('appuser::appusers.table.total_reported_case') }}</th> 
                                <th>{{ trans('appuser::appusers.table.status') }}</th>
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
<!--    @include('core::partials.delete-modal')-->
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('appuser::appusers.title.create appuser') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.appuser.appuser.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">

        $(function () {          
            $('.btn-export-excel').on('click', function(){
                var filter_username = $('#filter_username').val();
                var filter_full_name = $('#filter_full_name').val();
                var filter_email = $('#filter_email').val();
                var filter_city = $('#filter_city').val();
                var filter_status = $('#filter_status').val();
                var filter_report_user = $('#filter_report_user').val();
                
                var url = '{{ URL::route("admin.appuser.appuser.export") }}';
                var fullUrl = url + '?username=' + filter_username + '&full_name=' + filter_full_name
                    + '&email=' + filter_email + '&city_id=' + filter_city + '&status=' + filter_status
                    + '&report_user=' + filter_report_user;
                window.location.replace(fullUrl);
                

            });    
            
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
