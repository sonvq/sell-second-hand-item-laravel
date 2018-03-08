<?php

namespace Modules\Country\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\City\Entities\City;

class Country extends Model
{

    protected $table = 'country__countries'; 
    protected $fillable = [
        'name'
    ];
    
    public function city_list() {
        return $this->hasMany(City::class);
    }
    
}
