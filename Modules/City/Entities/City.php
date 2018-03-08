<?php

namespace Modules\City\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Country\Entities\Country;
class City extends Model
{

    protected $table = 'city__cities';
    protected $fillable = [
        'name',
        'country_id'
    ];
    
    public function country() {
        return $this->belongsTo(Country::class);
    }
}
