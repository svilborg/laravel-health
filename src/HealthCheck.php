<?php
namespace Health;

class HealthCheck
{

    const STATE_UP = 'UP';

    const STATE_DOWN = 'DOWN';

    /**
     * Name
     *
     * @var string
     */
    private $name = '';

    /**
     * State
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
     *
     * @param string $name
     * @param string $state
     * @param array $data
     */
    public function __construct($name, $state, $data)
    {
        $this->name = $name;
        $this->state = $state;
        $this->data = $data;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
