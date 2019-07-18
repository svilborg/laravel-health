<?php
namespace Tests\Checks;

use Health\Checks\Cli\Artisan;

class CliArtisanTest extends CheckTestCase
{

    public function testCheckFile()
    {
        $this->assertCheck($this->runCheck(Artisan::class, []), 'UP');

        $this->assertCheck($this->runCheck(Artisan::class, [
            'commands' => [
                'help' => [
                    'params' => []
                ]
            ]
        ]), 'UP');

        $this->assertCheck($this->runCheck(Artisan::class, [
            'commands' => [
                'nosuch' => []
            ]
        ]), 'DOWN');
    }
}