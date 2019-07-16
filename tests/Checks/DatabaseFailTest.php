<?php
namespace Tests\Checks;

use Health\Checks\Servers\Database;

class DatabaseFailTest extends CheckTestCase
{

    public function testCheckDown()
    {
        $this->assertCheck($this->runCheck(Database::class), 'DOWN');
    }
}