<?php

namespace Modules\Discount\Repositories\Cache;

use Modules\Discount\Repositories\DiscountRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheDiscountDecorator extends BaseCacheDecorator implements DiscountRepository
{
    public function __construct(DiscountRepository $discount)
    {
        parent::__construct();
        $this->entityName = 'discount.discounts';
        $this->repository = $discount;
    }
}
