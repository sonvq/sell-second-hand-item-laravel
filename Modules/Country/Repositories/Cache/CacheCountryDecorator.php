<?php

namespace Modules\Country\Repositories\Cache;

use Modules\Country\Repositories\CountryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCountryDecorator extends BaseCacheDecorator implements CountryRepository
{
    public function __construct(CountryRepository $country)
    {
        parent::__construct();
        $this->entityName = 'country.countries';
        $this->repository = $country;
    }
}
