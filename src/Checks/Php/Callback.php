<?php
namespace Health\Checks\Php;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;

class Callback extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $callback = $this->getParam('callback', null);
        $params = $this->getParam('params', []);

        if (! is_callable($callback)) {
            $builder->down()->withData('error', 'Callback Error. Callback not callable');
        } else {
            try {
                if (! call_user_func_array($callback, $params)) {
                    $builder->down();
                }
            } catch (\Exception $e) {
                $builder->down()->withData('error', $e->getMessage());
            }
        }

        return $builder->build();
    }
}
