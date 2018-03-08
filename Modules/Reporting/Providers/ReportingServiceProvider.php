<?php

namespace Modules\Reporting\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Reporting\Events\Handlers\RegisterReportingSidebar;

class ReportingServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterReportingSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('reporting', 'permissions');
        $this->publishConfig('reporting', 'config');
        $this->publishConfig('reporting', 'validations');

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
            'Modules\Reporting\Repositories\ReportingRepository',
            function () {
                $repository = new \Modules\Reporting\Repositories\Eloquent\EloquentReportingRepository(new \Modules\Reporting\Entities\Reporting());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Reporting\Repositories\Cache\CacheReportingDecorator($repository);
            }
        );
// add bindings
    $this->app->bind(
            'Modules\Reporting\Repositories\ReportingReasonRepository',
            function () {
                return $repository = new \Modules\Reporting\Repositories\Eloquent\EloquentReportingReasonRepository(new \Modules\Reporting\Entities\ReportingReason());
            }
        );
        
        $this->app->bind(
            'Modules\Reporting\Transformers\ReportingTransformerInterface', 
            "Modules\\Reporting\\Transformers\\ReportingTransformer"
        );
    }
}
