<?php
namespace Tests;

class HealthControllerTest extends TestCase
{

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
                    'class' => \Health\Checks\DiskSpaceCheck::class,
                    'params' => [
                        'path' => '/tmp'
                    ]
                ],
                [
                    'class' => \Health\Checks\EnvironmentCheck::class,
                    'params' => [
                        'APP_ENV' => 'testing'
                    ]
                ],
                [
                    'class' => \Health\Checks\Filesystem\DirectoryIsReadable::class,
                    'params' => [
                        'paths' => [
                            '../tests'
                        ]
                    ]
                ],
                [
                    'class' => \Health\Checks\Filesystem\FileIsReadable::class,
                    'params' => [
                        'files' => [
                            'TestCase\.php'
                        ]
                    ]
                ]
            ]
        ];
    }

    public function testApiHealth()
    {
        $response = $this->call('GET', 'api/health');

        // var_export($response->getContent());die;
        // $response->dump();

        $response->assertOk();
        $response->assertJson([
            'status' => 'UP'
        ]);
    }
}