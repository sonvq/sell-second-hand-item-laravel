<?php

namespace Modules\Country\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Country\Events\Handlers\RegisterCountrySidebar;

class CountryServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterCountrySidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('country', 'permissions');

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
            'Modules\Country\Repositories\CountryRepository',
            function () {
                $repository = new \Modules\Country\Repositories\Eloquent\EloquentCountryRepository(new \Modules\Country\Entities\Country());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Country\Repositories\Cache\CacheCountryDecorator($repository);
            }
        );
// add bindings

    }
}
