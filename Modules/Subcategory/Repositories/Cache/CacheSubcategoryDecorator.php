<?php

namespace Modules\Subcategory\Repositories\Cache;

use Modules\Subcategory\Repositories\SubcategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSubcategoryDecorator extends BaseCacheDecorator implements SubcategoryRepository
{
    public function __construct(SubcategoryRepository $subcategory)
    {
        parent::__construct();
        $this->entityName = 'subcategory.subcategories';
        $this->repository = $subcategory;
    }
}
