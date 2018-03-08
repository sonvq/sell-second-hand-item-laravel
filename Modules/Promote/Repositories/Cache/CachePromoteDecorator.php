<?php

namespace Modules\Promote\Repositories\Cache;

use Modules\Promote\Repositories\PromoteRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePromoteDecorator extends BaseCacheDecorator implements PromoteRepository
{
    public function __construct(PromoteRepository $promote)
    {
        parent::__construct();
        $this->entityName = 'promote.promotes';
        $this->repository = $promote;
    }
}
