<?php
namespace Tests;

use PHPUnit\Framework\TestCase;

use Health\Checks\NullCheck;
use Health\Checks\SuccessfulCheck;
use Health\Services\HealthService;

class HealthServiceTest extends TestCase
{

    public function testService()
    {
        $healthService = new HealthService();

        $health = $healthService->getHealth([
            SuccessfulCheck::class,
            NullCheck::class
        ]);

        $this->assertEquals("UP", $health->getState());
        $this->assertCount(2, $health->getChecks());
    }
}