<?php
namespace Health\Checks\Network;

use Health\Checks\HealthCheckInterface;

class Unix extends Socket implements HealthCheckInterface
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

        $this->create(AF_UNIX, SOCK_STREAM, 0);

        if (! $this->connect($address)) {
            $builder->down()->withData('error', $this->getError());
        }

        $this->close();

        return $builder->build();
    }
}