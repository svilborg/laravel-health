<?php
namespace Health\Checks\Network;

use Health\Checks\HealthCheckInterface;

class Tcp6 extends Socket implements HealthCheckInterface
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

        $this->create(AF_INET6, SOCK_STREAM, SOL_TCP);

        if (! $this->connect($address)) {
            $builder->down()->withData('error', $this->getError());
        }

        $this->close();

        return $builder->build();
    }
}