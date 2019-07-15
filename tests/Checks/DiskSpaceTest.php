<?php
namespace Tests\Checks;

use Health\Checks\DiskSpaceCheck;

class DiskSpaceTest extends CheckTestCase
{

    public function testCheckUp()
    {
        $params = [
            'path' => '/',
            'threshold' => 100
        ];

        $this->assertCheck($this->runCheck(DiskSpaceCheck::class, $params), 'UP');
    }
}