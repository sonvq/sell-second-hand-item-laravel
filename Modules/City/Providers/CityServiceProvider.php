<?php

namespace Modules\City\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\City\Events\Handlers\RegisterCitySidebar;

class CityServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterCitySidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('city', 'permissions');

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
            'Modules\City\Repositories\CityRepository',
            function () {
                $repository = new \Modules\City\Repositories\Eloquent\EloquentCityRepository(new \Modules\City\Entities\City());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\City\Repositories\Cache\CacheCityDecorator($repository);
            }
        );
// add bindings

    }
}
