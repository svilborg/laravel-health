<?php
namespace Health\Checks\Filesystem;

use Health\Checks\HealthCheckInterface;
use Health\Checks\BaseCheck;

class FileIsWritable extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $files = $this->params['files'] ?? [];

        foreach ($files as $file) {
            if (! is_file($file) || ! is_writeable($file)) {
                $builder->down()->withData('file', $file);
            }
        }

        $builder->withData('files', $files);

        return $builder->build();
    }
}