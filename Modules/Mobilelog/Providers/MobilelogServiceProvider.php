<?php

namespace Modules\Mobilelog\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Mobilelog\Events\Handlers\RegisterMobilelogSidebar;

class MobilelogServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterMobilelogSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('mobilelog', 'permissions');
        $this->publishConfig('mobilelog', 'config');
        $this->publishConfig('mobilelog', 'validations');
        

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
            'Modules\Mobilelog\Repositories\MobilelogRepository',
            function () {
                $repository = new \Modules\Mobilelog\Repositories\Eloquent\EloquentMobilelogRepository(new \Modules\Mobilelog\Entities\Mobilelog());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Mobilelog\Repositories\Cache\CacheMobilelogDecorator($repository);
            }
        );
// add bindings

        $this->app->bind(
            'Modules\Mobilelog\Transformers\MobilelogTransformerInterface', 
            "Modules\\Mobilelog\\Transformers\\MobilelogTransformer"
        );
    }
}
