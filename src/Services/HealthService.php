<?php
namespace Health\Services;

use Health\Health;
use Health\HealthCheck;

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

            if (! $class) {
                throw new \Exception('Health Check configuration error. Missing check class.');
            }

            /** @var Health\Checks\HealthCheckInterface $healthCheck */
            $healthCheck = new $class($params);
            $checkResponse = $healthCheck->call();

            if ($checkResponse->getState() !== HealthCheck::STATE_UP) {
                $health->setState(HealthCheck::STATE_DOWN);
            }

            $health->setCheck($checkResponse);
        }

        return $health;
    }
}