<?php

namespace Modules\Broadcast\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\City\Entities\City;
use Modules\Subcategory\Entities\Subcategory;

class BroadcastInterest extends Model
{

    protected $table = 'broadcast__interest';
    protected $fillable = [
        'broadcast_id',
        'subcategory_id'       
    ];  
}
