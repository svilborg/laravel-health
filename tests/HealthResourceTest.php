<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Health\Checks\NullCheck;
use Health\Services\HealthService;
use Health\Resources\Health;
use Health\Resources\HealthCheckCollection;

class HealthResourceTest extends TestCase
{

    public function testResource()
    {
        $healthService = new HealthService();

        $health = $healthService->getHealth([
            [
                'class' => NullCheck::class
            ]
        ]);

        $healthResource = new Health($health);

        $result = $healthResource->toArray(null);

        $this->assertEquals("UP", $result["status"]);
        $this->assertInstanceOf(HealthCheckCollection::class, $result["checks"]);
    }
}