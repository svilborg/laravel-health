<?php
namespace Health\Checks;

use DB;

class DatabaseCheck extends BaseCheck implements HealthCheckInterface
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
                $builder->state(false)->withData("error", "Could not find the database.");
            }
        } catch (\Exception $e) {
            $builder->state(false)->withData("error", "Could not open connection to database server.");
        }

        return $builder->build();
    }
}