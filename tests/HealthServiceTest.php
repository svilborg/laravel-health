<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Health\Checks\NullCheck;
use Health\Services\HealthService;

class HealthServiceTest extends TestCase
{

    public function testService()
    {
        $healthService = new HealthService();

        $health = $healthService->getHealth([
            [
                'class' => NullCheck::class
            ]
        ]);

        $this->assertEquals("UP", $health->getState());
        $this->assertCount(1, $health->getChecks());
    }
}