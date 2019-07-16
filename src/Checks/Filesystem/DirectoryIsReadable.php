<?php
namespace Health\Checks\Filesystem;

use Health\Checks\HealthCheckInterface;
use Health\Checks\BaseCheck;

class DirectoryIsReadable extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $paths = $this->params['paths'] ?? [];

        foreach ($paths as $path) {
            if (! is_dir($path) || ! is_readable($path)) {
                $builder->down()->withData('path', $path);
            }
        }

        $builder->withData('paths', $paths);

        return $builder->build();
    }
}