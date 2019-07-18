<?php
namespace Tests\Checks;

use Health\Checks\Php\Callback;

class PhpCallbackTest extends CheckTestCase
{

    public function testCheckPhpClassExists()
    {
        $this->assertCheck($this->runCheck(Callback::class), 'DOWN');

        $this->assertCheck($this->runCheck(Callback::class, []), 'DOWN');

        $this->assertCheck($this->runCheck(Callback::class, [
            'callback' => 'nosuch'
        ]), 'DOWN');

        $this->assertCheck($this->runCheck(Callback::class, [
            'callback' => 'strtoupper'
        ]), 'DOWN');

        $this->assertCheck($this->runCheck(Callback::class, [
            'callback' => 'phpversion'
        ]), 'UP');

        $this->assertCheck($this->runCheck(Callback::class, [
            'callback' => 'strtoupper',
            'params' => [
                'test'
            ]
        ]), 'UP');
    }
}