<?php
namespace Health\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class HealthServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__ . '/../../config/health.php');

        if ($this->app->environment('testing')) {
            if (is_file(__DIR__ . '/../../tests/health.php')) {
                $source = realpath(__DIR__ . '/../../tests/health.php');
            }
        }

        $this->publishes([
            $source => config_path('health.php')
        ]);

        $this->mergeConfigFrom($source, 'health');
    }
}