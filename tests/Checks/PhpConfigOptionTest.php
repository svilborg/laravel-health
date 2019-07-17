<?php
namespace Tests\Checks;

use Health\Checks\Php\ConfigOptions;

class PhpConfigOptionTest extends CheckTestCase
{

    public function testCheckPhpConfigOptions()
    {
        $this->assertCheck($this->runCheck(ConfigOptions::class, []), 'UP');

        $this->assertCheck($this->runCheck(ConfigOptions::class, [
            'options' => [
                'nosuch' => 'WRONG'
            ]
        ]), 'DOWN');


        $this->assertCheck($this->runCheck(ConfigOptions::class, [
            'options' => [
                'date.timezone' => 'WRONG'
            ]
        ]), 'DOWN');


        $this->assertCheck($this->runCheck(ConfigOptions::class, [
            'options' => [
                'date.timezone' => ini_get('date.timezone')
            ]
        ]), 'UP');


    }
}