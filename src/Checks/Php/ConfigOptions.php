<?php
namespace Health\Checks\Php;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;

class ConfigOptions extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $options = $this->getParam('options', []);
        $errors = [];

        foreach ($options as $option => $value) {
            if (ini_get($option) != $value) {
                $errors[] = $option;
            }
        }

        if ($errors) {
            $builder->down()->withData('errors', $errors);
        }

        return $builder->build();
    }
}