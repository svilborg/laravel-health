<?php
namespace Tests;

use Illuminate\Routing\Router;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use \Illuminate\Foundation\Validation\ValidatesRequests;

    /**
     *
     * @param \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageProviders($app)
    {
        return [
            \Health\ServiceProviders\HealthServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $router = $app['router'];

        $this->addApiRoutes($router);
    }

    /**
     *
     * @param Router $router
     */
    protected function addApiRoutes($router)
    {
        $router->get('api/health', 'Health\Controllers\HealthController@check');
    }
}
