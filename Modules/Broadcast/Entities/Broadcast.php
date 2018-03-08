<?php

namespace Modules\Broadcast\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\City\Entities\City;
use Modules\Subcategory\Entities\Subcategory;

class Broadcast extends Model
{

    protected $table = 'broadcast__broadcasts';
    protected $fillable = [
        'title',
        'gender',
        'age_band',        
    ];
    
    const AGE_18_25 = '18_25';
    const AGE_26_35 = '26_35';
    const AGE_36_50 = '36_50';
    const AGE_ABOVE_50 = 'above_50';
    
    public function city() {
        return $this->belongsToMany(City::class, 'broadcast__city')->withTimestamps();
    }
    
    public function interest() {
        return $this->belongsToMany(Subcategory::class, 'broadcast__interest')->withTimestamps();
    }
}
