<?php

namespace Modules\Offer\Repositories\Cache;

use Modules\Offer\Repositories\OfferRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOfferDecorator extends BaseCacheDecorator implements OfferRepository
{
    public function __construct(OfferRepository $offer)
    {
        parent::__construct();
        $this->entityName = 'offer.offers';
        $this->repository = $offer;
    }
}
