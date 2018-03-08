<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("name") ? ' has-error' : '' }}'>
                {!! Form::label("name", trans('subcategory::subcategories.form.name')) !!}
                {!! Form::text("name", old("name"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('subcategory::subcategories.form.name')]) !!}
                {!! $errors->first("name", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("category_id") ? ' has-error' : '' }}'>
                {!! Form::label("category_id", trans('subcategory::subcategories.form.category_id')) !!}
                {!! Form::select('category_id', $categories, old("category_id"), ['class' => 'selectize']) !!}
                {!! $errors->first("category_id", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>  
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("status") ? ' has-error' : '' }}'>
                {!! Form::label("status", trans('subcategory::subcategories.form.status')) !!}
                {!! Form::select('status', config('asgard.subcategory.config.status'), old("status"), ['class' => 'selectize']) !!}
                {!! $errors->first("status", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>  
</div>