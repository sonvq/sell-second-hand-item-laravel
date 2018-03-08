<?php

namespace Modules\Base\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

    protected $listen = [
        'Dingo\Api\Event\ResponseWasMorphed' => [
            'Modules\Base\Events\Handlers\CustomResponseBeforeRender'
        ]
    ];

}
