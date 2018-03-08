<?php

namespace Modules\Appuser\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Appuser\Events\Handlers\RegisterAppuserSidebar;

class AppuserServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterAppuserSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('appuser', 'permissions');
        $this->publishConfig('appuser', 'validations');
        $this->publishConfig('appuser', 'config');

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
            'Modules\Appuser\Repositories\AppuserRepository',
            function () {
                $repository = new \Modules\Appuser\Repositories\Eloquent\EloquentAppuserRepository(new \Modules\Appuser\Entities\Appuser());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Appuser\Repositories\Cache\CacheAppuserDecorator($repository);
            }
        );
// add bindings
        $this->app->bind(
            'Modules\Appuser\Repositories\AppuserLoginRepository',
            function () {
                return new \Modules\Appuser\Repositories\Eloquent\EloquentAppuserLoginRepository(new \Modules\Appuser\Entities\AppuserLogin());
            }
        );
        
        $this->app->bind(
            'Modules\Appuser\Transformers\AppuserTransformerInterface', 
            "Modules\\Appuser\\Transformers\\AppuserTransformer"
        );
        
       $this->app->bind(
            'Modules\Appuser\Repositories\AppuserForgotRepository',
            function () {
                return new \Modules\Appuser\Repositories\Eloquent\EloquentAppuserForgotRepository(new \Modules\Appuser\Entities\AppuserForgot());
            }
        );
        
        $this->app->bind(
            'Modules\Appuser\Repositories\AppuserDeviceRepository',
            function () {
                return new \Modules\Appuser\Repositories\Eloquent\EloquentAppuserDeviceRepository(new \Modules\Appuser\Entities\AppuserDevice());
            }
        );
    }
}
