<?php
namespace Tests\Checks;

use Health\Checks\Cli\Exec;

class CliExecTest extends CheckTestCase
{

    public function testCheckFile()
    {
        $this->assertCheck($this->runCheck(Exec::class, []), 'UP');

        $this->assertCheck($this->runCheck(Exec::class, [
            'commands' => [
                'nosuch' => []
            ]
        ]), 'DOWN');

        $this->assertCheck($this->runCheck(Exec::class, [
            'commands' => [
                'ls' => [
                    'params' => [
                        '-alh'
                    ]
                ]
            ]
        ]), 'UP');
    }
}