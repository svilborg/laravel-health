<?php
namespace Health\Checks\File;

use Health\Checks\HealthCheckInterface;

class Ini extends Base implements HealthCheckInterface
{

    /**
     *
     * @param string $file
     * @return boolean
     */
    protected function isValid($file)
    {
        return @parse_ini_file($file) !== false;
    }
}