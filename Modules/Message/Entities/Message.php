<?php

namespace Modules\Message\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Appuser\Entities\Appuser;
use Modules\Item\Entities\Item;

class Message extends Model
{

    protected $table = 'message__messages'; 
    protected $fillable = [
        'seller_id',
        'buyer_id',
        'item_id',
        'seller_visibility',
        'buyer_visibility',
        'chat_url'
    ];
    
    const VISIBILITY_VISIBLE = 'visible';
    const VISIBILITY_HIDDEN = 'hidden';
    
    public function seller() {
        return $this->hasOne(Appuser::class, 'id', 'seller_id');
    }
    
    public function buyer() {
        return $this->hasOne(Appuser::class, 'id', 'buyer_id');
    }
    
    public function item() {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
    
    public function chat() {
        return $this->hasMany(Chat::class, 'message_id', 'id');
    }
    
}
