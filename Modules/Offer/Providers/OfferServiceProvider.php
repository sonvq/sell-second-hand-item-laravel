<?php

namespace Modules\Offer\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Offer\Events\Handlers\RegisterOfferSidebar;

class OfferServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterOfferSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('offer', 'permissions');
        $this->publishConfig('offer', 'config');
        $this->publishConfig('offer', 'validations');

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
            'Modules\Offer\Repositories\OfferRepository',
            function () {
                $repository = new \Modules\Offer\Repositories\Eloquent\EloquentOfferRepository(new \Modules\Offer\Entities\Offer());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Offer\Repositories\Cache\CacheOfferDecorator($repository);
            }
        );
// add bindings

        $this->app->bind(
            'Modules\Offer\Transformers\OfferTransformerInterface', 
            "Modules\\Offer\\Transformers\\OfferTransformer"
        );
    }
}
