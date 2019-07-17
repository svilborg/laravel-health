<?php
namespace Tests\Checks;

use Health\Checks\File\Xml;

class FileXmlTest extends CheckTestCase
{

    public function testCheckFile()
    {
        $this->assertCheck($this->runCheck(Xml::class, []), 'UP');

        $this->assertCheck($this->runCheck(Xml::class, [
            'files' => [
                './tests/files/valid.xml'
            ]
        ]), 'UP');

        $this->assertCheck($this->runCheck(Xml::class, [
            'files' => [
                './tests/files/invalid.json.txt'
            ]
        ]), 'DOWN');

        $this->assertCheck($this->runCheck(Xml::class, [
            'files' => [
                './tests/files/notfound.xml'
            ]
        ]), 'DOWN');
    }
}