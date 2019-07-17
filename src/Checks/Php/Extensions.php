<?php
namespace Health\Checks\Php;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;

class Extensions extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $extensions = $this->getParam('extensions', []);
        $errors = [];

        foreach ($extensions as $extension) {
            if (! extension_loaded($extension)) {
                $errors[] = $extension;
            }
        }

        if ($errors) {
            $builder->down()->withData('errors', $errors);
        }

        return $builder->build();
    }
}