<?php
namespace Tests\Checks;

use Health\Checks\ConfigCheck;

class ConfigTest extends CheckTestCase
{

    public function testCheckUp()
    {
        $params = [
            'database'
        ];

        $this->assertCheck($this->runCheck(ConfigCheck::class, $params), 'UP');
    }

    public function testCheckDown()
    {
        $params = [
            'none' => 'testing'
        ];

        $this->assertCheck($this->runCheck(ConfigCheck::class, $params), 'DOWN');

        $params = [
            'none'
        ];

        $this->assertCheck($this->runCheck(ConfigCheck::class, $params), 'DOWN');
    }
}