<?php
namespace Tests\Checks;

use Health\Checks\File\Json;

class FileJsonTest extends CheckTestCase
{

    public function testCheckFile()
    {
        $this->assertCheck($this->runCheck(Json::class, []), 'UP');

        $this->assertCheck($this->runCheck(Json::class, [
            'files' => [
                './tests/files/valid.json'
            ]
        ]), 'UP');

        $this->assertCheck($this->runCheck(Json::class, [
            'files' => [
                './tests/files/invalid.json.txt'
            ]
        ]), 'DOWN');

        $this->assertCheck($this->runCheck(Json::class, [
            'files' => [
                './tests/files/notfound.json'
            ]
        ]), 'DOWN');
    }
}