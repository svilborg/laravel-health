<?php
namespace Tests\Checks;

use Health\Checks\Filesystem\DiskUsage;

class DiskUsageTest extends CheckTestCase
{

    public function testCheckUp()
    {
        $this->assertCheck($this->runCheck(DiskUsage::class, [
            'path' => '/',
            'threshold' => 1
        ]), 'UP');

        $this->assertCheck($this->runCheck(DiskUsage::class, [
            'path' => '/',
            'threshold' => 100
        ]), 'DOWN');
    }
}