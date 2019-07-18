<?php
namespace Health\Checks\Servers;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;
use Illuminate\Support\Facades\Redis as RedisFacade;

class Redis extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $name = $this->getParam('name', null);

        try {
            RedisFacade::connection($name);
        } catch (\Exception $e) {
            $builder->down()->withData("error", "Could not open connection to server - " . $e->getMessage());
        }

        return $builder->build();
    }
}