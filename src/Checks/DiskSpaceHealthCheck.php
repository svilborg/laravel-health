<?php
namespace Health\Checks;

use Health\Builder\HealthCheckResponseBuilder;

class DiskSpaceHealthCheck implements HealthCheckInterface
{

    /**
     * Default disk space threshold of 100 MB
     *
     * @var integer
     */
    const DEFAULT_THRESHOLD = 100000000;

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = new HealthCheckResponseBuilder();
        $builder->name(self::class);

        if (disk_free_space("/") >= self::DEFAULT_THRESHOLD) {
            $builder->up();
        } else {
            $builder->down();
        }

        return $builder->build();
    }
}