<?php
namespace Health\Checks\Php;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;

class Version extends BaseCheck implements HealthCheckInterface
{

    const DEFAULT_OPERATOR = '=';

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $version = $this->getParam('version');
        $operator = $this->getParam('operator', self::DEFAULT_OPERATOR);

        if (! version_compare(PHP_VERSION, $version, $operator)) {
            $builder->down();
        }

        $builder->withData('version', PHP_VERSION);

        return $builder->build();
    }
}