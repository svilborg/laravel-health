<?php
namespace Health\Checks;

use Health\HealthCheck;

interface HealthCheckInterface
{

    /**
     * @return HealthCheck
     */
    public function call();
}