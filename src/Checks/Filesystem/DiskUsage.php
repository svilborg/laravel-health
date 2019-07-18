<?php
namespace Health\Checks\Filesystem;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;
use Health\Checks\Traits\FormatTrait;

class DiskUsage extends BaseCheck implements HealthCheckInterface
{

    use FormatTrait;

    /**
     * Default disk usage threshold of 1 %
     *
     * @var integer
     */
    const DEFAULT_THRESHOLD = 1;

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

        if ($threshold > 100 || $threshold < 0) {
            return $builder->down()->withData('error', 'Invalid Threshold - ' . $threshold);
        }

        $free = disk_free_space($path);
        $total = disk_total_space($path);
        $usage = $total - $free;
        $percentage = ($usage / $total) * 100;

        if ($percentage >= $threshold) {
            $builder->up();
        } else {
            $builder->down();
        }

        $builder->withData('free_bytes', $free)
            ->withData('free_human', $this->formatBytes($free))
            ->withData('usage', $usage)
            ->withData('usage_human', $this->formatBytes($usage))
            ->withData('path', $path)
            ->withData('threshold', $threshold);

        return $builder->build();
    }
}
