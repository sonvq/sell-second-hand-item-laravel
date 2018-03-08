<?php

namespace Modules\Pages\Repositories\Cache;

use Modules\Pages\Repositories\PagesRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePagesDecorator extends BaseCacheDecorator implements PagesRepository
{
    public function __construct(PagesRepository $pages)
    {
        parent::__construct();
        $this->entityName = 'pages.pages';
        $this->repository = $pages;
    }
}
