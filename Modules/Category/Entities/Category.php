<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Subcategory\Entities\Subcategory;

class Category extends Model
{

    protected $table = 'category__categories';
    protected $fillable = [
        'name',
        'status'
    ];
    
    public function subcategory_list() {
        return $this->hasMany(Subcategory::class);
    }
}
