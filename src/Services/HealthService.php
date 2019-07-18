<?php
namespace Health\Services;

use Health\Health;
use Health\HealthCheck;
use Health\Checks\ErrorCheck;

class HealthService
{

    /**
     *
     * @param array $checks
     * @return Health
     */
    public function getHealth(array $checks)
    {
        $health = new Health();
        $health->setState(HealthCheck::STATE_UP);

        foreach ($checks as $check) {
            $class = $check['class'] ?? null;
            $params = $check['params'] ?? [];

            if (! $class || ! class_exists($class)) {

                /** @var Health\Checks\HealthCheckInterface $healthCheck */
                $healthCheck = new ErrorCheck([
                    'message' => 'Health Check configuration error. Missing check class. - ' . $class
                ]);
                $checkResponse = $healthCheck->call();
            } else {

                /** @var Health\Checks\HealthCheckInterface $healthCheck */
                $healthCheck = new $class($params);
                $checkResponse = $healthCheck->call();
            }

            if ($checkResponse->getState() !== HealthCheck::STATE_UP) {
                $health->setState(HealthCheck::STATE_DOWN);
            }

            $health->setCheck($checkResponse);
        }

        return $health;
    }
}
