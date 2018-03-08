<?php

namespace Modules\Appuser\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Appuser\Entities\Appuser;

class AppuserDevice extends Model
{
    protected $table = 'devices';
    protected $fillable = [
        'appuser_id',        
        'device_token',
        'device_type',
        'player_id'
    ];
    
    public function appuser () {
        return $this->hasOne(Appuser::class, 'id', 'appuser_id');
    }    
}
