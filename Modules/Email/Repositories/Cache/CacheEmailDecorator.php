<?php

namespace Modules\Email\Repositories\Cache;

use Modules\Email\Repositories\EmailRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheEmailDecorator extends BaseCacheDecorator implements EmailRepository
{
    public function __construct(EmailRepository $email)
    {
        parent::__construct();
        $this->entityName = 'email.emails';
        $this->repository = $email;
    }
}
