<?php

namespace Modules\Email\Entities;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{

    protected $table = 'email__emails';
    protected $fillable = [
        'type',
        'subject',
        'content',
        'status'
    ];

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISH = 'publish';

    const TYPE_CHANGE_PASSWORD = 'change_password';
    const TYPE_FORGOT_PASSWORD = 'forgot_password';
    const TYPE_NOTIFICATION_EMAIL = 'notification_email';
    const TYPE_PROMOTE_EMAIL = 'promote_email';
    const TYPE_WELCOME_EMAIL = 'welcome_email';
}
