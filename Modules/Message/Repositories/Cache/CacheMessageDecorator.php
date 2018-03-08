<?php

namespace Modules\Message\Repositories\Cache;

use Modules\Message\Repositories\MessageRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheMessageDecorator extends BaseCacheDecorator implements MessageRepository
{
    public function __construct(MessageRepository $message)
    {
        parent::__construct();
        $this->entityName = 'message.messages';
        $this->repository = $message;
    }
}
