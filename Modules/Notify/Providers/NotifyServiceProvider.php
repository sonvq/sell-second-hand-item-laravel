<?php

namespace Modules\Notify\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Notify\Events\Handlers\RegisterNotifySidebar;

class NotifyServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterNotifySidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('notify', 'permissions');
        $this->publishConfig('notify', 'config');

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
            'Modules\Notify\Repositories\NotifyRepository',
            function () {
                $repository = new \Modules\Notify\Repositories\Eloquent\EloquentNotifyRepository(new \Modules\Notify\Entities\Notify());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Notify\Repositories\Cache\CacheNotifyDecorator($repository);
            }
        );
// add bindings

    }
}
