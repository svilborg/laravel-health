<?php
namespace Tests\Checks;

use Health\Checks\Network\Tcp6;

class Tcp6Test extends CheckTestCase
{

    public function testCheckDownNoAddress()
    {
        $check = $this->runCheck(Tcp6::class, []);

        $this->assertCheck($check, 'DOWN');
    }

    public function testCheckDown()
    {
        $params = [
            'address' => "unknownhostherepls.com"
        ];

        $check = $this->runCheck(Tcp6::class, $params);

        $this->assertCheck($check, 'DOWN');
    }
}