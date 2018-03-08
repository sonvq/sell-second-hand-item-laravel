<?php

namespace Modules\Reporting\Repositories\Cache;

use Modules\Reporting\Repositories\ReportingRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheReportingDecorator extends BaseCacheDecorator implements ReportingRepository
{
    public function __construct(ReportingRepository $reporting)
    {
        parent::__construct();
        $this->entityName = 'reporting.reportings';
        $this->repository = $reporting;
    }
}
