<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("name") ? ' has-error' : '' }}'>
                {!! Form::label("name", trans('reporting::reporting-reasons.form.name')) !!}
                {!! Form::text("name", old("name"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('reporting::reporting-reasons.form.name')]) !!}
                {!! $errors->first("name", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>     
</div>