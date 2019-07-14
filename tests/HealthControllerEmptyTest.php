<?php
namespace Tests;

class HealthControllerEmptyTest extends TestCase
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

        $app['config']['health'] = [];
    }

    public function testApiHealth()
    {
        $response = $this->call('GET', 'api/health');

        $response->assertStatus(200);
        $response->assertExactJson([
            'status' => 'UP',
            'checks' => []
        ]);
    }
}