<?php
namespace Tests\Checks;

use Health\Checks\Env\Config;

class ConfigTest extends CheckTestCase
{

    public function testCheckUp()
    {
        $params = [
            'database'
        ];

        $this->assertCheck($this->runCheck(Config::class, $params), 'UP');
    }

    public function testCheckDown()
    {
        $params = [
            'database' => 'wrong_value'
        ];

        $this->assertCheck($this->runCheck(Config::class, $params), 'DOWN');

        $params = [
            'none' => 'testing'
        ];

        $this->assertCheck($this->runCheck(Config::class, $params), 'DOWN');

        $params = [
            'none'
        ];

        $this->assertCheck($this->runCheck(Config::class, $params), 'DOWN');
    }
}