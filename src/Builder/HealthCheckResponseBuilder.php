<?php
namespace Health\Builder;

use Health\HealthCheck;

/**
 * Builder
 */
class HealthCheckResponseBuilder implements HealthCheckResponseBuilderInterface
{

    /**
     * Check name
     *
     * @var string
     */
    private $name = '';

    /**
     * Check state
     *
     * @var string
     */
    private $state = '';

    /**
     * Extra data
     *
     * @var array
     */
    private $data = [];

    /**
     * {@inheritdoc}
     *
     * @see \Health\Builder\HealthCheckResponseBuilderInterface::name()
     */
    public function name(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Health\Builder\HealthCheckResponseBuilderInterface::up()
     */
    public function up()
    {
        $this->state = HealthCheck::STATE_UP;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Health\Builder\HealthCheckResponseBuilderInterface::down()
     */
    public function down()
    {
        $this->state = HealthCheck::STATE_DOWN;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Health\Builder\HealthCheckResponseBuilderInterface::state()
     */
    public function state(bool $up)
    {
        $this->state = $up ? HealthCheck::STATE_UP : HealthCheck::STATE_DOWN;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Health\Builder\HealthCheckResponseBuilderInterface::withData()
     */
    public function withData(string $key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Health\Builder\HealthCheckResponseBuilderInterface::build()
     */
    public function build()
    {
        return new HealthCheck($this->name, $this->state, $this->data);
    }
}