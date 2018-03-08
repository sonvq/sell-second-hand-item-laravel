<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("price_amount") ? ' has-error' : '' }}'>
                {!! Form::label("price_amount", trans('promote::promotes.form.price_amount')) !!}
                {!! Form::number("price_amount", $promote->price_amount, ['class' => 'form-control', 'required' => 'required', 'type' => 'number', 'min' => '1', 'data-slug' => 'source', 'placeholder' => trans('promote::promotes.form.price_amount')]) !!}
                {!! $errors->first("price_amount", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-sm-4">
            <div class='form-group{{ $errors->has("number_of_date_expired") ? ' has-error' : '' }}'>
                {!! Form::label("number_of_date_expired", trans('promote::promotes.form.number_of_date_expired')) !!}
                {!! Form::number("number_of_date_expired", $promote->number_of_date_expired, ['class' => 'form-control', 'required' => 'required', 'type' => 'number', 'min' => '1', 'data-slug' => 'source', 'placeholder' => trans('promote::promotes.form.number_of_date_expired')]) !!}
                {!! $errors->first("number_of_date_expired", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div> 
</div>