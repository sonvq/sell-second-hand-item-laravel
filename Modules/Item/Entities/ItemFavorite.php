<?php

namespace Modules\Item\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Country\Entities\Country;
use Modules\City\Entities\City;
use Modules\Appuser\Entities\Appuser;
use Modules\Category\Entities\Category;
use Modules\Subcategory\Entities\Subcategory;
use Modules\Media\Entities\File;

class ItemFavorite extends Model
{

    protected $table = 'items__favorite';
    protected $fillable = [
        'appuser_id',
        'item_id'       
    ];
        
}
