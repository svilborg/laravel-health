<?php
namespace Tests\Checks;

use Health\Checks\File\Ini;

class FileIniTest extends CheckTestCase
{

    public function testCheckFile()
    {
        $this->assertCheck($this->runCheck(Ini::class, []), 'UP');

        $this->assertCheck($this->runCheck(Ini::class, [
            'files' => [
                './tests/files/valid.ini'
            ]
        ]), 'UP');

        $this->assertCheck($this->runCheck(Ini::class, [
            'files' => [
                './tests/files/invalid.ini'
            ]
        ]), 'DOWN');

        $this->assertCheck($this->runCheck(Ini::class, [
            'files' => [
                './tests/files/notfound.ini'
            ]
        ]), 'DOWN');
    }
}