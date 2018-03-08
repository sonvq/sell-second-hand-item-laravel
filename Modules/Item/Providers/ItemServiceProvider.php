<?php

namespace Modules\Item\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Item\Events\Handlers\RegisterItemSidebar;

class ItemServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterItemSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('item', 'permissions');
        $this->publishConfig('item', 'config');
        $this->publishConfig('item', 'validations');
        $this->publishConfig('item', 'settings');

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
            'Modules\Item\Repositories\ItemRepository',
            function () {
                $repository = new \Modules\Item\Repositories\Eloquent\EloquentItemRepository(new \Modules\Item\Entities\Item());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Item\Repositories\Cache\CacheItemDecorator($repository);
            }
        );
// add bindings

        $this->app->bind(
            'Modules\Item\Transformers\ItemTransformerInterface', 
            "Modules\\Item\\Transformers\\ItemTransformer"
        );
        
        $this->app->bind(
            'Modules\Item\Transformers\ItemSearchTransformerInterface', 
            "Modules\\Item\\Transformers\\ItemSearchTransformer"
        );
    }
}
