<?php
namespace Tests\Checks;

use Health\Checks\Network\Udp6;

class Udp6Test extends CheckTestCase
{

    public function testCheckDownNoAddress()
    {
        $check = $this->runCheck(Udp6::class, []);

        $this->assertCheck($check, 'DOWN');
    }

    public function testCheckDown()
    {
        $params = [
            'address' => "unknownhostherepls.com"
        ];

        $check = $this->runCheck(Udp6::class, $params);

        $this->assertCheck($check, 'DOWN');
    }
}