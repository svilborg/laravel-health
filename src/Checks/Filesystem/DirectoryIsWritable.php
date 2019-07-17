<?php
namespace Health\Checks\Filesystem;

use Health\Checks\HealthCheckInterface;
use Health\Checks\BaseCheck;

class DirectoryIsWritable extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $paths = $this->getParam('paths', []);

        foreach ($paths as $path) {
            if (! is_dir($path) || ! is_writeable($path)) {
                $builder->down()->withData('path', $path);
            }
        }

        $builder->withData('paths', $paths);

        return $builder->build();
    }
}