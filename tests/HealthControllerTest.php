<?php
namespace Tests;

use Health\Checks\NullCheck;
use Health\Checks\SuccessfulCheck;
use Health\Services\HealthService;

class HealthControllerTest extends TestCase
{

    /**
     * Define environment setup.
     *
     * @param Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Add the middleware
        $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

        parent::getEnvironmentSetUp($app);
    }

    public function testApiHealth()
    {
        $crawler = $this->call('GET', 'api/health', [], [], [], []);

        $this->assertNull($crawler->headers->get('Access-Control-Allow-Origin'));
        $this->assertEquals(200, $crawler->getStatusCode());

        // $healthService = new HealthService();

        // $health = $healthService->getHealth([
        // SuccessfulCheck::class,
        // NullCheck::class
        // ]);

        // $this->assertEquals("UP", $health->getState());
        // $this->assertCount(2, $health->getChecks());
    }
}