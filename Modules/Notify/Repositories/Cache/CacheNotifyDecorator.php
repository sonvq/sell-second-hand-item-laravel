<?php

namespace Modules\Notify\Repositories\Cache;

use Modules\Notify\Repositories\NotifyRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheNotifyDecorator extends BaseCacheDecorator implements NotifyRepository
{
    public function __construct(NotifyRepository $notify)
    {
        parent::__construct();
        $this->entityName = 'notify.notifies';
        $this->repository = $notify;
    }
}
