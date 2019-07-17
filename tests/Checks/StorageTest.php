<?php
namespace Tests\Checks;

use Health\Checks\Storage;

class StorageTest extends CheckTestCase
{

    public function testCheckUp()
    {
        $this->assertCheck($this->runCheck(Storage::class, []), 'UP');
    }

    public function testCheckDown()
    {
        $params = [
            'name' => 'wrong'
        ];

        $this->assertCheck($this->runCheck(Storage::class, $params), 'DOWN');
    }
}