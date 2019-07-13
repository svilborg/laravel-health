<?php
namespace Tests;

class HealthControllerTest extends TestCase
{

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