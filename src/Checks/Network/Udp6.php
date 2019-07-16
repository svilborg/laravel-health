<?php
namespace Health\Checks\Network;

use Health\Checks\HealthCheckInterface;

class Udp6 extends Socket implements HealthCheckInterface
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

        $this->create(AF_INET6, SOCK_DGRAM, SOL_UDP);

        if (! $this->connect($address)) {
            $builder->down()->withData('error', $this->getError());
        }

        $this->close();

        return $builder->build();
    }
}