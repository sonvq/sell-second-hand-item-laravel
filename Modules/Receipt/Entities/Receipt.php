<?php

namespace Modules\Receipt\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Item\Entities\Item;
use Modules\Appuser\Entities\Appuser;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use SoftDeletes;
    
    protected $table = 'receipt__receipts';
    protected $fillable = [
        'appuser_id',
        'item_id',
        'total_promo_days',
        'promo_period_from',
        'promo_period_to',
        'payment_mode',
        'transaction_type',
        'transaction_ref_id',
        'remarks',
        'amount_due'
    ];
    
    protected $dates = ['deleted_at'];
    
    public function appuser() {
        return $this->hasOne(Appuser::class, 'id', 'appuser_id');
    }
    
    public function item() {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
}