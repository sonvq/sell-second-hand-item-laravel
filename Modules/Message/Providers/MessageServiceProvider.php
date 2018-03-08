<?php

namespace Modules\Message\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Message\Events\Handlers\RegisterMessageSidebar;

class MessageServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterMessageSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('message', 'permissions');
        $this->publishConfig('message', 'config');
        $this->publishConfig('message', 'validations');

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
            'Modules\Message\Repositories\MessageRepository',
            function () {
                $repository = new \Modules\Message\Repositories\Eloquent\EloquentMessageRepository(new \Modules\Message\Entities\Message());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Message\Repositories\Cache\CacheMessageDecorator($repository);
            }
        );
// add bindings

        $this->app->bind(
            'Modules\Message\Transformers\MessageTransformerInterface', 
            "Modules\\Message\\Transformers\\MessageTransformer"
        );
    }
}
