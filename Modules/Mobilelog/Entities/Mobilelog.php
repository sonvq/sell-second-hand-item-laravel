<?php

namespace Modules\Mobilelog\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Appuser\Entities\Appuser;

class Mobilelog extends Model
{

    protected $table = 'mobilelog__mobilelogs';
    protected $fillable = [
        'content',
        'file_name',
        'function_name',
        'appuser_id'
    ];
    
    public function appuser() {
        return $this->belongsTo(Appuser::class);    
    }
}
