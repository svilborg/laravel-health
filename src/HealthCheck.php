<?php
namespace Health;

class HealthCheck
{

    const STATE_UP = 'UP';

    const STATE_DOWN = 'DOWN';

    private $name = '';

    private $state = '';

    private $data = [];

    public function __construct($name, $state, $data)
    {
        $this->name = $name;
        $this->state = $state;
        $this->data = $data;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getData()
    {
        return $this->data;
    }
}