<?php
namespace Health\Checks;

class ConfigCheck extends BaseCheck implements HealthCheckInterface
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

            $value = config($variable, null);

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