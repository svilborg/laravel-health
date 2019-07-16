<?php
namespace Tests\Checks;

use Health\Checks\Network\Udp;

class UdpTest extends CheckTestCase
{

    public function testCheckDownNoAddress()
    {
        $check = $this->runCheck(Udp::class, []);

        $this->assertCheck($check, 'DOWN');
    }

    public function testCheckDown()
    {
        $params = [
            'address' => "unknownhostherepls.com"
        ];

        $check = $this->runCheck(Udp::class, $params);

        $this->assertCheck($check, 'DOWN');
    }
}