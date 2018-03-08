<?php

namespace Modules\Notify\Entities;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{

    protected $table = 'notify__notifies';
    protected $fillable = [
        'sender_id',
        'sender_type',
        'receiver_id',
        'receiver_type',
        'title',
        'message',
        'message_type',
        'is_new',
        'is_read'
    ];
    
    const TYPE_MAKE_OFFER = 'TYPE_MAKE_OFFER';
    const TYPE_MAKE_OFFER_AGAIN = 'TYPE_MAKE_OFFER_AGAIN';
    const TYPE_ACCEPTED_OFFER = 'TYPE_ACCEPTED_OFFER';
    const TYPE_DECLINED_OFFER = 'TYPE_DECLINED_OFFER';
    
    const TYPE_BROADCAST_PUSH = 'TYPE_BROADCAST_PUSH';
}
