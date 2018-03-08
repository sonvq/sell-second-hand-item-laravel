<?php

namespace Modules\Notifications\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Notifications\Events\Handlers\RegisterNotificationsSidebar;

class NotificationsServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterNotificationsSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('notifications', 'permissions');
        $this->publishConfig('notifications', 'config');

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
            'Modules\Notifications\Repositories\NotificationsRepository',
            function () {
                $repository = new \Modules\Notifications\Repositories\Eloquent\EloquentNotificationsRepository(new \Modules\Notifications\Entities\Notifications());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Notifications\Repositories\Cache\CacheNotificationsDecorator($repository);
            }
        );
// add bindings

    }
}
