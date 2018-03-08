<?php

namespace Modules\Offer\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Appuser\Entities\Appuser;
use Modules\Item\Entities\Item;

class Offer extends Model
{

    protected $table = 'offer__offers';
    protected $fillable = [
        'seller_id',
        'buyer_id',
        'item_id',
        'status',
        'offer_number'
    ];   
            
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_DECLINED = 'declined';        
    
    public function seller() {
        return $this->hasOne(Appuser::class, 'id', 'seller_id');
    }
    
    public function buyer() {
        return $this->hasOne(Appuser::class, 'id', 'buyer_id');
    }
    
    public function item() {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
    
}