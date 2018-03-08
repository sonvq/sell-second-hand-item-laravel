<?php

namespace Modules\Receipt\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Receipt\Events\Handlers\RegisterReceiptSidebar;

class ReceiptServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterReceiptSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('receipt', 'permissions');
        $this->publishConfig('receipt', 'config');

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
            'Modules\Receipt\Repositories\ReceiptRepository',
            function () {
                $repository = new \Modules\Receipt\Repositories\Eloquent\EloquentReceiptRepository(new \Modules\Receipt\Entities\Receipt());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Receipt\Repositories\Cache\CacheReceiptDecorator($repository);
            }
        );
// add bindings

    }
}
