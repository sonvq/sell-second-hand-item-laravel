<?php

namespace Modules\Appuser\Entities;

use Illuminate\Database\Eloquent\Model;

class AppuserLogin extends Model
{

    protected $table = 'appuser__login';
    protected $fillable = [
        'appuser_id',
        'token'        
    ];
    
    public function appuser() {
        return $this->belongsTo(Appuser::class);    
    }
}

