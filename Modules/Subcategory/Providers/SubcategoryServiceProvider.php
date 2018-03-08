<?php

namespace Modules\Subcategory\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Subcategory\Events\Handlers\RegisterSubcategorySidebar;

class SubcategoryServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterSubcategorySidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('subcategory', 'permissions');
        $this->publishConfig('subcategory', 'config');

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
            'Modules\Subcategory\Repositories\SubcategoryRepository',
            function () {
                $repository = new \Modules\Subcategory\Repositories\Eloquent\EloquentSubcategoryRepository(new \Modules\Subcategory\Entities\Subcategory());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Subcategory\Repositories\Cache\CacheSubcategoryDecorator($repository);
            }
        );
// add bindings

    }
}
