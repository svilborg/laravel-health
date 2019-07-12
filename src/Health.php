<?php
namespace Health;

class Health
{

    /**
     * State
     *
     * @var string
     */
    private $state = '';

    /**
     * Helath Checks
     *
     * @var array
     */
    private $checks = [];

    /**
     * Health constructor.
     *
     * @param string $state
     * @param array $checks
     */
    public function __construct($state = HealthCheck::STATE_UP, $checks = [])
    {
        $this->state = $state;
        $this->checks = $checks;
    }

    /**
     *
     * @return boolean
     */
    public function isOk()
    {
        return $this->state === HealthCheck::STATE_UP ? true : false;
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
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     *
     * @return array
     */
    public function getChecks()
    {
        return $this->checks;
    }

    /**
     *
     * @param mixed $check
     */
    public function setCheck($check)
    {
        $this->checks[] = $check;
    }
}