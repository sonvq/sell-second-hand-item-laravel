<?php

namespace Modules\Discount\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Discount\Events\Handlers\RegisterDiscountSidebar;

class DiscountServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterDiscountSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('discount', 'permissions');

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
            'Modules\Discount\Repositories\DiscountRepository',
            function () {
                $repository = new \Modules\Discount\Repositories\Eloquent\EloquentDiscountRepository(new \Modules\Discount\Entities\Discount());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Discount\Repositories\Cache\CacheDiscountDecorator($repository);
            }
        );
// add bindings

    }
}
