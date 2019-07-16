<?php
namespace Tests;

class HealthControllerFailTest extends TestCase
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
                    'class' => \Health\Checks\Servers\Database::class,
                    'params' => []
                ]
            ]
        ];
    }

    public function testApiHealth()
    {
        $response = $this->call('GET', 'api/health');

        // $response->dump();

        $response->assertStatus(503);
        $response->assertJson([
            'status' => 'DOWN'
        ]);
    }
}