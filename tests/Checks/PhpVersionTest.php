<?php
namespace Tests\Checks;

use Health\Checks\Php\Version;

class PhpVersionTest extends CheckTestCase
{

    public function testCheckVersion()
    {
        $this->assertCheck($this->runCheck(Version::class, [
            'version' => '7.0',
            'operator' => '>='
        ]), 'UP');

        $this->assertCheck($this->runCheck(Version::class, [
            'version' => '5.0',
            'operator' => '<='
        ]), 'DOWN');

        $this->assertCheck($this->runCheck(Version::class, [
            'version' => '5.0'
        ]), 'DOWN');
    }
}