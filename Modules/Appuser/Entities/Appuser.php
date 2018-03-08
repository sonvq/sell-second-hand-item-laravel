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

class Appuser extends Model
{

    use MediaRelation;
    
    protected $table = 'appuser__appusers';
    protected $fillable = [
        'username',
        'full_name',
        'email',
        'phone_number',
        'gender',
        'date_of_birth',
        'country_id',
        'city_id',
        'password',
        'push_notification',
        'first_time_login',
        'status'
    ];
    
    protected $hidden = [
        'password'
    ];
    
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const ZONE_APPUSER_AVATAR_IMAGE = 'AppuserAvatarImage';  
    
    public function avatar_image() {
        return $this->belongsToMany(File::class, 'media__imageables', 'imageable_id', 'file_id')
            ->wherePivot('imageable_type', self::class)
            ->wherePivot('zone', self::ZONE_APPUSER_AVATAR_IMAGE)
            ->withTimestamps();
    }
    
    public function report_sender() {
        return $this->hasMany(Reporting::class, 'sender_id', 'id');
    }
    
    public function report_receiver() {
        return $this->hasMany(Reporting::class, 'receiver_id', 'id');
    }
    
    public function country() {
        return $this->belongsTo(Country::class);    
    }
    
    public function city() {
        return $this->belongsTo(City::class);    
    }
    
    public function favorite_item() {
        return $this->belongsToMany(Item::class, 'items__favorite')->withTimestamps();
    }
    
    public function personalization_subcategory() {
        return $this->belongsToMany(Subcategory::class, 'appuser__personalization')->withTimestamps();
    }
}

