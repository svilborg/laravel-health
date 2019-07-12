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
            \Health\Checks\NullCheck::class,
            \Health\Checks\FailCheck::class
        ];
    }

    public function testApiHealth()
    {
        $response = $this->call('GET', 'api/health');

        // $response->dump();

        $response->assertOk();
        $response->assertJson([
            'status' => 'DOWN'
        ]);
    }
}