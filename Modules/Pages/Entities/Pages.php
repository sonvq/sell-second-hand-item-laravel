<?php

namespace Modules\Pages\Entities;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{

    protected $table = 'pages__pages';
    protected $fillable = [
        'page_type',
        'description',
        'status'
    ];
    
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISH = 'publish';
    
    const PAGE_TYPE_LANDING = 'landing_page';
    const PAGE_TYPE_ABOUT_US = 'about_us';
    const PAGE_TYPE_TERMS_CONDITIONS = 'terms_conditions';
}
   