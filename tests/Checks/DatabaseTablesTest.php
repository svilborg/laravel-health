<?php
namespace Tests\Checks;

use Health\Checks\Servers\DatabaseTables;
use Schema;

class DatabaseTablesTest extends CheckTestCase
{

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => ''
        ]);
    }

    public function testCheckUpForEmptyTablesList()
    {
        $this->assertCheck($this->runCheck(DatabaseTables::class), 'UP');
    }


    public function testCheckUpForExistingNonExistingTable()
    {
        Schema::create('users', function ($table) {
            $table->increments('id');
        });

        $check = $this->runCheck(DatabaseTables::class, [
            'tables' => [
                'users'
            ]
        ]);

        $this->assertCheck($check, 'UP');

        Schema::drop('users');

        $check = $this->runCheck(DatabaseTables::class, [
            'tables' => [
                'users'
            ]
        ]);

        $this->assertCheck($check, 'DOWN');
    }
}