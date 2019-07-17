<?php
namespace Tests\Checks;

use Health\Checks\Php\Expression;

class PhpExpressionTest extends CheckTestCase
{

    public function testCheckPhpClassExists()
    {
        $this->assertCheck($this->runCheck(Expression::class, []), 'UP');

        $this->assertCheck($this->runCheck(Expression::class, [
            'expression' => '1+2'
        ]), 'DOWN');

        $this->assertCheck($this->runCheck(Expression::class, [
            'expression' => '1+2',
            'result' => '3'
        ]), 'UP');

        $this->assertCheck($this->runCheck(Expression::class, [
            'expression' => 'max([1,10,45])',
            'result' => '45'
        ]), 'UP');

        $this->assertCheck($this->runCheck(Expression::class, [
            'expression' => "\Health\Checks\Php\Expression::class",
            'result' => 'Health\\\Checks\\\Php\\\Expression'
        ]), 'UP');
    }
}