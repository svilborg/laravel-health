<?php
namespace Health\Builder;

use Health\HealthCheck;

class HealthCheckResponseBuilder implements HealthCheckResponseBuilderInterface
{

    private $name = '';

    private $state = '';

    private $data = [];

    public function name(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function up()
    {
        $this->state = HealthCheck::STATE_UP;

        return $this;
    }

    public function down()
    {
        $this->state = HealthCheck::STATE_DOWN;

        return $this;
    }

    public function state(bool $up)
    {
        $this->state = $up ? HealthCheck::STATE_UP : HealthCheck::STATE_DOWN;

        return $this;
    }

    public function withData(string $key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function build()
    {
        return new HealthCheck($this->name, $this->state, $this->data);
    }
}