<?php
namespace Health\Checks\Network;

use Health\Checks\HealthCheckInterface;

class Tcp extends Socket implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $address = $this->params['address'] ?? '';
        $timeout = $this->params['timeout'] ?? '';

        $this->create(AF_INET, SOCK_STREAM, SOL_TCP);

        if (! $this->connect($address, $timeout)) {
            $builder->down()->withData('error', $this->getError());
        }

        $this->close();

        return $builder->build();
    }
}