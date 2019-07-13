<?php
namespace Tests\Checks;

use Health\Builder\HealthCheckResponseBuilder;
use Health\Checks\HealthCheckInterface;

class FailCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = new HealthCheckResponseBuilder();

        return $builder->name("Test Fail")
            ->withData('error', 'fali')
            ->state(false)
            ->build();
    }
}