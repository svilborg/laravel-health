<?php
namespace Health\Checks;

use Health\Builder\HealthCheckResponseBuilder;

abstract class BaseCheck implements HealthCheckInterface
{

    /**
     *
     * @var array
     */
    protected $params = [];

    /**
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    /**
     *
     * @param string $name
     * @return \Health\Builder\HealthCheckResponseBuilder
     */
    protected function getBuilder(string $name)
    {
        $builder = new HealthCheckResponseBuilder();
        $builder->name($name)->up();

        return $builder;
    }
}