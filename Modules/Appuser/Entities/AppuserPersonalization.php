<?php

namespace Modules\Appuser\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Country\Entities\Country;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\City\Entities\City;
use Modules\Item\Entities\Item;
use Modules\Item\Entities\ItemFavorite;
use Modules\Subcategory\Entities\Subcategory;
use Modules\Media\Entities\File;
use Modules\Reporting\Entities\Reporting;

class AppuserPersonalization extends Model
{

    use MediaRelation;
    
    protected $table = 'appuser__personalization';
    protected $fillable = [
        'appuser_id',
        'subcategory_id'        
    ];
        
}

