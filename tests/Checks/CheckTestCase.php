<?php
namespace Tests\Checks;

use Health\HealthCheck;

class CheckTestCase extends \Orchestra\Testbench\TestCase
{

    protected function assertCheck($health, string $state = 'UP')
    {
        // dd($health);
        $this->assertInstanceOf(HealthCheck::class, $health);
        $this->assertNotEmpty($health->getName());
        $this->assertEquals($state, $health->getState());
    }

    protected function runCheck(string $classs, array $params = [])
    {
        $check = new $classs($params);

        return $check->call();
    }
}
