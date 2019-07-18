<?php
namespace Health\Checks\Network;

use Health\Checks\HealthCheckInterface;
use Health\Checks\BaseCheck;
use Health\Checks\Traits\SocketTrait;

class Udp extends BaseCheck implements HealthCheckInterface
{
    use SocketTrait;

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $address = $this->getParam('address', '');

        $this->create(AF_INET, SOCK_DGRAM, SOL_UDP);

        if (! $this->connect($address)) {
            $builder->down()->withData('error', $this->getError());
        }

        $this->close();

        return $builder->build();
    }
}
