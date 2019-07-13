<?php
namespace Tests\Checks;

use Health\Builder\HealthCheckResponseBuilder;
use Health\Checks\HealthCheckInterface;

class SuccessfulCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = new HealthCheckResponseBuilder();

        return $builder->name("Test")
            ->withData('foo', 'bar')
            ->state(true)
            ->build();
    }
}