# Laravel Health Check

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

### Examples
