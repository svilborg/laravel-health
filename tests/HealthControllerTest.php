<?php
namespace Tests;

class HealthControllerTest extends TestCase
{

    public function testApiHealth()
    {
        $response = $this->call('GET', 'api/health', [], [], [], []);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'status' => 'UP'
            ]
        ]);
    }
}