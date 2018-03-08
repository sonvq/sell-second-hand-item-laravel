<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("name") ? ' has-error' : '' }}'>
                {!! Form::label("name", trans('country::countries.form.name')) !!}
                {!! Form::text("name", old("name"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('country::countries.form.name')]) !!}
                {!! $errors->first("name", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("description") ? ' has-error' : '' }}'>
                {!! Form::label("description", trans('item::items.form.description')) !!}
                {!! Form::textarea("description", old("description"), ['class' => 'form-control', 'style' => 'height:120px', 'data-slug' => 'source', 'placeholder' => trans('item::items.form.title')]) !!}
                {!! $errors->first("description", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div> 
</div>