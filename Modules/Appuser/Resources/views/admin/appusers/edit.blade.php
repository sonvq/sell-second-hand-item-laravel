@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('appuser::appusers.title.edit appuser') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.appuser.appuser.index') }}">{{ trans('appuser::appusers.title.appusers') }}</a></li>
        <li class="active">{{ trans('appuser::appusers.title.edit appuser') }}</li>
    </ol>
@stop

@section('styles')
<style>
    .user-info-container .user-info {
        padding: 20px 15px 25px 0;
        display: block;
    }
</style>
@stop


@section('content')
    {!! Form::open(['route' => ['admin.appuser.appuser.update', $appuser->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom user-info-container">     
                <div class="user-info col-md-12">
                    <div class="col-md-2">
                        <label>{{ trans('appuser::appusers.form.username')}}</label>
                    </div>
                    <div class="col-md-10">
                        <p>
                            {{ $appuser->username }}
                        </p>
                    </div>

                    <div class="col-md-2">
                        <label>{{ trans('appuser::appusers.form.fullname')}}</label>
                    </div>
                    <div class="col-md-10">
                        <p>
                            {{ $appuser->full_name }}
                        </p>
                    </div>
                </div>
                
                @include('partials.form-tab-headers')
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1-1" data-toggle="tab">{{ trans('appuser::appusers.tabs.user details') }}</a></li>
                    <li class=""><a href="#tab_2-2" data-toggle="tab">{{ trans('appuser::appusers.tabs.reported cases') }}</a></li>
                    <li class=""><a href="#tab_3-3" data-toggle="tab">{{ trans('appuser::appusers.tabs.user activity') }}</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1-1">
                        @include('appuser::admin.appusers.partials.edit-fields')
                    </div>
                    <div class="tab-pane" id="tab_2-2">
                        @include('appuser::admin.appusers.partials.reported-cases')
                    </div>
                    <div class="tab-pane" id="tab_3-3">
                        @include('appuser::admin.appusers.partials.user-activity')
                    </div>                   
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.appuser.appuser.index') ?>" }
                ]
            });
            $('.selectize').selectize();
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
        <?php $locale = locale(); ?>
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "asc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
        
@endpush
