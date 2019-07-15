<?php
namespace Tests\Checks;

use Health\Checks\DiskSpace;

class DiskSpaceTest extends CheckTestCase
{

    public function testCheckUp()
    {
        $params = [
            'path' => '/',
            'threshold' => 100
        ];

        $this->assertCheck($this->runCheck(DiskSpace::class, $params), 'UP');
    }
}