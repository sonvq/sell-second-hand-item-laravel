<?php

namespace Modules\Item\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Country\Entities\Country;
use Modules\City\Entities\City;
use Modules\Appuser\Entities\Appuser;
use Modules\Category\Entities\Category;
use Modules\Subcategory\Entities\Subcategory;
use Modules\Media\Entities\File;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Item\Entities\ItemFavorite;
use Modules\Promote\Entities\Promote;
use Modules\Offer\Entities\Offer;
use Modules\Message\Entities\Message;

class Item extends Model
{
    use MediaRelation;

    protected $table = 'item__items';
    protected $fillable = [
        'appuser_id',
        'title',
        'description',
        'country_id',
        'city_id',
        'category_id',
        'subcategory_id',
        'item_condition',
        'price_currency',
        'deliver',
        'price_number',
        'meetup_location',
        'latitude',
        'longitude',
        'discount_price_number',
        'discount_percent',
        'featured',
        'promote_method',
        'promote_package',
        'featured_start_date',
        'featured_end_date',
        'sell_status'
    ];
           
    const ZONE_ITEM_GALLERY_IMAGE = 'ItemGalleryImage';
    const SELL_STATUS_SELLING = 'selling';
    const SELL_STATUS_SOLD = 'sold';
    
    public function gallery() {
        return $this->belongsToMany(File::class, 'media__imageables', 'imageable_id', 'file_id')
            ->wherePivot('imageable_type', self::class)
            ->wherePivot('zone', self::ZONE_ITEM_GALLERY_IMAGE)
            ->withTimestamps();
    }
    
    public function country() {
        return $this->belongsTo(Country::class);    
    }
    
    public function city() {
        return $this->belongsTo(City::class);    
    }
    
    public function appuser() {
        return $this->belongsTo(Appuser::class);    
    }
    
    public function category() {
        return $this->belongsTo(Category::class);    
    }
    
    public function subcategory() {
        return $this->belongsTo(Subcategory::class);    
    }
    
    public function favorite_user() {
        return $this->belongsToMany(Appuser::class, 'items__favorite')->withTimestamps();
    }
    
    public function promote() {
        return $this->belongsTo(Promote::class, 'promote_package', 'id');  
    }
    
    public function message() {
        return $this->hasMany(Message::class, 'item_id', 'id');  
    }
    
    public function offer() {
        return $this->hasMany(Offer::class);
    }
    
    public function accepted_offer() {
        return $this->hasOne(Offer::class)->where('status', Offer::STATUS_ACCEPTED);
    }
}
