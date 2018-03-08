<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("name") ? ' has-error' : '' }}'>
                {!! Form::label("name", trans('city::cities.form.name')) !!}
                {!! Form::text("name", $city->name, ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('city::cities.form.name')]) !!}
                {!! $errors->first("name", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("country_id") ? ' has-error' : '' }}'>
                {!! Form::label("country_id", trans('city::cities.form.country_id')) !!}
                {!! Form::select('country_id', $countries, $city->country_id, ['class' => 'selectize']) !!}
                {!! $errors->first("country_id", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>  
</div>