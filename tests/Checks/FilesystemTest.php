<?php
namespace Tests\Checks;

use Health\Checks\Filesystem\DirectoryIsReadable;
use Health\Checks\Filesystem\DirectoryIsWritable;
use Health\Checks\Filesystem\FileIsReadable;
use Health\Checks\Filesystem\FileIsWritable;

class FilesystemTest extends CheckTestCase
{

    public function testCheckDirectoryIsReadable()
    {
        $params = [
            'paths' => [
                './tests'
            ]
        ];

        $this->assertCheck($this->runCheck(DirectoryIsReadable::class, $params), 'UP');
    }

    public function testCheckDirectoryIsWritable()
    {
        $params = [
            'paths' => [
                './tests'
            ]
        ];

        $this->assertCheck($this->runCheck(DirectoryIsWritable::class, $params), 'UP');

        $params = [
            'paths' => [
                '../none'
            ]
        ];

        $this->assertCheck($this->runCheck(DirectoryIsWritable::class, $params), 'DOWN');
    }


    public function testCheckFileIsReadable()
    {
        $params = [
            'files' => [
                './tests/TestCase.php'
            ]
        ];

        $this->assertCheck($this->runCheck(FileIsReadable::class, $params), 'UP');
    }

    public function testCheckFileIsWritable()
    {
        $params = [
            'files' => [
                './tests/TestCase.php'
            ]
        ];

        $this->assertCheck($this->runCheck(FileIsWritable::class, $params), 'UP');
    }

}