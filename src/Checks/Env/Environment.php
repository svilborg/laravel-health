<?php
namespace Health\Checks\Env;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;

class Environment extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        foreach ($this->params as $paramKey => $paramValue) {
            $variable = is_numeric($paramKey) ? $paramValue : $paramKey;
            $expectedValue = is_numeric($paramKey) ? null : $paramValue;
            $checkValue = is_numeric($paramKey) ? false : true;

            $value = env($variable, null);

            if ($value === null) {
                $builder->down();
            } else {
                if ($checkValue && $value !== $expectedValue) {
                    $builder->down();
                } else {
                    $builder->up();
                }
            }

            $builder->withData('variable', $variable)
                ->withData('value', $value)
                ->withData('value_expected', $expectedValue);
        }

        return $builder->build();
    }
}
