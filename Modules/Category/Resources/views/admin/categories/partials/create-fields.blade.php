<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("name") ? ' has-error' : '' }}'>
                {!! Form::label("name", trans('category::categories.form.name')) !!}
                {!! Form::text("name", old("name"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('category::categories.form.name')]) !!}
                {!! $errors->first("name", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("status") ? ' has-error' : '' }}'>
                {!! Form::label("status", trans('category::categories.form.status')) !!}
                {!! Form::select('status', config('asgard.category.config.status'), old("status"), ['class' => 'selectize']) !!}
                {!! $errors->first("status", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>  
</div>