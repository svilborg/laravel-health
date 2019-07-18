<?php
namespace Tests;

class HealthControllerErrorTest extends TestCase
{

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']['health'] = [
            'checks' => [
                [
                    'class' => '\Health\Checks\NoSuch',
                    'params' => []
                ]
            ]
        ];
    }

    public function testApiHealth()
    {
        $response = $this->call('GET', 'api/health');

        $response->assertStatus(503);
        $response->assertJson([
            'status' => 'DOWN'
        ]);
    }
}