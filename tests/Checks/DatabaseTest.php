<?php
namespace Tests\Checks;

use Health\Checks\DatabaseCheck;

class DatabaseTest extends CheckTestCase
{

    public function testCheckDown()
    {
        $this->assertCheck($this->runCheck(DatabaseCheck::class, []), 'DOWN');
    }
}