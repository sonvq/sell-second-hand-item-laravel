<?php

namespace Modules\Pages\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Pages\Events\Handlers\RegisterPagesSidebar;

class PagesServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterPagesSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('pages', 'permissions');
        $this->publishConfig('pages', 'config');

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
            'Modules\Pages\Repositories\PagesRepository',
            function () {
                $repository = new \Modules\Pages\Repositories\Eloquent\EloquentPagesRepository(new \Modules\Pages\Entities\Pages());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pages\Repositories\Cache\CachePagesDecorator($repository);
            }
        );
// add bindings

        $this->app->bind(
            'Modules\Pages\Transformers\PagesTransformerInterface', 
            "Modules\\Pages\\Transformers\\PagesTransformer"
        );
    }
}
