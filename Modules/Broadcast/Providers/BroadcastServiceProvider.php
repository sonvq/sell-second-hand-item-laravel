<?php

namespace Modules\Broadcast\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Broadcast\Events\Handlers\RegisterBroadcastSidebar;

class BroadcastServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterBroadcastSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('broadcast', 'permissions');
        $this->publishConfig('broadcast', 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Broadcast\Repositories\BroadcastRepository',
            function () {
                $repository = new \Modules\Broadcast\Repositories\Eloquent\EloquentBroadcastRepository(new \Modules\Broadcast\Entities\Broadcast());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Broadcast\Repositories\Cache\CacheBroadcastDecorator($repository);
            }
        );
// add bindings

    }
}
