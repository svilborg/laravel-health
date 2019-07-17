<?php
namespace Health\Checks\File;

use Health\Checks\HealthCheckInterface;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

class Yaml extends Base implements HealthCheckInterface
{

    /**
     *
     * @param string $file
     * @return boolean
     */
    protected function isValid($file)
    {
        if (function_exists('yaml_parse_file')) {
            return (@yaml_parse_file($file) === false) ? false : true;
        }

        if (class_exists('Symfony\Component\Yaml\Parser')) {
            try {
                (new Parser())->parse(file_get_contents($file));
            } catch (ParseException $e) {
                return false;
            }

            return true;
        }

        return false;
    }
}