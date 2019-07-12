<?php
namespace Health\Services;

use Health\Checks\HealthCheckInterface;
use Health\Health;
use Health\HealthCheck;

class HealthService
{

    /**
     * @param array $checks
     * @return Health
     */
    public function getHealth(array $checks)
    {
        $health = new Health();
        $health->setState(HealthCheck::STATE_UP);

        foreach ($checks as $checkClass) {

            /** @var HealthCheckInterface $check */
            $check = new $checkClass();
            $checkResponse = $check->call();

            if ($checkResponse->getState() !== HealthCheck::STATE_UP) {
                $health->setState(HealthCheck::STATE_DOWN);
            }

            $health->setCheck($checkResponse);
        }

        return $health;
    }
}