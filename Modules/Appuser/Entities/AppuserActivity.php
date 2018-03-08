<?php

namespace Modules\Appuser\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Appuser\Entities\Appuser;
use Modules\Item\Entities\Item;

class AppuserActivity extends Model
{

    protected $table = 'appuser__activity';
    protected $fillable = [
        'appuser_id',
        'action',
        'item_id',
        'log_time'
    ];
    
    const ACTION_SIGNUP = 'Sign up';
    const ACTION_CREATE_ITEM = 'Create item';
    const ACTION_EDIT_ITEM = 'Edit item';
    const ACTION_DISCOUNTED_ITEM = 'Discounted item';
    const ACTION_OFFER_ITEM = 'Offer item';
    const ACTION_OFFER_ITEM_AGAIN = 'Offer item again';
    const ACTION_ACCEPT_ITEM = 'Accept item';
    const ACTION_DECLINE_ITEM = 'Decline item';
    const ACTION_MARK_SOLD_ITEM = 'Mark sold item';    
    const ACTION_PROMOTE_ITEM = 'Promote item';
    
    public function appuser() {
        return $this->belongsTo(Appuser::class);    
    }
    
    public function item() {
        return $this->belongsTo(Item::class);    
    }
    
}