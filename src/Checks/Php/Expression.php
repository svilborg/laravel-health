<?php
namespace Health\Checks\Php;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;

class Expression extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $expression = $this->getParam('expression', '1==1');
        $result = $this->getParam('result', true);

        $expResult = $this->evalExpression($expression);

        if ((is_bool($result) && $result !== (bool) $expResult) || ! preg_match("|{$result}|", $expResult)) {
            $builder->down();
        }

        return $builder->withData('expected_result', $result)
            ->withData('expression_result', $expResult)
            ->build();
    }

    /**
     *
     * @param string $expression
     * @return mixed
     */
    private function evalExpression(string $expression)
    {
        return eval("return {$expression};");
    }
}