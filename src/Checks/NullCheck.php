<?php
namespace Health\Checks;

use Health\Builder\HealthCheckResponseBuilder;

class NullCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritDoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = new HealthCheckResponseBuilder();
        $builder->name("Null")->state(true);

        // try {
        // DB::connection()->getPdo();
        // if(DB::connection()->getDatabaseName()){
        // echo "Yes! Successfully connected to the DB: " . DB::connection()->getDatabaseName();
        // }else{
        // die("Could not find the database. Please check your configuration.");
        // }
        // } catch (\Exception $e) {
        // die("Could not open connection to database server. Please check your configuration.");
        // }

        return $builder->build();
    }
}