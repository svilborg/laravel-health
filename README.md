# Laravel Health Check


[![Build Status](https://travis-ci.org/svilborg/laravel-health.svg?branch=master)](https://travis-ci.org/svilborg/laravel-health)
[![Coverage](https://codecov.io/gh/svilborg/laravel-health/branch/master/graph/badge.svg)](https://codecov.io/gh/svilborg/laravel-health)
[![Quality Score](https://img.shields.io/scrutinizer/g/svilborg/laravel-health.svg)](https://scrutinizer-ci.com/g/svilborg/laravel-health)
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

        'checks' => [
             [
                 'class' => \Health\Checks\NullCheck::class,
                 'params' => []
             ],
             [
                 'class' => \Health\Checks\Servers\Database::class,
                 'params' => []
             ],
             [
                 'class' => \Health\Checks\Filesystem\DiskSpace::class,
                 'params' => [
                    'path' => '/'
                 ]
             ],
             [
                'class' => \Health\Checks\Env\Environment::class,
                'params' => [
                     'APP_ENV' => 'testing'
                 ]
             ]
        ]
    ];
```

Add the api route

```php
    Route::get('/health', 'Health\Controllers\HealthController@check');
```

### Example Response Payload

```json

{
    "status": "UP",
    "checks": [
        {
            "name": "health-checks-null-check",
            "status": "UP",
            "data": []
        },
        {
            "name": "health-checks-filesystem-disk-space",
            "status": "UP",
            "data": {
                "free_bytes": 119100669952,
                "free_human": "110.92 GB",
                "path": "/",
                "threshold": 100000000
            }
        },
        {
            "name": "health-checks-env-environment",
            "status": "UP",
            "data": {
                "variable": "APP_ENV",
                "value": "testing",
                "value_expected": "testing"
            }
        },
        {
            "name": "health-checks-filesystem-directory-is-readable",
            "status": "UP",
            "data": {
                "paths": [
                    "../tests"
                ]
            }
        },
        {
            "name": "health-checks-filesystem-file-is-readable",
            "status": "UP",
            "data": {
                "files": [
                    "TestCase.php"
                ]
            }
        }
    ]
}

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
