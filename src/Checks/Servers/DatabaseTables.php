<?php
namespace Health\Checks\Servers;

use Health\Checks\HealthCheckInterface;
use DB;
use Health\HealthCheck;

class DatabaseTables extends Database implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $health = parent::call();

        if ($health->getState() == HealthCheck::STATE_UP) {

            $builder = $this->getBuilder();

            $tables = $this->params['tables'] ?? [];
            $missing = [];
            foreach ($tables as $table) {
                if (! DB::getSchemaBuilder()->hasTable($table)) {
                    $missing[] = $table;

                    $builder->down();
                }
            }

            if ($missing) {
                $builder->withData('missing', $missing);
            }

            $health = $builder->build();
        }

        return $health;
    }
}