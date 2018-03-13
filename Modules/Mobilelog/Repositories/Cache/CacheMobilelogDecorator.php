<?php

namespace Modules\Mobilelog\Repositories\Cache;

use Modules\Mobilelog\Repositories\MobilelogRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheMobilelogDecorator extends BaseCacheDecorator implements MobilelogRepository
{
    public function __construct(MobilelogRepository $mobilelog)
    {
        parent::__construct();
        $this->entityName = 'mobilelog.mobilelogs';
        $this->repository = $mobilelog;
    }
}
