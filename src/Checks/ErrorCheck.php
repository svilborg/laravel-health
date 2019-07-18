<?php
namespace Health\Checks;

/**
 * Error Check
 */
class ErrorCheck extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $message = $this->getParam('message');

        return $this->getBuilder()
            ->down()
            ->withData('message', $message)
            ->build();
    }
}