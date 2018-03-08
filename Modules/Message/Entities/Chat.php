<?php

namespace Modules\Message\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Message\Entities\Message;
use Modules\Appuser\Entities\Appuser;

class Chat extends Model
{

    protected $table = 'chat__chats'; 
    protected $fillable = [
        'message_id',
        'sender_id',
        'message_content',
        'sent_time',
        'message_type'
    ];
   
    public function message() {
        return $this->belongsTo(Message::class, 'mesage_id', 'id');
    }
    
    public function sender() {
        return $this->belongsTo(Appuser::class, 'sender_id', 'id');
    }       
    
}
