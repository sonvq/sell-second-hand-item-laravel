<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("page_type") ? ' has-error' : '' }}'>
                {!! Form::label("page_type", trans('pages::pages.form.page_type')) !!}
                {!! Form::select('page_type', config('asgard.pages.config.page_type'), old("page_type"), ['class' => 'selectize']) !!}
                {!! $errors->first("page_type", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>  
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("description") ? ' has-error' : '' }}'>
                {!! Form::label("description", trans('pages::pages.form.description')) !!}
                {!! Form::textarea("description", old("description"), ['class' => 'form-control', 'style' => 'height:200px', 'data-slug' => 'source', 'placeholder' => trans('pages::pages.form.description')]) !!}
                {!! $errors->first("description", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("status") ? ' has-error' : '' }}'>
                {!! Form::label("status", trans('pages::pages.form.status')) !!}
                {!! Form::select('status', config('asgard.pages.config.status'), old("status"), ['class' => 'selectize']) !!}
                {!! $errors->first("status", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>  
</div>