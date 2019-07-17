<?php
namespace Tests\Checks;

use Health\Checks\Servers\Cache;

class CacheTest extends CheckTestCase
{

    public function testCheckUp()
    {
        $this->assertCheck($this->runCheck(Cache::class, []), 'UP');

        $this->assertCheck($this->runCheck(Cache::class, [
            'key' => 'test',
            'value' => 'test123'
        ]), 'UP');
    }
}