<?php
namespace Health\Checks;

use Health\Builder\HealthCheckResponseBuilder;

class NullCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = new HealthCheckResponseBuilder();

        return $builder->name(self::class)->up()->build();
    }
}