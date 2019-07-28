<?php
namespace Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Health\ServiceProviders\HealthServiceProvider;

class HealthCommandTest extends \Orchestra\Testbench\TestCase
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
                    'class' => \Health\Checks\Filesystem\DiskSpace::class,
                    'params' => [
                        'path' => '/tmp'
                    ]
                ],
                [
                    'class' => \Health\Checks\Env\Environment::class,
                    'params' => [
                        'APP_ENV' => 'testing'
                    ]
                ],
                [
                    'class' => \Health\Checks\Filesystem\DirectoryIsReadable::class,
                    'params' => [
                        'paths' => [
                            './tests'
                        ]
                    ]
                ],
                [
                    'class' => \Health\Checks\Filesystem\FileIsReadable::class,
                    'params' => [
                        'files' => [
                            './tests/TestCase.php'
                        ]
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

        $this->assertEquals(0, $code);
        $this->assertContains('UP Health', $resultAsText);
    }
}