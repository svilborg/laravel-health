<?php
namespace Tests;

use Health\Checks\NullCheck;
use Health\Checks\SuccessfulCheck;
use Health\Services\HealthService;

class HealthControllerTest extends TestCase
{

//     /**
//      * Define environment setup.
//      *
//      * @param \Illuminate\Foundation\Application $app
//      *
//      * @return void
//      */
//     protected function getEnvironmentSetUp($app)
//     {
//         // Add the middleware
//         $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

//         parent::getEnvironmentSetUp($app);
//     }

    public function testApiHealth()
    {
        $response = $this->call('GET', 'api/health', [], [], [], []);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'status' => 'UP'
            ]
        ]);

        // $this->assertEquals(200, $response->getStatusCode());
    }
}