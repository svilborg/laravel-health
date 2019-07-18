<?php
namespace Health\Checks\Traits;

/**
 * Formatting operations
 */
trait FormatTrait
{

    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param mixed $size
     * @param integer $precision
     * @return string
     */
    public function formatBytes($size, $precision = 2)
    {
        $size = (int) $size;
        $base = $size > 0 ? log($size) / log(1024) : 0;

        $suffixes = [
            ' bytes',
            ' KB',
            ' MB',
            ' TB',
            ' GB'
        ];

        $value = $size > 0 ? round(pow(1024, $base - floor($base)), $precision) : 0;

        return $value . $suffixes[floor($base)];
    }
}
