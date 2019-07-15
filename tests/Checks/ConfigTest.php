<?php
namespace Tests\Checks;

use Health\Checks\Config;

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
            'none' => 'testing'
        ];

        $this->assertCheck($this->runCheck(Config::class, $params), 'DOWN');

        $params = [
            'none'
        ];

        $this->assertCheck($this->runCheck(Config::class, $params), 'DOWN');
    }
}