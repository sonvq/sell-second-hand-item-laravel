<div class="box-body">
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('appuser::appusers.form.email')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                {{ $appuser->email }}
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('appuser::appusers.form.mobile')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                {{ $appuser->phone_number }}
            </p>
        </div>
    </div>   
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('appuser::appusers.form.date_of_birth')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                {{ date('d/m/Y', strtotime($appuser->date_of_birth)) }}
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('appuser::appusers.form.country')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                <?php $userCountry = $appuser->country; ?>
                @if ($userCountry)
                    {{ $appuser->country->name }}
                @endif
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('appuser::appusers.form.city')}}</label>
        </div>
        <div class="col-md-10">
            <p>
                <?php $userCity = $appuser->city; ?>
                @if ($userCity)
                    {{ $appuser->city->name }}
                @endif
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            {!! Form::label("status", trans('appuser::appusers.form.status')) !!}
        </div>
        <div class="col-md-2">
            <div class='form-group{{ $errors->has("status") ? ' has-error' : '' }}'>                
                {!! Form::select('status', config('asgard.appuser.config.status'), $appuser->status, ['class' => 'selectize']) !!}
                {!! $errors->first("status", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>  
</div>

<div class="box-footer">
    <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
    <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.appuser.appuser.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
</div>
