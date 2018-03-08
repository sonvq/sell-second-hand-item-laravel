<?php

namespace Modules\Appuser\Repositories\Cache;

use Modules\Appuser\Repositories\AppuserRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAppuserDecorator extends BaseCacheDecorator implements AppuserRepository
{
    public function __construct(AppuserRepository $appuser)
    {
        parent::__construct();
        $this->entityName = 'appuser.appusers';
        $this->repository = $appuser;
    }
}
