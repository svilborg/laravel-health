<?php
namespace Health\Checks;

use Health\Builder\HealthCheckResponseBuilder;

/**
 * Base Abstract Check
 */
abstract class BaseCheck
{

    /**
     *
     * @var string
     */
    protected $name = null;

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
     * @return \Health\Builder\HealthCheckResponseBuilder
     */
    protected function getBuilder()
    {
        $name = $this->name ?? $this->slug();

        $builder = new HealthCheckResponseBuilder();
        $builder->name($name)->up();

        return $builder;
    }

    /**
     * Get Check Param
     *
     * @param string $name
     * @param mixed|null $default
     * @return string
     */
    protected function getParam(string $name, $default = null)
    {
        return $this->params[$name] ?? $default;
    }

    /**
     * Create a slug from check's class name
     *
     * @return string
     */
    private function slug()
    {
        $name = get_called_class();
        $name = str_replace('\\', '-', $name);
        $name = $this->camelToSnake($name);

        return $name;
    }

    /**
     * Camel case to snake case
     *
     * @see https://stackoverflow.com/questions/40514051/using-preg-replace-to-convert-camelcase-to-snake-case
     *
     * @param string $string
     * @param string $us
     * @return string
     */
    private function camelToSnake($string, $us = "-")
    {
        return strtolower(preg_replace('/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $us, $string));
    }
}