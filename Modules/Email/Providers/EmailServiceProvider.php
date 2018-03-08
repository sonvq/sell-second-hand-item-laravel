<?php

namespace Modules\Email\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Email\Events\Handlers\RegisterEmailSidebar;

class EmailServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterEmailSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('email', 'permissions');

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
            'Modules\Email\Repositories\EmailRepository',
            function () {
                $repository = new \Modules\Email\Repositories\Eloquent\EloquentEmailRepository(new \Modules\Email\Entities\Email());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Email\Repositories\Cache\CacheEmailDecorator($repository);
            }
        );
// add bindings

    }
}
