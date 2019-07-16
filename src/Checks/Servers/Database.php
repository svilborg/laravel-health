<?php
namespace Health\Checks\Servers;

use DB;
use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;

class Database extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        try {
            DB::connection()->getPdo();
            if (! DB::connection()->getDatabaseName()) {
                $builder->down()->withData("error", "Could not find the database.");
            }
        } catch (\Exception $e) {
            $builder->down()->withData("error", "Could not open connection to database server.");
        }

        return $builder->build();
    }
}