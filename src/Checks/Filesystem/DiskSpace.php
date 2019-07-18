<?php
namespace Health\Checks\Filesystem;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;
use Health\Checks\Traits\FormatTrait;

class DiskSpace extends BaseCheck implements HealthCheckInterface
{

    use FormatTrait;

    /**
     * Default disk space threshold of 100 MB
     *
     * @var integer
     */
    const DEFAULT_THRESHOLD = 100000000;

    /**
     * Default Path
     *
     * @var string
     */
    const DEFAULT_PATH = '/';

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $path = $this->getParam('path', self::DEFAULT_PATH);
        $threshold = $this->getParam('threshold', self::DEFAULT_THRESHOLD);

        $free = disk_free_space($path);

        if ($free >= $threshold) {
            $builder->up();
        } else {
            $builder->down();
        }

        $builder->withData('free_bytes', $free)
            ->withData('free_human', $this->formatBytes($free))
            ->withData('path', $path)
            ->withData('threshold', $threshold);

        return $builder->build();
    }
}
