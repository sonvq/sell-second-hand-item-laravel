@section('styles')
<link rel="stylesheet" type="text/css" href="{{ Module::asset('dashboard:vendor/jquery-ui/themes/blitzer/jquery-ui.min.css') }}">

<style>

</style>
@stop

<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("name") ? ' has-error' : '' }}'>
                {!! Form::label("name", trans('notifications::notifications.form.name')) !!}
                {!! Form::text("name", old("name"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('notifications::notifications.form.name')]) !!}
                {!! $errors->first("name", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("broadcast_id") ? ' has-error' : '' }}'>
                {!! Form::label("broadcast_id", trans('notifications::notifications.form.broadcast group')) !!}
                {!! Form::select('broadcast_id', $broadcasts, old("broadcast_id"), ['name'=>'broadcast_id', 'class' => 'selectize']) !!}
                {!! $errors->first("broadcast_id", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div> 
    <div class="row schedule-time-row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("schedule_date_from") ? ' has-error' : '' }}'>
                {!! Form::label("schedule_date_from", trans('notifications::notifications.form.schedule date from')) !!}
                {!! Form::text('schedule_date_from', old("schedule_date_from"), ['readonly' => 'true', 'name'=>'schedule_date_from', 'class' => 'form-control has-date-picker']) !!}
                {!! $errors->first("schedule_date_from", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("schedule_date_to") ? ' has-error' : '' }}'>
                {!! Form::label("schedule_date_to", trans('notifications::notifications.form.schedule date to')) !!}
                {!! Form::text('schedule_date_to', old("schedule_date_to"), ['readonly' => 'true', 'name'=>'schedule_date_to', 'class' => 'form-control has-date-picker']) !!}
                {!! $errors->first("schedule_date_to", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("status") ? ' has-error' : '' }}'>
                {!! Form::label("status", trans('notifications::notifications.form.status')) !!}
                {!! Form::select('status', config('asgard.notifications.config.status'), old("status"), ['class' => 'selectize']) !!}
                {!! $errors->first("status", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("channels") ? ' has-error' : '' }}'>
                {!! Form::label("channels", trans('notifications::notifications.form.channels')) !!}
                {!! Form::select('channels', config('asgard.notifications.config.channels'), old("channels"), ['class' => 'selectize']) !!}
                {!! $errors->first("channels", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div> 
</div>


@push('js-stack')
    <script src="{{ Module::asset('dashboard:vendor/jquery-ui/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.item.item.create') ?>" }
                ]
            });
            
            var statusDropdown = $('#status').val();
            if (statusDropdown == 'scheduled') {
                $('.schedule-time-row').show();                    
            } else {
                $('.schedule-time-row').hide();
            }
            
            $('#status').on('change', function() {
                var selectedStatus = $(this).val();
                if (selectedStatus == 'scheduled') {
                    $('.schedule-time-row').show();                    
                } else {
                    $('.schedule-time-row').hide();
                }
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.has-date-picker').datepicker({
                dateFormat: 'dd/mm/yy'
            });
                        
        });
    </script>
@endpush

