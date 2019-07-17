<?php
namespace Tests\Checks;

use Health\Checks\Php\ClassExists;

class PhpClassExistsTest extends CheckTestCase
{

    public function testCheckPhpClassExists()
    {
        $this->assertCheck($this->runCheck(ClassExists::class, []), 'UP');

        $this->assertCheck($this->runCheck(ClassExists::class, [
            'classes' => [
                'nosuch'
            ]
        ]), 'DOWN');

        $this->assertCheck($this->runCheck(ClassExists::class, [
            'classes' => [
                "\Health\Checks\Php\ClassExists"
            ]
        ]), 'UP');
    }
}