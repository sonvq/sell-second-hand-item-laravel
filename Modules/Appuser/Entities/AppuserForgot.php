<?php

namespace Modules\Appuser\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Appuser\Entities\Appuser;

class AppuserForgot extends Model
{

    protected $table = 'appuser__forgot';
    protected $fillable = [
        'appuser_id',
        'token',
        'status',
        'completed_at'
    ];
    
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    
    public function appuser() {
        return $this->belongsTo(Appuser::class);    
    }
    
}