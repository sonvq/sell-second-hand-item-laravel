@section('styles')
<link rel="stylesheet" type="text/css" href="{{ Module::asset('item:vendor/fancybox/jquery.fancybox.min.css') }}">
<style>
    .img-gallery {
        border: 1px solid gray;
        margin-right: 5px;
        height: auto;
        width: auto;
        min-width: 50px;
    }
    .box-chat {
        border: 1px solid gray;
        min-height: 300px;
        max-height: 800px;
        overflow: scroll;
        padding: 15px;
        margin-top: 10px;
    }
    .purple-message {
        color: purple;
    }
    .blue-message {
        color: blue;
    }
    .image-chat {
        max-width: 150px;
        height: auto;
        margin-left: 10px;
    }
    span.datetime-chat {
        color: gray;
    }
</style>
@stop

<div class="box-body">
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('message::messages.table.username 1')}}</label>
        </div>
        <div class="col-md-10">
            <td>
                <?php $seller = $message->seller; ?>
                @if ($seller)
                    {{ $seller->username }}
                @endif                                        
            </td>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('message::messages.table.username 2')}}</label>
        </div>
        <div class="col-md-10">
            <td>
                <?php $buyer = $message->buyer; ?>
                @if ($buyer)
                    {{ $buyer->username }}
                @endif                                        
            </td>
        </div>
    </div>   
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('message::messages.table.item id')}}</label>
        </div>
        <div class="col-md-10">
            <?php $item = $message->item; ?>
            <td>                                        
                @if ($item)
                    {{ $item->id }}
                @endif                                        
            </td>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('message::messages.table.item title')}}</label>
        </div>
        <div class="col-md-10">
            <td>                                        
                @if ($item)
                    {{ $item->title }}
                @endif                                        
            </td>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="box-chat">
                @if (count($chat) > 0)
                    <?php foreach ($chat as $singleChat) : ?>
                    
                        <?php $sender = $singleChat->sender; ?>
                        @if ($sender)
                            @if ($sender->id == $seller->id)
                                <p class="pull-left">
                                    <strong class="purple-message">{{ $singleChat->sender->username }} <span class="datetime-chat">({{ date('d/m/Y H:i:s', strtotime($singleChat->sent_time)) }})</span>:</strong> 
                                    @if ($singleChat->message_type == 'text')
                                        {{ $singleChat->message_content }}
                                    @elseif ($singleChat->message_type == 'image')
                                        <a href="<?php echo $singleChat->message_content; ?>" data-loop="true" data-fancybox="images" data-caption="{{ $item->title }}">
                                            <img class="image-chat img-gallery" src='{{ $singleChat->message_content }}' />
                                        </a>
                                    @endif
                                </p>
                            @else 
                                <p class="pull-right">                                    
                                    @if ($singleChat->message_type == 'text')
                                        {{ $singleChat->message_content }}
                                    @elseif ($singleChat->message_type == 'image')
                                        <a href="<?php echo $singleChat->message_content; ?>" data-loop="true" data-fancybox="images" data-caption="{{ $item->title }}">
                                            <img class="image-chat img-gallery" src='{{ $singleChat->message_content }}' />
                                        </a>
                                    @endif
                                    <strong class="blue-message">: {{ $singleChat->sender->username }} <span class="datetime-chat">({{ date('d/m/Y H:i', strtotime($singleChat->sent_time)) }})</span></strong>
                                </p>
                            @endif
                        @endif     
                        <span class="clearfix"></span>
                    <?php endforeach; ?>
                    
                @endif
            </div>
        </div>
    </div>
  
</div>

@push('js-stack')
    <script src="{{ Module::asset('item:vendor/fancybox/jquery.fancybox.min.js') }}"></script>    
    
@endpush