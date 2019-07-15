<?php
namespace Tests\Checks;

use Health\Checks\EnvironmentCheck;

class EnvironmentTest extends CheckTestCase
{

    public function testCheckUp()
    {
        $params = [
            'APP_ENV'
        ];

        $this->assertCheck($this->runCheck(EnvironmentCheck::class, $params), 'UP');
        $params = [
            'APP_ENV' => 'testing'
        ];

        $this->assertCheck($this->runCheck(EnvironmentCheck::class, $params), 'UP');
    }

    public function testCheckDown()
    {
        $params = [
            'none' => 'testing'
        ];

        $this->assertCheck($this->runCheck(EnvironmentCheck::class, $params), 'DOWN');

        $params = [
            'none'
        ];

        $this->assertCheck($this->runCheck(EnvironmentCheck::class, $params), 'DOWN');
    }
}