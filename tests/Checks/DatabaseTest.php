<?php
namespace Tests\Checks;

use Health\Checks\Database;

class DatabaseTest extends CheckTestCase
{

    public function testCheckDown()
    {
        $this->assertCheck($this->runCheck(Database::class, []), 'DOWN');
    }
}