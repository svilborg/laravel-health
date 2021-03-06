<?php
namespace Health\Checks;

/**
 * Null Check
 */
class NullCheck extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        return $this->getBuilder()
            ->up()
            ->build();
    }
}
