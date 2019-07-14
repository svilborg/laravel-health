<?php
namespace Health\Checks;

class NullCheck extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        return $this->getBuilder(self::class)
            ->up()
            ->build();
    }
}