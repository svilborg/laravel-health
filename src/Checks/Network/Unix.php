<?php
namespace Health\Checks\Network;

use Health\Checks\HealthCheckInterface;
use Health\Checks\BaseCheck;
use Health\Checks\Traits\SocketTrait;

class Unix extends BaseCheck implements HealthCheckInterface
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

        $this->create(AF_UNIX, SOCK_STREAM, 0);

        if (! $this->connect($address)) {
            $builder->down()->withData('error', $this->getError());
        }

        $this->close();

        return $builder->build();
    }
}
