<?php

namespace Modules\Broadcast\Repositories\Cache;

use Modules\Broadcast\Repositories\BroadcastRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheBroadcastDecorator extends BaseCacheDecorator implements BroadcastRepository
{
    public function __construct(BroadcastRepository $broadcast)
    {
        parent::__construct();
        $this->entityName = 'broadcast.broadcasts';
        $this->repository = $broadcast;
    }
}
