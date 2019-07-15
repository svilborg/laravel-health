<?php
namespace Tests\Checks;

use Health\Checks\Environment;

class EnvironmentTest extends CheckTestCase
{

    public function testCheckUp()
    {
        $params = [
            'APP_ENV'
        ];

        $this->assertCheck($this->runCheck(Environment::class, $params), 'UP');

        $params = [
            'APP_ENV' => 'testing'
        ];

        $this->assertCheck($this->runCheck(Environment::class, $params), 'UP');
    }

    public function testCheckDown()
    {
        $params = [
            'none' => 'testing'
        ];

        $this->assertCheck($this->runCheck(Environment::class, $params), 'DOWN');

        $params = [
            'none'
        ];

        $this->assertCheck($this->runCheck(Environment::class, $params), 'DOWN');
    }
}