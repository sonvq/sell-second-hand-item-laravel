<?php

namespace Modules\Notifications\Entities;


use Illuminate\Database\Eloquent\Model;
use Modules\Broadcast\Entities\Broadcast;

class Notifications extends Model
{


    protected $table = 'notifications__notifications';
    protected $fillable = [
        'name',
        'broadcast_id',
        'status',
        'channels',
        'schedule_date_from',
        'schedule_date_to'
    ];
    
    public function broadcast() {
        return $this->belongsTo(Broadcast::class);    
    }
    
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_SCHEDULED = 'scheduled';
    
}
