<?php
namespace Health\Builder;

use Health\HealthCheck;

/**
 * Builder Interface
 */
interface HealthCheckResponseBuilderInterface
{

    /**
     *
     * @param  string $name
     * @return HealthCheckResponseBuilderInterface
     */
    public function name(string $name);

    /**
     *
     * @param  string $key
     * @param  mixed  $value
     * @return HealthCheckResponseBuilderInterface
     */
    public function withData(string $key, $value);

    /**
     *
     * @return HealthCheckResponseBuilderInterface
     */
    public function up();

    /**
     *
     * @return HealthCheckResponseBuilderInterface
     */
    public function down();

    /**
     *
     * @param  boolean $up
     * @return HealthCheckResponseBuilderInterface
     */
    public function state(bool $up);

    /**
     *
     * @return HealthCheck
     */
    public function build();
}
