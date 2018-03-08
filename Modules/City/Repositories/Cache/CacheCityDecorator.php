<?php

namespace Modules\City\Repositories\Cache;

use Modules\City\Repositories\CityRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCityDecorator extends BaseCacheDecorator implements CityRepository
{
    public function __construct(CityRepository $city)
    {
        parent::__construct();
        $this->entityName = 'city.cities';
        $this->repository = $city;
    }
}
