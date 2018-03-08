<?php

namespace Modules\Discount\Entities;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{

    protected $table = 'discount__discounts';
    protected $fillable = [
        'discount_percent'
    ];
}
