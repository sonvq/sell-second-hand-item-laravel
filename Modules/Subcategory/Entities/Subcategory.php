<?php

namespace Modules\Subcategory\Entities;

use Modules\Category\Entities\Category;
use Illuminate\Database\Eloquent\Model;
use Modules\Appuser\Entities\Appuser;

class Subcategory extends Model
{

    protected $table = 'subcategory__subcategories';
    protected $fillable = [
        'name',
        'status',
        'category_id'
    ];
    
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISH = 'publish';


    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function subcategory_appuser() {
        return $this->belongsToMany(Appuser::class, 'appuser__personalization')->withTimestamps();
    }
}
