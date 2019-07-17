<?php
namespace Health\Checks\Php;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;

class ClassExists extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $classes = $this->getParam('classes', []);
        $autoload = $this->getParam('autoload', false);
        $errors = [];

        foreach ($classes as $class) {
            if (!class_exists($class, $autoload)) {
                $errors[] = $class;
            }
        }

        if ($errors) {
            $builder->down()->withData('errors', $errors);
        }

        return $builder->build();
    }
}