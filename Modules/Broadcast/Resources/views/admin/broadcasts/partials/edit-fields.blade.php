@section('styles')
<link rel="stylesheet" type="text/css" href="{{ Module::asset('dashboard:vendor/jquery-ui/themes/blitzer/jquery-ui.min.css') }}">

<style>
    .select-multiple {
        height: 200px !important;
    }
    
    .select-multiple-small {
        height: 60px !important;
    }
    .select-multiple-medium {
        height: 100px !important;
    }
</style>
@stop

<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("title") ? ' has-error' : '' }}'>
                {!! Form::label("title", trans('broadcast::broadcasts.form.title')) !!}
                {!! Form::text("title", $broadcast->title, ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('broadcast::broadcasts.form.title')]) !!}
                {!! $errors->first("title", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("subcategories") ? ' has-error' : '' }}'>
                {!! Form::label("subcategories", trans('broadcast::broadcasts.form.subcategories')) !!}
                {!! Form::select('subcategories', $subcategory, $broadcast->interest->pluck('id')->toArray(), ['multiple'=>'multiple', 'name'=>'subcategories[]', 'class' => 'select-multiple form-control']) !!}
                {!! $errors->first("subcategories", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("gender") ? ' has-error' : '' }}'>
                {!! Form::label("gender", trans('broadcast::broadcasts.form.gender')) !!}
                {!! Form::select('gender', $gender, explode(',', $broadcast->gender), ['multiple'=>'multiple', 'name'=>'gender[]', 'class' => 'select-multiple-small form-control']) !!}
                {!! $errors->first("gender", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("age_band") ? ' has-error' : '' }}'>
                {!! Form::label("age_band", trans('broadcast::broadcasts.form.age_band')) !!}
                {!! Form::select('age_band', $age_band, explode(',', $broadcast->age_band), ['multiple'=>'multiple', 'name'=>'age_band[]', 'class' => 'select-multiple-medium form-control']) !!}
                {!! $errors->first("age_band", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("cities") ? ' has-error' : '' }}'>
                {!! Form::label("cities", trans('broadcast::broadcasts.form.cities')) !!}
                {!! Form::select('cities', $city, $broadcast->city->pluck('id')->toArray(), ['multiple'=>'multiple', 'name'=>'cities[]', 'class' => 'select-multiple form-control']) !!}
                {!! $errors->first("cities", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div> 
</div>