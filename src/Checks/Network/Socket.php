<?php
namespace Health\Checks\Network;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;

class Socket extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $domain = $this->params['domain'] ?? '';
        $type = $this->params['type'];
        $protocol = isset($this->params['protocol']) ? $this->params['protocol'] : '';

        $up = ($this->create($domain, $type, $protocol)) ? true : false;

        if (! $up) {
            $builder->withData('error', $this->getError());
        }

        $builder->state($up)
            ->withData('domain', $domain)
            ->withData('type', $type)
            ->withData('protocol', $protocol);

        return $builder->build();
    }

    /**
     *
     * @param int $domain
     * @param int $type
     * @param int $protocol
     */
    protected function create($domain, $type, $protocol)
    {
        return @socket_create($domain, $type, $protocol);
    }

    /**
     *
     * @return array
     */
    protected function getError()
    {
        $code = socket_last_error();
        $msg = socket_strerror($code);

        return [
            'code' => $code,
            'message' => $msg
        ];
    }
}