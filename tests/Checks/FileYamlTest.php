<?php
namespace Tests\Checks;

use Health\Checks\File\Yaml;

class FileYamlTest extends CheckTestCase
{

    public function testCheckFile()
    {
        $this->assertCheck($this->runCheck(Yaml::class, []), 'UP');

        $this->assertCheck($this->runCheck(Yaml::class, [
            'files' => [
                './tests/files/valid.yaml'
            ]
        ]), 'UP');

        $this->assertCheck($this->runCheck(Yaml::class, [
            'files' => [
                './tests/files/invalid.yaml.txt'
            ]
        ]), 'DOWN');

        $this->assertCheck($this->runCheck(Yaml::class, [
            'files' => [
                './tests/files/notfound.yaml'
            ]
        ]), 'DOWN');
    }
}