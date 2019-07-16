<?php
namespace Tests\Checks;

use Health\Checks\Network\Tcp;

class TcpTest extends CheckTestCase
{

    public function testCheckDownNoAddress()
    {
        $check = $this->runCheck(Tcp::class, []);

        $this->assertCheck($check, 'DOWN');
    }

    public function testCheckDown()
    {
        $params = [
            'address' => "unknownhostherepls.com"
        ];

        $check = $this->runCheck(Tcp::class, $params);

        $this->assertCheck($check, 'DOWN');
    }

    public function testCheckHostUp()
    {
        $params = [
            'address' => "www.google.com:80"
        ];

        $check = $this->runCheck(Tcp::class, $params);

        $this->assertCheck($check, 'UP');
    }
}