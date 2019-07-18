<?php
namespace Health\Checks;

use Health\HealthCheck;

/**
 * HealthCheckInterface
 */
interface HealthCheckInterface
{

    /**
     *
     * @return HealthCheck
     */
    public function call();
}