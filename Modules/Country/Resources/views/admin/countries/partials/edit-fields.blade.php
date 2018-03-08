<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("name") ? ' has-error' : '' }}'>
                {!! Form::label("name", trans('country::countries.form.name')) !!}
                {!! Form::text("name", $country->name, ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('country::countries.form.name')]) !!}
                {!! $errors->first("name", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>     
</div>