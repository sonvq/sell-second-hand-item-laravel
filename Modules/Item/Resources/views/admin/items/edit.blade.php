@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('item::items.title.edit item') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.item.item.index') }}">{{ trans('item::items.title.items') }}</a></li>
        <li class="active">{{ trans('item::items.title.edit item') }}</li>
    </ol>
@stop

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ Module::asset('item:vendor/fancybox/jquery.fancybox.min.css') }}">
<style>
#map {
    width: 400px;
    height: 250px;
}
.img-gallery {
    border: 1px solid gray;
    margin-right: 5px;
    height: auto;
    width: auto;
    min-width: 50px;
}
</style>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.item.item.update', $item->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('item::admin.items.partials.edit-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
<!--                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>-->
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.item.item.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop

@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop