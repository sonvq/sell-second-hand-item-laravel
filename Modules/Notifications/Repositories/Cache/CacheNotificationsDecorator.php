<?php

namespace Modules\Notifications\Repositories\Cache;

use Modules\Notifications\Repositories\NotificationsRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheNotificationsDecorator extends BaseCacheDecorator implements NotificationsRepository
{
    public function __construct(NotificationsRepository $notifications)
    {
        parent::__construct();
        $this->entityName = 'notifications.notifications';
        $this->repository = $notifications;
    }
}
