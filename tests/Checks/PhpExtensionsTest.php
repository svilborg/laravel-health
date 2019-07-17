<?php
namespace Tests\Checks;

use Health\Checks\Php\Extensions;

class PhpExtensionsTest extends CheckTestCase
{

    public function testCheckPhpConfigOptions()
    {
        $this->assertCheck($this->runCheck(Extensions::class, []), 'UP');

        $this->assertCheck($this->runCheck(Extensions::class, [
            'extensions' => [
                'nosuch'
            ]
        ]), 'DOWN');

        $this->assertCheck($this->runCheck(Extensions::class, [
            'extensions' => [
                'mbstring'
            ]
        ]), extension_loaded('mbstring') ? 'UP' : 'DOWN');
    }
}