<?php

namespace Modules\Reporting\Entities;

use Illuminate\Database\Eloquent\Model;

class ReportingReason extends Model
{

    protected $table = 'reporting__reasons';
    protected $fillable = [
        'name'
    ];
}
