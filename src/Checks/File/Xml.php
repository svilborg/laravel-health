<?php
namespace Health\Checks\File;

use Health\Checks\HealthCheckInterface;

class Xml extends Base implements HealthCheckInterface
{

    /**
     *
     * @param string $file
     * @return boolean
     */
    protected function isValid($file)
    {
        $doc = new \DOMDocument();

        if (! @$doc->load($file)) {
            return false;
        }

        return true;
    }
}