<?php
namespace Health\Checks\File;

use Health\Checks\HealthCheckInterface;

class Json extends Base implements HealthCheckInterface
{

    /**
     *
     * @param string $file
     * @return boolean
     */
    protected function isValid($file)
    {
        return ! is_null(json_decode(@file_get_contents($file)));
    }
}
