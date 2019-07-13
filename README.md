# Laravel Health Check


[![Build Status](https://travis-ci.org/svilborg/laravel-health.svg?branch=master)](https://travis-ci.org/svilborg/laravel-health)
[![Latest Stable Version](https://img.shields.io/packagist/v/svilborg/laravel-health.svg)](https://packagist.org/packages/svilborg/laravel-health)
[![License](https://img.shields.io/packagist/l/svilborg/laravel-health.svg)](https://github.com/svilborg/laravel-health/blob/master/LICENSE)

Implementation of MicroProfile Health for Laravel

[MicroProfile Health Protocol](https://github.com/eclipse/microprofile-health/blob/master/spec/src/main/asciidoc/protocol-wireformat.adoc "Protocol")

### Configuration

Register the health chech classes in config/health.php

    return [
        /*
         * |--------------------------------------------------------------------------
         * | Health Checks
         * |--------------------------------------------------------------------------
         * |
         */

        \Health\Checks\NullCheck::class,
        \Health\Checks\SuccessfulCheck::class,
    ];

Add the api route

    Route::get('/health', 'Health\Controllers\HealthController@check');

### Custom Health Check


    use Health\Builder\HealthCheckResponseBuilder;

    class ServiceACheck implements HealthCheckInterface
    {

        /**
         *
         * {@inheritdoc}
         * @see \Health\Checks\HealthCheckInterface::call()
         */
        public function call()
        {
            $builder = new HealthCheckResponseBuilder();

            $health = $builder->name('Service A');

            if(!$this->serviceA->connect()) {
                $health->withData('error', 'Service A Failed')
                        ->state(false);
            }
            else {
                $health->state(true);
            }

            return $health->build();
        }
    }

