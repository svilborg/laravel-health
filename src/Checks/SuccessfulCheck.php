<?php
namespace Health\Checks;

use Health\Builder\HealthCheckResponseBuilder;

class SuccessfulCheck implements HealthCheckInterface
{

    public function call()
    {
        $builder = new HealthCheckResponseBuilder();
        $builder->name("Test")
            ->withData('foo', 'bar')
            ->state(true);

        $response = $builder->build();

        return $response;
    }
}