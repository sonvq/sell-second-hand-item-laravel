<?php

namespace Modules\Receipt\Repositories\Cache;

use Modules\Receipt\Repositories\ReceiptRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheReceiptDecorator extends BaseCacheDecorator implements ReceiptRepository
{
    public function __construct(ReceiptRepository $receipt)
    {
        parent::__construct();
        $this->entityName = 'receipt.receipts';
        $this->repository = $receipt;
    }
}
