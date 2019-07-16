<?php
namespace Tests\Checks;

use Health\Checks\Network\Unix;

class UnixTest extends CheckTestCase
{

    public function testCheckDownNoAddress()
    {
        $check = $this->runCheck(Unix::class, []);

        $this->assertCheck($check, 'DOWN');
    }

    public function testCheckDown()
    {
        $params = [
            'address' => "/var/run/test.sock"
        ];

        $check = $this->runCheck(Unix::class, $params);

        $this->assertCheck($check, 'DOWN');
    }
}