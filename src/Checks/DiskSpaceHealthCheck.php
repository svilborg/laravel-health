<?php
namespace Health\Checks;

use Health\Builder\HealthCheckResponseBuilder;

class DiskSpaceHealthCheck implements HealthCheckInterface
{

    /**
     * Default disk space threshold of 100 MB
     *
     * @var integer
     */
    const DEFAULT_THRESHOLD = 100000000;

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = new HealthCheckResponseBuilder();
        $builder->name(self::class);

        $free = disk_free_space('/');

        $builder->withData('free_bytes', $free)->withData('free_human', $this->formatBytes($free));

        if ($free >= self::DEFAULT_THRESHOLD) {
            $builder->up();
        } else {
            $builder->down();
        }

        return $builder->build();
    }

    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param integer $size
     * @param integer $precision
     * @return string
     */
    private function formatBytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = [
                ' bytes',
                ' KB',
                ' MB',
                ' GB',
                ' TB'
            ];

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size . ' bytes';
        }
    }
}