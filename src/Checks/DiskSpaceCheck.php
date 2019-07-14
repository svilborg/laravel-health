<?php
namespace Health\Checks;

class DiskSpaceCheck extends BaseCheck implements HealthCheckInterface
{

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
        $builder = $this->getBuilder(self::class);

        $path = $this->params['path'] ?? self::DEFAULT_PATH;
        $threshold = $this->params['threshold'] ?? self::DEFAULT_THRESHOLD;

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