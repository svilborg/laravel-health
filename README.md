# Laravel Health Check


[![Build Status](https://travis-ci.org/svilborg/laravel-health.svg?branch=master)](https://travis-ci.org/svilborg/laravel-health)
[![Latest Stable Version](https://img.shields.io/packagist/v/svilborg/laravel-health.svg)](https://packagist.org/packages/svilborg/laravel-health)
[![License](https://img.shields.io/packagist/l/svilborg/laravel-health.svg)](https://github.com/svilborg/laravel-health/blob/master/LICENSE)

Implementation of MicroProfile Health for Laravel

[MicroProfile Health Protocol](https://github.com/eclipse/microprofile-health/blob/master/spec/src/main/asciidoc/protocol-wireformat.adoc "Protocol")

### Configuration

Register the health check classes in config/health.php

```php
    return [
        /*
         * |--------------------------------------------------------------------------
         * | Health Checks
         * |--------------------------------------------------------------------------
         * |
         */

        \Health\Checks\NullCheck::class,
    ];
```

Add the api route

```php
    Route::get('/health', 'Health\Controllers\HealthController@check');
```

### Custom Health Check

```php
    use Health\Checks\BaseCheck;
    use Health\Checks\HealthCheckInterface;

    class ServiceACheck extends BaseCheck implements HealthCheckInterface
    {

        /**
         *
         * {@inheritdoc}
         * @see \Health\Checks\HealthCheckInterface::call()
         */
        public function call()
        {
            $health = $this->getBuilder('Service A');

            if(!$this->serviceA->connect()) {
                $health->withData('error', 'Service A Failed')
                        ->down();
            }
            else {
                $health->up();
            }

            return $health->build();
        }
    }
```
