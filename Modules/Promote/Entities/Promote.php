<?php

namespace Modules\Promote\Entities;

use Illuminate\Database\Eloquent\Model;

class Promote extends Model
{

    protected $table = 'promote__promotes';
    protected $fillable = [
        'price_amount',
        'number_of_date_expired' 
    ];
}
