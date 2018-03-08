<?php

namespace Modules\Promote\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Promote\Events\Handlers\RegisterPromoteSidebar;

class PromoteServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterPromoteSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('promote', 'permissions');

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
            'Modules\Promote\Repositories\PromoteRepository',
            function () {
                $repository = new \Modules\Promote\Repositories\Eloquent\EloquentPromoteRepository(new \Modules\Promote\Entities\Promote());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Promote\Repositories\Cache\CachePromoteDecorator($repository);
            }
        );
// add bindings

    }
}
