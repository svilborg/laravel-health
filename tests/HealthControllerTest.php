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
                ]
            ]
        ];
    }

    public function testApiHealth()
    {
        $response = $this->call('GET', 'api/health');

        // $response->dump();

        $response->assertOk();
        $response->assertJson([
            'status' => 'UP'
        ]);
    }
}