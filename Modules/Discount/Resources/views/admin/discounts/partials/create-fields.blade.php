<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("discount_percent") ? ' has-error' : '' }}'>
                {!! Form::label("discount_percent", trans('discount::discounts.form.discount_percent')) !!}
                {!! Form::text("discount_percent", old("discount_percent"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('discount::discounts.form.discount_percent')]) !!}
                {!! $errors->first("discount_percent", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>     
</div>