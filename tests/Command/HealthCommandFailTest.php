<?php
namespace Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Health\ServiceProviders\HealthServiceProvider;

class HealthCommandFailTest extends \Orchestra\Testbench\TestCase
{

    /**
     * Package Providers
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getPackageProviders($app)
    {
        return [
            HealthServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']['health'] = [
            'checks' => [
                [
                    'class' => \Health\Checks\NullCheck::class
                ],
                [
                    'class' => \Health\Checks\Env\Environment::class,
                    'params' => [
                        'APP_ENV' => 'nosuch'
                    ]
                ]
            ]
        ];
    }

    public function testCommand()
    {
        $this->mockConsoleOutput = false;

        $code = $this->artisan('health', []);

        $resultAsText = Artisan::output();
        // echo $resultAsText;

        $this->assertEquals(1, $code);

        $this->assertContains('DOWN Health', $resultAsText);
        $this->assertContains('✔ UP health-checks-null-check', $resultAsText);
        $this->assertContains('✖ DOWN health-checks-env-environment', $resultAsText);
    }
}