<?php

namespace Modules\Reporting\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Appuser\Entities\Appuser;
use Modules\Reporting\Entities\ReportingReason;
use Modules\Item\Entities\Item;

class Reporting extends Model
{

    protected $table = 'reporting__reportings';
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'reporting_reason_id',
        'item_id'
    ];
    
    public function sender() {
        return $this->belongsTo(Appuser::class);    
    }
    
    public function receiver() {
        return $this->belongsTo(Appuser::class);    
    }
    
    public function reporting_reason() {
        return $this->belongsTo(ReportingReason::class);    
    }
    
    public function item() {
        return $this->belongsTo(Item::class);    
    }
}